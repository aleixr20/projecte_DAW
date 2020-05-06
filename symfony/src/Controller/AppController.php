<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'Admin',
        ]);
    }

    /**
     * @Route("/profile/{userName}", name="userProfile")
     */
    public function userProfile($userName)
    {

        if ($this->getUser()->getEmail() != $userName) {
            return $this->redirectToRoute('index');
        }

        return $this->render('app/index.html.twig', [
            'controller_name' => $userName,
        ]);
    }

}
