LABS:

1- Copiar projecte a public_html

2- chmod -R 777

3- Arxiu .env

    APP_ENV=PROD
    DATABASE_URL=*mysql://db_user:db_password@127.0.0.1:3306/db_name*

3BIS- Si es necessari:

    php bin/console doctrine:migrations:migrate

4- php bin/console cache:clear --env PROD

5- composer require symfony/apache-pack

6-  Desde public_html -> ln -s nomprojecte/public/ (es pot canviar el nom de l'enllaç simbolic per que la url sigui més intuïtiva)

 

Ruta del projecte: http://labs.iam.cat/~a14alerevagu/prova/

Pàgina principal del projecte: http://labs.iam.cat/~a14alerevagu/web/

Ruta de prova: http://labs.iam.cat/~a14alerevagu/web/prova