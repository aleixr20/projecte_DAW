<?php

namespace App\Service;

use Exception;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Twig\Environment;

class Mailer
{
    private $mailer;
    private $router;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, Environment $twig, RouterInterface $router)
    {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->twig = $twig;

    }

    public function sendVerificationMail($user)
    {
        $message = (new \Swift_Message('Email de verificació'))
            ->setFrom('bnerdtodev@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/registration.html.twig',[
                    'name' => $user->getNom(),
                    'token' => $user->getToken()
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function sendContactMail($name, $email, $subject, $message)
    {
        $message = (new \Swift_Message('Email de verificació'))
            ->setFrom('bnerdtodev@gmail.com')
            ->setTo('bnerdtodev@gmail.com')
            ->setSubject('Nou contacte')
            ->setBody(
                $this->twig->render(
                    'emails/contact.html.twig',[
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}


