<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationController extends AbstractController
{

    /**
     * HO DEIXO TOT COMENTAT JA QUE ELS METODES ELS HE PASSAT
     * PROVISIONALMENT AL UserController
     * SI NO PETA (QUE NO HO FARÀ, HO L'ELIMINAREM)
     *
     *********************************************************/


    // /**
    //  * @Route("/register", name="app_register")
    //  */
    // public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    // {

    //     if ($this->getUser()) {
    //         return $this->redirectToRoute('index');
    //     }

    //     $user = new User();
    //     $form = $this->createForm(RegistrationFormType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // encode the plain password
    //         $user->setPassword(
    //             $passwordEncoder->encodePassword(
    //                 $user,
    //                 $form->get('plainPassword')->getData()
    //             )
    //         );

    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($user);
    //         $entityManager->flush();

    //         // do anything else you need here, like send an email

    //         return $this->redirectToRoute('userProfile',[
    //             'userName' => $user->getEmail()
    //         ]);
    //     }

    //     return $this->render('registration/register.html.twig', [
    //         'registrationForm' => $form->createView(),
    //     ]);
    // }
}
