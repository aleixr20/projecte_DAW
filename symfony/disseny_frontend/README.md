# Projecte Final | Prototips Frontend

CFGS Denevolupament d'Applicacions amb tecnologia Web   
M12 Projecte final de cicle    
Grup 7 | [Aleix](https://github.com/aleixr20), [Adam](https://github.com/adamjalich), [Roger](https://github.com/rogercrdaw)   
 

## index_base.html
Protopip d'HTML amb la estrucutra de d'etiquetes que hauria de ser identica en altres formats de frontend    
🛠 Aquesta versió al ser pur HTML no requereix d'un servidor actiu

## index_vue_v1.html
~~Versio adaptada amb variables VUE que renderitza informació interactiva **ja definida en variable data**
🛠 Aquesta versió al no interactuar amb la API de symfony no requereix d'un servidor actiu~~    
Durectament he saltat la versio API

## index_vue_api.html
Versio adaptada amb VUE que renderitza la info que rep de la API de Symfony    
🛠 Aquesta versió depen de consultes API. Es poden fer proves amb altres API, pero en cas de utilitzar la mateixa API del Symfony d'aquest repository, serà necessari iniciar el servidor, tant apache, com mysql.
- crear base de dades **frontend_v1** o la que volgueu (canviar llavors valors a _.env_)
- Eliminar si existeixen arxus de migracions anteriors (_src/Migrations/..._)
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate
- php bin/console doctrine:fixtures:load
- symfony server:start

## twig_templates
Carpeta amb l'estructura d'arxius twig que implementen la versió bura (base) d'HTML    
🛠 Aquesta versió renderitza el frontend del HomePageController amb el classic

```        
         return $this->render('homepage/index.html.twig', [    
            ... => ...,    
            ... => ...    
         ]);
```

Per tant s'hauran de realitzar els els mateixos pasos que en la versió 2 de VUE    
- Servidor Apache (PHP i mySQL)
- crear base de dades **frontend_v1** o la que volgueu (canviar llavors valors a _.env_)
- Eliminar si existeixen arxus de migracions anteriors (_src/Migrations/..._)
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate
- php bin/console doctrine:fixtures:load
- symfony server:start


---
😵 Fucking Quarantine !!   
😉 by RC [InsPedralbes](https://inspedralbes.cat)
