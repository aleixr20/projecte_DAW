<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\TokenRecoverType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;
use Error;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use DateTimeZone;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\Mailer;
use App\Service\QueryBuilder;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{

    /**
     * REGISTRE DE NOU USUARI
     * @Route("/user/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, Mailer $mailer, QueryBuilder $queryBuilder, UserRepository $userRepository): Response
    {
        //Si hi ha un usuari logejat, redirigir a homepage
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        //crear usuari i formulari del tipus User
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        //Si estem en un Submit (el formulari conte dades)
        if ($form->isSubmitted() && $form->isValid()) {
            // Codificar password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //Com l'usuari encara no ha verifict mail, assignar ROLE_USER per defecte
            $user->setRoles(["ROLE_USER"]);
            $dataRegistre = new \DateTime();
            $dataRegistre->setTimezone(new DateTimeZone('Europe/Madrid'));
            $user->setDataRegistre($dataRegistre);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Crear token
            $userRepository->generateToken($user);
            // Enviar mail de verificació
            $mailer->sendVerificationMail($user);
            // AUTODESTRUCCIÓ DEL TOKEN (1 HORA)
            $queryBuilder->autoDestroyToken($user);

            //Redirigir a homepage amb missatge
            //Aquesta part la podem millorar per un modal
            return $this->render('error.html.twig', [
                'tokenPendent' => true,
            ]);
        }

        //Si no hi habia Submit, redirigir a formulari en blanc (nou registre)
        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * VERIFICACIÓ DE NOU USUARI
     * @Route("/user/verificacio/{token}", name="verificar_compte")
     */
    public function verificar($token, UserRepository $userRepository): Response
    {

        //Buscar el usuari amb aquest token
        $user = $userRepository->findOneBy([
            'token' => $token
        ]);

        if ($user) { //Nomes si s'ha trobat l'usuari
            $user->addRole("ROLE_VALIDATED");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //Redirigir a homepage amb missatge
            //Aquesta part la podem millorar per un modal            
            return $this->render('error.html.twig', [
                'tokenPendent' => false,
                // 'error_msg' => 'El nom d\'usuari no es correspon amb aquest mail'
            ]);
        }

        //Per defecte (no s'ha trobat el token o està caducat)
        //Redirigir a homepage amb missatge
        //Aquesta part la podem millorar per un modal
        return $this->render('error.html.twig', [
            'tokenCaducat' => true,
        ]);
    }

    /**
     * RECUPERACIO DE TOKEN
     * @Route("/user/tokenRecover", name="app_token_recover")
     */
    public function tokenRecover(Request $request, Mailer $mailer, QueryBuilder $queryBuilder, UserRepository $userRepository): Response
    {

        //crear usuari i formulari del tipus TokenRecover
        $user = new User();
        $form = $this->createForm(TokenRecoverType::class, $user);
        $form->handleRequest($request);

        //Si estem en un Submit (el formulari conte dades)
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $userRepository->findOneBy(['email' => $form->get('email')->getData()]);

            //Si el mail no coincideix amb el nom d'usuari, redirig a homepage amb error
            if ($user->getNomUsuari() != $form->get('nom_usuari')->getData()) {
                return $this->render('error.html.twig', [
                    'tokenCaducat' => true,
                ]);
            } else {
                $userRepository->generateToken($user); // Crear token
                $mailer->sendVerificationMail($user); // Enviar mail de verificació
                $queryBuilder->autoDestroyToken($user); // AUTODESTRUCCIÓ DEL TOKEN (1 HORA)
            }
            //Redirigir a homepage amb missatge de mail enviat
            return $this->render('error.html.twig', [
                'tokenPendent' => true,
            ]);
        }

        //Si no hi habia Submit, redirigir a formulari en blanc (nou registre)
        return $this->render('user/tokenRecover.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * METODE DE LOGIN
     * @Route("/user/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * LOGOUT (sin comentarios)
     * NOMES S'HA DE GESTIONAR CAP ON ES REDIRIGEIX UN USUARI AFTER-LOGOUT
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * METODE PER VEURE EL PERFIL D'UN USUARI
     * ELS SEUS POSTS, COMENTARIS, VOTS +/-, LINKEDIN....
     * @Route("/user/{username}", name="userProfile")
     */
    public function userProfile($username, UserRepository $userRepository)
    {
        //Aqui podem fer algun comptador de visites i limitar les visites anonimes per IP
        // if (!$this->getUser()) {
        //     return $this->redirectToRoute('app_login');
        // }

        $user = $userRepository->findOneBy(['nom_usuari' => $username]);
        if ($user == null) {
            //Aqui hauriem de redirigir a una pagina 404
            // o una pagina amb un missatge de usuari no trobat
            throw new Error("No existeix l'usuari");
        }

        //Si ha trobat un usari, mostrar el perfil
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * METODE PER EDITAR EL PERFIL D'UN USUARI
     * @Route("/user/{username}/edit", name="userProfileEdit")
     */
    public function userProfileEdit($username, Request $request, SluggerInterface $slugger)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneBy(['nom_usuari' => $username]);
        } else {
            $user = $this->getUser();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Pujada de la imatge de perfil
            $imatgePerfil = $form->get('imatge')->getData();

            // this condition is needed because the 'imatge' field is not required
            // so the image file must be processed only when a file is uploaded
            if ($imatgePerfil && ($imatgePerfil->getClientMimeType() == 'image/png' || $imatgePerfil->getClientMimeType() == 'image/jpeg' || $imatgePerfil->getClientMimeType() == 'image/gif')) {
                $nomArxiuOriginal = pathinfo($imatgePerfil->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $nomArxiu = $slugger->slug($nomArxiuOriginal);
                $nouNomArxiu = $nomArxiu . '-' . uniqid() . '.' . $imatgePerfil->guessExtension();

                // Move the file to the directory where imatges are stored
                try {
                    $imatgePerfil->move('img/imatges_perfil', $nouNomArxiu);
                } catch (FileException $e) {
                    throw new Error($e);
                }

                // updates the 'imatge' property to store the image file name
                // instead of its contents
                $user->setImatge($nouNomArxiu);
            } else if ($imatgePerfil && !($imatgePerfil->getClientMimeType() == 'image/png' || $imatgePerfil->getClientMimeType() == 'image/jpeg' || $imatgePerfil->getClientMimeType() == 'image/gif')) {
                return $this->render('user/edit.html.twig', [
                    'editForm' => $form->createView(),
                    'error' => 'La imatge seleccionada no és vàlida.'
                ]);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('userProfile', [
                'username' => $user->getNomUsuari()
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'editForm' => $form->createView(),
        ]);
    }

    /**
     * METODE PER CANVIAR LA CONTRASENYA D'UN USUARI
     * @Route("/user/profile/edit/password", name="userChangePassword")
     */
    public function canviaContrasenya(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

        $form = $this->createFormBuilder()
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Contraseña actual',
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Contraseña nueva'
            ])
            ->add('repitNewPassword', PasswordType::class, [
                'label' => 'Repite la contraseña',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
                'attr' => ['class' => 'btn btn-outline-secondary']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            if ($passwordEncoder->isPasswordValid($user, $data['oldPassword'])) {

                if ($data['newPassword'] == $data['repitNewPassword']) {

                    $encodedPassword = $passwordEncoder->encodePassword($user, $data['newPassword']);

                    $user->setPassword($encodedPassword);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $this->redirectToRoute('userProfile');
                } else {

                    return $this->render('user/change_password.html.twig', [
                        'changePasswordForm' => $form->createView(),
                        'error' => 'Las contraseñas no coinciden.'
                    ]);
                }
            } else {

                return $this->render('user/change_password.html.twig', [
                    'changePasswordForm' => $form->createView(),
                    'error' => 'La contraseña actual no es correcta.'
                ]);
            }
        }


        return $this->render('user/change_password.html.twig', [
            'changePasswordForm' => $form->createView(),
        ]);
    }

    /**
     * METODE PER COMPROVAR SI UN NOM D'USUARI EXISTEIX (API en JSON)
     * @Route("/user/validateUsername/{userName}", name="usernameExists")
     */
    public function checkUniqueUsername($userName, UserRepository $userRepository)
    {
        $userExists = false;

        if ($userRepository->findOneBy(['nom_usuari' => $userName])) {
            $userExists = true;
        }

        $data[] = ['usernameExists' => $userExists];

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
     * METODE PER VEURE EL PERFIL D'UN ALTRE USUARI en JSON
     * @Route("/user/profile/{userName}", name="otherUserProfile")
     */
    public function otherUserProfile($userName, UserRepository $userRepository, SerializerInterface $serializer)
    {
        if ($userRepository->findOneBy(['nom_usuari' => $userName])) {
            $user = $userRepository->findOneBy(['nom_usuari' => $userName]);
        } else {
            throw new Error("No existe el usuario");
        }

        $userJson = $serializer->serialize($user, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new JsonResponse(json_decode($userJson));

        // return $this->render('user/profile.html.twig', [
        //     'user' => $user,
        // ]);
    }
}
