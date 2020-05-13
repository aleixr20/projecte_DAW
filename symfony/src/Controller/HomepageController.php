<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HomepageSections;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

header('Access-Control-Allow-Origin: *');
class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function getAll()
    {
        $repository = $this->getDoctrine()->getRepository(HomepageSections::class);
        $sections = $repository->findAll();

        // $data = [];
        // foreach ($sections as $pelicula) {
        //     $data[] = [
        //         'titol' => $pelicula->getTitol(),
        //         'subtitol' => $pelicula->getSubtitol(),
        //         'contingut' => $pelicula->getContingut(),
        //         'menulink' => strtoupper($pelicula->getMenulink()),
        //     ];
        // }
        // // return $this->json(['sections' => $data]);
        // return new JsonResponse($data, Response::HTTP_OK);

        return $this->render('homepage.html.twig', [
            'sections' => $sections,
        ]);
    }

    //     /**
    //  * @Route("/inPHP", name="inPHP")
    //  */
    // public function getPhp(): JsonResponse
    // {
    //     $repository = $this->getDoctrine()->getRepository(HomepageSections::class);
    //     $sections = $repository->findAll();

    //     $data = [];

    //     foreach ($sections as $pelicula) {
    //         $data[] = [
    //             'titol' => $pelicula->getTitol(),
    //             'subtitol' => $pelicula->getSubtitol(),
    //             'contingut' => $pelicula->getContingut(),
    //             'menulink' => $pelicula->getMenulink()
    //         ];
    //     }
    //     // return $this->json(['sections' => $data]);

    //     return new JsonResponse($data[0], Response::HTTP_OK);
    // }
    // public function index()
    // {
    //     $repository = $this->getDoctrine()->getRepository(HomepageSections::class);
    //     $sections = $repository->findAll();
    //     return $this->json(['sections' => $sections[0]]);
    //     // return $this->render('homepage/index.html.twig', [
    //     //     'controller_name' => 'HomepageController',
    //     // ]);
    // }
}
