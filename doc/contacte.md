El formulari de contacte està "hardcoded" al template /home/ca_section4.html.twig

D'aquesta forma no es renderitza com a FormType de Symfony, però les dades que recull si han de ser manipulades per Symfony.

Per tant un cop intriduides les dades al formulari, aquestes s'envien per POST a un Service de Symfony.

	<form action="{{ contact_service.getForm() }}" method="POST">

Aquest Service haurà d'estar definit a services.yaml i se l'ha d'assignar a un alias per que el pugui utilitzar twig.

	App\Service\Contact:
        	public: false

    	app.contact:
        	alias: App\Service\Contact
        	public: true

I ara definim aquest alias com una variable global per Twig a twig.yaml

	twig:
		globals:
        		contact_service: "@app.contact"

Aquesta variable global es la que li hem passat al action del form fent referència al service.

Ara ja podem manipular les dades des de la funció getForm() del service, però hem de tenir en compte que no es fa de la mateixa forma que a PHP pur.

	$name = $_POST['name'] -----> NO ES VÀLID

En symfony existeix el metode createFromGlobals() de la clase Request que recull les dades

	$request = Request::createFromGlobals();
	$name = $request->request->get('name');