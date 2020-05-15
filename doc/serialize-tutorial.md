SERIALIZER

Aquest component permet convertir una entitat de Symfony en un objecte JSON.

INSTAL·LACIÓ

composer require symfony/serializer

ÚS

Definim la seva interficie en el metode en el que l'anem a utilitzar.

SerializerInterface $serializer

Això requerira que el declarem.

use Symfony\Component\Serializer\SerializerInterface;

Guardem les dades serialitzades en un JSON:

$dadesJson = $serializer->serialize($dades, 'json')

Això serveix si la entitat no té relacions, en cas de que les tingui symfony llençarà un error per evitar bucles infinits. 
Amb un tercer parametre podem controlar això:

$dadesJson = $serializer->serialize($dades, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

Aquest parametre recull les relacions de la entitat i les afegeix al JSON.

Això torna un JSON en format text, per tant la última cosa que haurem de fer es decodificar-lo.

json_decode($dadesJson)