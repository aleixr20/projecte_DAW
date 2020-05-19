<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailGenerator
{
    private $mailer;
    private $controller;

    public function __construct(\Swift_Mailer $mailer, AbstractController $controller)
    {
        $this->mailer = $mailer;
        $this->controller = $controller;
    }

    public function sendVerificationMail($user)
    {
        $message = (new \Swift_Message('Email de verificació'))
            ->setFrom('bnerdtodev@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->controller->renderView(
                    // templates/emails/registration.html.twig
                    'emails/registration.html.twig',[
                    'name' => $user->getNom(),
                    'token' => $user->getToken()
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);

        return $this->controller->redirectToRoute('app_login');
    }
}


