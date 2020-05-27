<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\ArticleRepository;
use App\Form\AdminArticleType;
use App\Repository\CategoriaRepository;
use App\Form\AdminCategoriaType;
use App\Repository\ComentariRepository;
use App\Form\AdminComentariType;
use App\Repository\UserRepository;
use App\Form\AdminUserType;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Error;


class AdminController extends AbstractController
{

    /**
     * PAGINA PRINCIPAL D'ADMIN
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        //Si hi ha un usuari ROLE_ADMIN loguejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            return $this->render('admin/admin.html.twig', [
                'controller_name' => 'Pagina de gestio web (Admin)',
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('app_login');
    }

    /**
     * LLISTAR ARTICLES
     * @Route("/admin/articles", name="adminArticles")
     */
    public function llistarArticles(ArticleRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $articles = $repository->findAll();

            return $this->render('admin/llistarArticles.html.twig', [
                'articles' => $articles,
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

        /**
     * LLISTAR ARTICLES d'UNA CATEGORIA
     * @Route("/admin/articles/categoria/{id}", name="adminArticlesCategoria")
     */
    public function llistarArticlesCategoria($id, CategoriaRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $categoria = $repository->findOneBy(array('id' => $id));
            $articles = $categoria->getArticles();

            return $this->render('admin/llistarArticles.html.twig', [
                'articles' => $articles,
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * LLISTAR CATEGORIES
     * @Route("/admin/categories", name="adminCategories")
     */
    public function llistarCategories(CategoriaRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $categories = $repository->findAll();

            return $this->render('admin/llistarCategories.html.twig', [
                'categories' => $categories,
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * LLISTAR COMENTARIS
     * @Route("/admin/comentaris", name="adminComentaris")
     */
    public function llistarComentaris(ArticleRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $articles = $repository->findAll();

            return $this->render('admin/llistarComentaris.html.twig', [
                'articles' => $articles,
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * LLISTAR USUARIS
     * @Route("/admin/usuaris", name="adminUsuaris")
     */
    public function llistarUsuaris(UserRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $usuaris = $repository->findAll();

            return $this->render('admin/llistarUsuaris.html.twig', [
                'usuaris' => $usuaris,
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }


    /**
     * EDITAR DADES ADMIN d'UN ARTICLE
     * @Route("/admin/article/{id}", name="adminEditarArticle")
     */
    public function editarArticle($id, Request $request, ArticleRepository $repository): Response
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $article = $repository->findOneBy(array('id' => $id));

            //Crear Objecte Article i Form
            $form = $this->createForm(AdminArticleType::class, $article);
            $form->handleRequest($request);

            //Si el formulari es enviat, capturar dades i actualitzar article a DB
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('adminArticles');
            }

            return $this->render('admin/adminEditarArticle.html.twig', [
                'adminEditarArticle' => $form->createView(),
                'article' => $article,
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * ADMIN EDITAR una CATEGORIA
     * @Route("/admin/categoria/{id}", name="adminEditarCategoria")
     */
    public function editarCategoria($id, Request $request, CategoriaRepository $repository, SluggerInterface $slugger): Response
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            // $cat_repository = $this->getDoctrine()->getRepository(Categoria::class);
            $categoria = $repository->findOneBy(array('id' => $id));

            //Crear Objecte Article i Form
            $form = $this->createForm(AdminCategoriaType::class, $categoria);
            $form->handleRequest($request);

            //Si el formulari es enviat, capture dde dades i pujar nou article a DB
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();

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
                }

                $entityManager->persist($categoria);
                $entityManager->flush();

                return $this->redirectToRoute('adminCategories');
            }

            return $this->render('admin/adminEditarCategoria.html.twig', [
                'categoria' => $categoria,
                'adminEditarCategoria' => $form->createView(),
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

        /**
     * EDITAR DADES ADMIN d'UN USUARI
     * @Route("/admin/usuari/{id}", name="adminEditarUsuari")
     */
    public function editarUsuari($id, Request $request, UserRepository $repository): Response
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $usuari = $repository->findOneBy(array('id' => $id));

            //Crear Objecte User i Form
            $form = $this->createForm(AdminUserType::class, $usuari);
            $form->handleRequest($request);

            //Si el formulari es enviat, capturar dades i actualitzar article a DB
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($usuari);
                $entityManager->flush();

                return $this->redirectToRoute('adminUsuaris');
            }

            return $this->render('admin/adminEditarUsuari.html.twig', [
                'adminEditarUsuari' => $form->createView(),
                'user' => $usuari,
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }
}
