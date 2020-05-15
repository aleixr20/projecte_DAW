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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class UserController extends AbstractController
{
    /**
     * JO UNIFICARIA AQUI TOTS ELS METODES RELACIONATS AMB ELS USUARIS
     * 
     * Per exemple:
     * Registre, Login, veure perfil, editar perfil
     * 
     **********************************************************************/



    /**
     * REGISTRE DE NOU USUARI
     * AQUEST METODE ES POT MILLORAR AMB UN FORMULARI PERSONALITZAT
     * I AFEGINT ELS CAMPS QUE TROBEM NECESSARIS
     * @Route("/user/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, SluggerInterface $slugger): Response
    {
        if ($this->getUser()) {
            //return $this->redirectToRoute('index');
            return $this->redirectToRoute('homepage');
        }

        $user = new User();

        /**
         * Aquest RegistrationFormType es generic i ve per defecte amb Syfony
         * quan es fa allò del make:auth, pero es 100% customizable
         */
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
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            //Aquest return em sembla que es el que et fa l'autologin
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );

            // return $this->redirectToRoute('homepage');
            // return $this->redirectToRoute('userProfile', [
            //     'userName' => $user->getEmail()
            // ]);
        }

        // return $this->render('registration/register.html.twig', [
        return $this->render('user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    /**
     * METODE DE LOGIN
     * S'HAN D'AFEGIR ALGUNS USUARIS A DataFixtures PER FER PROVES
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
     * @Route("/user/profile", name="userProfile")
     */
    public function userProfile()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $this->getUser(),
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
    public function otherUserProfile($userName, UserRepository $userRepository)
    {
        if($userRepository->findOneBy(['nom_usuari' => $userName])){
            $user = $userRepository->findOneBy(['nom_usuari' => $userName]);
        }else{
            throw new Error("No existeix l'usuari");
        }
        

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
