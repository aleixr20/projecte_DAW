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
            ['linkslug' => 'portada', 'linkalt' => 'Portada de la documentación', 'linkname' => 'INICIO', 'file' => '1_portada'],
            ['linkslug' => 'producto', 'linkalt' => 'El producto b-nerd', 'linkname' => 'B-NERD', 'file' => '2_producto'],
            ['linkslug' => 'objetivos', 'linkalt' => 'Objetivos del proyecto', 'linkname' => 'OBJETIVOS', 'file' => '3_objetivos'],
            ['linkslug' => 'planificacion', 'linkalt' => 'Planificacion del proyecto', 'linkname' => 'PLANIFICACIÓN', 'file' => '4_planificacion']
        ];
        return $this->render('docs/docs.html.twig', [
            'lang' => 'es',
            'sections' => $sections,
        ]);
        // };
    }
}
