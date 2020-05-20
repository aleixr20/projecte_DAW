VALIDACIÓ DE REGISTRE PER CORREU

Necesstiarem swiftmailer:
	composer require symfony/swiftmailer-bundle

1- L'entitat usuari tindrà un nou atribut "token"

2- Aquest token es generarà automàticament al fer el registre de l'usuari:

	$user->setToken(bin2hex(random_bytes(50)));

3- Al controlador, un cop regitrat l'usuari a la bbdd enviarem un correu de verificació:

	$message = (new \Swift_Message('Email de verificació'))
            ->setFrom('bnerdtodev@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/registration.html.twig',[
                    'name' => $user->getNom(),
                    'token' => $user->getToken()
                    ]
                ),
                'text/html'
            );

            $mailer->send($message);

	(si hi havia una funció de login aitomàtic la treiem)

4- L'arxiu que es renderitza per el correu haurà de portar un enllaç a una ruta del controlador amb el toquen:

	<a href="{{ url('verificar_compte', {'token': token})}}">Verificar correu!</a>

5- El controlador d'aquesta ruta buscarà l'usuari que té aquest toquen:

	$user = $userRepository->findOneBy([
            'token' => $token
        ]);

6- Després li assignarà un role per diferenciar-lo dels que no estàn validas i ho persistirà a la bbdd:

	if($user){
            $user->addRole("ROLE_VALIDATED");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

7- Per últim es pot tornar renderitzar una pàgina de confirmació o el que es vulgui fer.


CONTROL DE LOGIN D'USUARIS NO VALIDATS

1- Anirem a la funció getUser() de src/Security/LoginFOrmAuthenticator.php, aquesta funció rep l'usuari inserit al login.

2- Comprovem si l'usuari conté en l'array de roles el ROLE_VALIDATED, en aquest cas amb el ROLE_ADMIN podrà accedir també.

	$validated = false;
        foreach($user->getRoles() as $role){
            if ($role == "ROLE_ADMIN" || $role == "ROLE_VALIDATED") {
                $validated = true;
                break;
            }
        }

3- Si no està validat enviarem un missatge d'error al formulari:

	if($validated == false){
            throw new CustomUserMessageAuthenticationException('Verifica el teu correu.');
        }









