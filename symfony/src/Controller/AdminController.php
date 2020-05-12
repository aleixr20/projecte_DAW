<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categoria;

class AdminController extends AbstractController
{

    /**
     * AQUI TOTS ELS METODES EXCLUSIUS D'UN ADMIN
     * 
     * Llistar usuaris
     * Activar/Bloquejar usuaris (update user.status)
     * Activar/Bloquejar comentaris (update comment.status)
     * Estadistiques, llistes, mailings...
     *
     *********************************************************/


    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        // return $this->render('admin/index.html.twig', [
        //     'controller_name' => 'AdminController',
        // ]);
    }

    /**
     * @Route("/admin/gestorcategories", name="gestorcategories")
     */
    public function llistarCategories()
    {
        $repository = $this->getDoctrine()->getRepository(Categoria::class);
        $categories = $repository->findAll();

        $sections = [$categories];

        return $this->render('admin/categories_llista.html.twig', [
            'sections' => $sections,
        ]);
    }
}
