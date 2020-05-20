<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationFormType;
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
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, SluggerInterface $slugger, Mailer $mailer, QueryBuilder $queryBuilder, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //AQUI HAURIEM D'ASSIGNAR UN ROLE USER PER DEFECTE
            $user->setRoles(["ROLE_USER"]);
            $dataRegistre = new \DateTime();
            $dataRegistre->setTimezone(new DateTimeZone('Europe/Madrid'));
            $user->setDataRegistre($dataRegistre);

            //Pujada de la imatge de perfil
            // $imatgePerfil = $form->get('imatge')->getData();

            // // this condition is needed because the 'imatge' field is not required
            // // so the image file must be processed only when a file is uploaded
            // if ($imatgePerfil && ($imatgePerfil->getClientMimeType() == 'image/png' || $imatgePerfil->getClientMimeType() == 'image/jpeg' || $imatgePerfil->getClientMimeType() == 'image/gif')) {
            //     $nomArxiuOriginal = pathinfo($imatgePerfil->getClientOriginalName(), PATHINFO_FILENAME);
            //     // this is needed to safely include the file name as part of the URL
            //     $nomArxiu = $slugger->slug($nomArxiuOriginal);
            //     $nouNomArxiu = $nomArxiu.'-'.uniqid().'.'.$imatgePerfil->guessExtension();

            //     // Move the file to the directory where imatges are stored
            //     try {
            //         $imatgePerfil->move('img/imatges_perfil', $nouNomArxiu);
            //     } catch (FileException $e) {
            //         throw new Error($e);
            //     }

            //     // updates the 'imatge' property to store the image file name
            //     // instead of its contents
            //     $user->setImatge($nouNomArxiu);
            // }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // CREAR TOKEN
            $userRepository->generateToken($user);
            // CORREU DE VERIFICACIÓ
            $mailer->sendVerificationMail($user);
            // AUTODESTRUCCIÓ DEL TOKEN (1 HORA)
            $queryBuilder->autoDestroyToken($user);

            return $this->redirectToRoute('correct_registration', [
                'userId' => $user->getId(),
            ]);
        }

        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * REENVIAMENT DEL TOKEN
     * @Route("/user/correct_registration/{userId}", name="correct_registration")
     */
    public function correctRegistration($userId, UserRepository $userRepository, Mailer $mailer, QueryBuilder $queryBuilder): Response
    {

        $user = $userRepository->findOneBy(['id' => $userId]);

        foreach($user->getRoles() as $role){
            if ($role == "ROLE_ADMIN" || $role == "ROLE_VALIDATED") {
                return $this->redirectToRoute('profileUser', [
                    'userId' => $user->getId(),
                ]);
            }
        }

        return $this->render('user/verify_email.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * REENVIAMENT DEL TOKEN
     * @Route("/user/reenviament_token/{userId}", name="reenviament_token")
     */
    public function reenviamentToken($userId, UserRepository $userRepository, Mailer $mailer, QueryBuilder $queryBuilder): Response
    {

        $user = $userRepository->findOneBy(['id' => $userId]);

        // CREAR TOKEN
        $userRepository->generateToken($user);
        // CORREU DE VERIFICACIÓ
        $mailer->sendVerificationMail($user);
        // AUTODESTRUCCIÓ DEL TOKEN (1 HORA)
        $queryBuilder->autoDestroyToken($user);

        return $this->render('user/verify_email.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * VERIFICACIÓ DE NOU USUARI
     * @Route("/user/verificacio/{token}", name="verificar_compte")
     */
    public function verificar($token, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy([
            'token' => $token
        ]);

        if($user){
            $user->addRole("ROLE_VALIDATED");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/verificated.html.twig', [
            'user' => $user
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

        // return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
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
    public function userProfile($username,UserRepository $userRepository)
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

            // return $this->render('user/profile.html.twig', [
            //     'user' => $user
            // ]);
        }
        //Si ha trobat un usari, mostrar el perfil
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * METODE PER EDITAR EL PERFIL D'UN USUARI
     * @Route("/user/profile/edit", name="userProfileEdit")
     */
    public function userProfileEdit(Request $request, SluggerInterface $slugger)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();

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
                $nouNomArxiu = $nomArxiu.'-'.uniqid().'.'.$imatgePerfil->guessExtension();

                // Move the file to the directory where imatges are stored
                try {
                    $imatgePerfil->move('img/imatges_perfil', $nouNomArxiu);
                } catch (FileException $e) {
                    throw new Error($e);
                }

                // updates the 'imatge' property to store the image file name
                // instead of its contents
                $user->setImatge($nouNomArxiu);
            }else if($imatgePerfil && !($imatgePerfil->getClientMimeType() == 'image/png' || $imatgePerfil->getClientMimeType() == 'image/jpeg' || $imatgePerfil->getClientMimeType() == 'image/gif')){
                return $this->render('user/edit.html.twig', [
                    'editForm' => $form->createView(),
                    'error' => 'La imatge seleccionada no és vàlida.'
                ]);
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('userProfile');
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
                'label' => 'Contrasenya actual',
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Contrasenya nova'
            ])
            ->add('repitNewPassword', PasswordType::class, [
                'label' => 'Repeteix la contrasenya',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Desa',
                'attr' => ['class' => 'btn btn-outline-info']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();

            if($passwordEncoder->isPasswordValid($user, $data['oldPassword'])) {

                if($data['newPassword'] == $data['repitNewPassword']) {

                    $encodedPassword = $passwordEncoder->encodePassword($user, $data['newPassword']);

                    $user->setPassword($encodedPassword);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $this->redirectToRoute('userProfile');

                }else{

                    return $this->render('user/change_password.html.twig', [
                        'changePasswordForm' => $form->createView(),
                        'error' => 'Les contrasenyes no coincideixen.'
                    ]);

                }
            }else{

                return $this->render('user/change_password.html.twig', [
                    'changePasswordForm' => $form->createView(),
                    'error' => 'La contrasenya actual no es correcte.'
                ]);
            }
        }


        return $this->render('user/change_password.html.twig', [
            'changePasswordForm' => $form->createView(),
        ]);
    }

    /**
     * METODE PER VEURE EL PERFIL D'UN ALTRE USUARI
     * @Route("/user/profile/{userName}", name="otherUserProfile")
     */
    public function otherUserProfile($userName, UserRepository $userRepository, SerializerInterface $serializer)
    {
        if($userRepository->findOneBy(['nom_usuari' => $userName])){
            $user = $userRepository->findOneBy(['nom_usuari' => $userName]);
        }else{
            throw new Error("No existeix l'usuari");
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
