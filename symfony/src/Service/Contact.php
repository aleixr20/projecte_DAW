<?php

namespace App\Service;

use Error;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Mailer;
use Exception;

class Contact
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getForm()
    {

        $request = Request::createFromGlobals();
        
        if($request->request->get('name') != null){

            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');

            $this->mailer->sendContactMail($name, $email, $subject, $message);
        }
        
    }
}


