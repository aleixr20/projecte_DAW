<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categoria;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

// header('Access-Control-Allow-Origin: *');
class HomepageController extends AbstractController
{

    //Per tenir nomes una funci{o, podem pasar aqueta a algun Controllador generic


    /**
     * @Route("/", name="homepage")
     */
    public function getAll()
    {

        $repo_categories = $this->getDoctrine()->getRepository(Categoria::class);
        $categories_frontend = $repo_categories->findBy(['tipus' => 'frontend']);
        $categories_backend = $repo_categories->findBy(['tipus' => 'backend']);
        $categories_sistemes = $repo_categories->findBy(['tipus' => 'sistemes']);
        $categories_altres = $repo_categories->findBy(['tipus' => 'altres']);

        return $this->render('homepage.html.twig', [
            'categories_frontend' => $categories_frontend,
            'categories_backend' => $categories_backend,
            'categories_sistemes' => $categories_sistemes,
            'categories_altres' => $categories_altres,
        ]);
    }

    /**
     * @Route("/docs", name="docs")
     */
    public function docs()
    {

        $idioma = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);

        // if ($idioma == 'en') {
        $sections = [
            ['linkslug' => 'portada', 'linkalt' => 'Portada de la documentación', 'linkname' => 'ABOUT US', 'file' => '01-portada'],
            ['linkslug' => 'indice', 'linkalt' => 'Indice de contenido de la documentación', 'linkname' => 'INDICE', 'file' => '02-indice'],

            ['linkslug' => 'producto', 'linkalt' => 'El producto b-nerd', 'linkname' => 'B-NERD', 'file' => '03-producto'],
            ['linkslug' => 'objetivos', 'linkalt' => 'Objetivos del proyecto', 'linkname' => 'OBJETIVOS', 'file' => '04-objetivos'],
            ['linkslug' => 'tecnologias', 'linkalt' => 'Tecnologias utilizadas en el proyecto', 'linkname' => 'TECHS', 'file' => '05-tecnologias'],
            ['linkslug' => 'planificacion', 'linkalt' => 'Planificacion del proyecto', 'linkname' => 'PLANIFICACIÓN', 'file' => '06-planificacion'],
            ['linkslug' => 'wireframes', 'linkalt' => 'Prototipos de diseño inical', 'linkname' => 'WIREFRAMES', 'file' => '07-wireframes'],
            ['linkslug' => 'funcionalidades', 'linkalt' => 'Diagra de casos de uso', 'linkname' => 'FUNCIONALIDADES', 'file' => '08-casosdus'],
            ['linkslug' => 'BBDD', 'linkalt' => 'Disenño de la base de datos', 'linkname' => 'BBDD', 'file' => '09-bbdd'],

            ['linkslug' => 'fracasos', 'linkalt' => 'Objetivos no alcanzados', 'linkname' => 'FRACASOS', 'file' => '10-fracasos'],
            ['linkslug' => 'exitos', 'linkalt' => 'Objetivos logrados', 'linkname' => 'EXITOS', 'file' => '11-exitos'],
            ['linkslug' => 'seguridad', 'linkalt' => 'Seguridad aplicada', 'linkname' => 'SEGURIDAD', 'file' => '12-seguridad'],
            ['linkslug' => 'valoraciones', 'linkalt' => 'Nuestras valoraciones personales', 'linkname' => 'VALORACIONES', 'file' => '13-valoraciones'],

            // ['linkslug' => 'estilos', 'linkalt' => 'Guia de estilos finales', 'linkname' => 'GUIA DE ESTILOS', 'file' => '14-estilos'],
            ['linkslug' => 'manual', 'linkalt' => 'Manual de  usuarios e instalación', 'linkname' => 'INSTALACION', 'file' => '15-manual'],
            // ['linkslug' => 'demo', 'linkalt' => 'Instalación de versión para Demo', 'linkname' => 'VERSION DEMO', 'file' => '16-demo'],

            ['linkslug' => 'conclusion', 'linkalt' => 'Conclusiones finales', 'linkname' => 'CONCLUSIONES', 'file' => '17-conclusiones'],






        ];
        return $this->render('docs/docs.html.twig', [
            'lang' => 'es',
            'sections' => $sections,
        ]);
        // };
    }
}
