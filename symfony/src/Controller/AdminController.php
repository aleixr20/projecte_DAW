<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Error;


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
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'Pagina de gestio web (Admin)',
        ]);
    }

    /**
     * @Route("/admin/gestorcategories", name="gestorcategories")
     */
    public function llistarCategories()
    {
        $repository = $this->getDoctrine()->getRepository(Categoria::class);
        $categories = $repository->findAll();

        //$sections = [$categories];

        return $this->render('admin/categories_llista.html.twig', [
            'section' => $categories,
        ]);
    }

    /**
     * @Route("/admin/editarcategoria/{id}", name="editar_categoria")
     */
    public function editarCategoria($id, Request $request, SluggerInterface $slugger): Response
    {

        $cat_repository = $this->getDoctrine()->getRepository(Categoria::class);
        $categoria = $cat_repository->findOneBy(array('id' => $id));

        //Crear Objecte Article i Form
        //$categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        //Si el formulari es enviat, capture dde dades i pujar nou article a DB
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $categoria->setNom($form->get('nom')->getData());

            //Pujada de la imatge de logo/icona
            $logoCategoria = $form->get('logo')->getData();

            // this condition is needed because the 'imatge' field is not required
            // so the image file must be processed only when a file is uploaded
            if ($logoCategoria) {
                $nomArxiuOriginal = pathinfo($logoCategoria->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $nomArxiu = $slugger->slug($nomArxiuOriginal);
                $nouNomArxiu = $nomArxiu . '-' . uniqid() . '.' . $logoCategoria->guessExtension();

                // Move the file to the directory where imatges are stored
                try {
                    $logoCategoria->move('img\categories', $nouNomArxiu);
                } catch (FileException $e) {
                    throw new Error($e);
                }

                // updates the 'imatge' property to store the image file name
                // instead of its contents
                $categoria->setLogo($nouNomArxiu);
            } else {
                $categoria->setLogo('default_logo.jpg');
            }

            $entityManager->persist($categoria);
            $entityManager->flush();

            return $this->redirectToRoute('gestorcategories');
        }

        return $this->render('admin/categories_editar.html.twig', [
            'categoria' => $categoria,
            'formEditarCategoria' => $form->createView(),
        ]);
    }
}
