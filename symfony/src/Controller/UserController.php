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
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
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
     * @Route("/user/profile", name="userProfileRedirect")
     */
    public function userProfile()
    {
        // if (!$this->getUser()) {
        //     return $this->redirectToRoute('app_login');
        // }

        // return $this->redirectToRoute('userProfile', [
        //     'userName' => $this->getUser()->getEmail()
        // ]);
    }

    /**
     * AQUEST METODE EL TENIAS AL AppController (repetit)
     * 
     * @Route("/profile/{userName}", name="userProfile")
     */
    public function userProfile2($userName)
    {
        if ($this->getUser()->getEmail() != $userName) {
            return $this->redirectToRoute('index');
        }

        return $this->render('app/index.html.twig', [
            'controller_name' => $userName,
        ]);
    }



    /**
     * METODE PER EDITAR EL PERFIL D'UN USUARI
     * @Route("/profile", name="userProfileRedirect")
     */
    public function userProfileRedirect()
    {

        /**
         * HI HA UNA ALGORITME TIPIC PER ALS INSERT/UPDATE
         * ES SEMPRE EL MATEIXA (COPIAR DEL FORM DE REGISTRE PER EXEMPLE)
         * 
         * 1- CREAR NOU USUARI / FER GET DE TOTS ELS VALORS DEL USUARI
         * 2- CREAR FORMULARI
         * 3- if summited -> USER->set.... + manager->flush
         * 4- else RENDER FORM
         */

        // if (!$this->getUser()) {
        //     return $this->redirectToRoute('app_login');
        // }

        // return $this->redirectToRoute('userProfile', [
        //     'userName' => $this->getUser()->getEmail()
        // ]);
    }
}
