<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categoria;
use App\Entity\HomepageSections;
use App\Form\CategoriaType;
use App\Form\HomepageSectionsType;
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
     * PAGINA PRINCIPAL AMB LES OPCIONS D'ADMIN
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'Pagina de gestio web (Admin)',
        ]);
    }

    // /**
    //  * @Route("/admin/gestorhomepage", name="gestorhomepage")
    //  */
    // public function editarHomepage()
    // {
    //     $repository = $this->getDoctrine()->getRepository(HomepageSections::class);
    //     $sections = $repository->findAll();

    //     //$sections = [$categories];

    //     return $this->render('admin/categories_llista.html.twig', [
    //         'section' => $categories,
    //     ]);
    // }

    /**
     * @Route("/admin/homepage", name="admin_homepage")
     */
    public function editarHomepage()
    {
        $repo_categories = $this->getDoctrine()->getRepository(Categoria::class);
        $categories = $repo_categories->findAll();

        $repo_homepage = $this->getDoctrine()->getRepository(HomepageSections::class);
        $sections = $repo_homepage->findAll();

        return $this->render('admin/categories_llista.html.twig', [
            'categories' => $categories,
            'homepage' => $sections
        ]);
    }

    /**
     * @Route("/admin/homepage/{id}", name="editar_homepage")
     */
    public function editarHomepageSection($id, Request $request, SluggerInterface $slugger): Response
    {

        $home_repository = $this->getDoctrine()->getRepository(HomepageSections::class);
        $section = $home_repository->findOneBy(array('id' => $id));

        //Crear Objecte HomepageSection i Form
        //$categoria = new Categoria();
        $form = $this->createForm(HomepageSectionsType::class, $section);
        $form->handleRequest($request);

        //Si el formulari es enviat, capture dde dades i pujar nou article a DB
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $section->setTitol($form->get('titol')->getData())
                ->setSubtitol($form->get('subtitol')->getData())
                ->setContingut($form->get('contingut')->getData())
                ->setVisible($form->get('visible')->getData())
                ->setMenuNom($form->get('menuNom')->getData());

            //Assegurar-nos que el ID del HTML es lowercase i amb guions
            $text = strtolower($form->get('menuLink')->getData());
            $seccioId = strtolower(str_replace(" ", "-", $text));
            $section->setMenuLink($seccioId);



            $entityManager->persist($section);
            $entityManager->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('admin/form_editar_homepage.html.twig', [
            'formEditarSeccio' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function llistarCategories()
    {
        $repo_categories = $this->getDoctrine()->getRepository(Categoria::class);
        $categories = $repo_categories->findAll();

        $repo_homepage = $this->getDoctrine()->getRepository(HomepageSections::class);
        $sections = $repo_homepage->findAll();

        return $this->render('admin/categories_llista.html.twig', [
            'categories' => $categories,
            'homepage' => $sections
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

            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/categories_editar.html.twig', [
            'categoria' => $categoria,
            'formEditarCategoria' => $form->createView(),
        ]);
    }
}
