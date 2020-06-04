<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\ArticleRepository;
use App\Form\AdminArticleType;
use App\Entity\Categoria;
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
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

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

            $articles = array_reverse($repository->findAll());

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
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $categoria = $repository->findOneBy(array('id' => $id));
            $articles = $categoria->getArticles();

            return $this->render('admin/llistarArticles.html.twig', [
                'articles' => $articles,
                // 'articles' => array_reverse($articles),

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
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

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
    public function llistarComentaris(ComentariRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $comentaris = $repository->findAll();

            return $this->render('admin/llistarComentaris.html.twig', [
                'comentaris' => array_reverse($comentaris),
            ]);
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * LLISTAR COMENTARIS d'UN USUARI
     * @Route("/admin/comentaris/{username}", name="adminComentarisUsuari")
     */
    public function llistarComentarisUsuari($username, UserRepository $user_repo, ComentariRepository $comment_repo)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $usuari = $user_repo->findOneBy(array('nom_usuari' => $username));
            $comentaris = $comment_repo->findBy(array('user' => $usuari));

            return $this->render('admin/llistarComentaris.html.twig', [
                'comentaris' => array_reverse($comentaris),
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
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

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
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

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
     * ADMIN AFEGIR una CATEGORIA
     * @Route("/admin/categoria/nova", name="adminAfegirCategoria")
     */
    public function afegirCategoria(Request $request, SluggerInterface $slugger): Response
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            //Crear Objecte Categoria i Form
            $categoria = new Categoria();

            $form = $this->createForm(AdminCategoriaType::class, $categoria);
            $form->handleRequest($request);

            //Si el formulari es enviat, capture de dades i pujar nova categoria a DB
            if ($form->isSubmitted() && $form->isValid()) {

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
                        $logoCategoria->move('img/categories', $nouNomArxiu);
                    } catch (FileException $e) {
                        throw new Error($e);
                    }

                    // updates the 'imatge' property to store the image file name
                    // instead of its contents
                    $categoria->setLogo($nouNomArxiu);
                }

                //Persistir dades i pujar a DB
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($categoria);
                $entityManager->flush();

                return $this->redirectToRoute('adminCategories');
            }

            return $this->render('admin/adminEditarCategoria.html.twig', [
                'adminEditarCategoria' => $form->createView(),
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
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $categoria = $repository->findOneBy(array('id' => $id));

            //Crear objecte Form amb dades de la Categoria
            $form = $this->createForm(AdminCategoriaType::class, $categoria);
            $form->handleRequest($request);

            //Si el formulari es enviat, capture de dades i actualitzar categoria a DB
            if ($form->isSubmitted() && $form->isValid()) {

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
                        $logoCategoria->move('img/categories', $nouNomArxiu);
                    } catch (FileException $e) {
                        throw new Error($e);
                    }

                    // updates the 'imatge' property to store the image file name
                    // instead of its contents
                    $categoria->setLogo($nouNomArxiu);
                }

                //Persistir dades i pujar a DB
                $entityManager = $this->getDoctrine()->getManager();
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
     * CANVIAR VISIBILITAT D'UN COMENTARI
     * @Route("/admin/comentari/publicar/{id}", name="adminPublicarComentari")
     */
    public function publicarComentari($id, ComentariRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            //Obtenir la info del comentari
            $comentari = $repository->findOneBy((array('id' => $id)));
            //Si esta en visible false, pasar a true i viceversa
            if ($comentari->getVisible()) {
                $comentari->setVisible(false);
            } else {
                $comentari->setVisible(true);
            }

            //Persistir dades i pujar a DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comentari);
            $entityManager->flush();

            //Obtenir tots els comentaris i relllistar
            return $this->redirectToRoute('adminComentaris');
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * EDITAR DADES ADMIN d'UN COMENTARI
     * @Route("/admin/comentari/editar/{id}", name="adminEditarComentari")
     */
    public function editarComentari($id, Request $request, ComentariRepository $repository): Response
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            //Crear formulari amb dades del comentari
            $comment = $repository->findOneBy(array('id' => $id));
            $form = $this->createForm(AdminComentariType::class, $comment);

            $form->handleRequest($request);

            //Si el formulari es enviat, capturar dades i actualitzar a DB
            if ($form->isSubmitted() && $form->isValid()) {

                //Persistir dades i pujar a DB
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comment);
                $entityManager->flush();

                return $this->redirectToRoute('adminComentaris');
            }

            return $this->render('admin/adminEditarComentari.html.twig', [
                'adminEditarComentari' => $form->createView(),
                // 'user' => $usuari,
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
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            //Crear formulari amb dades del usuari
            $usuari = $repository->findOneBy(array('id' => $id));
            $form = $this->createForm(AdminUserType::class, $usuari);

            //Comprovar roles del usuari pel select del formulari
            if (in_array("ROLE_ADMIN", $usuari->getRoles())) {
                $form->get('roles')->setData('ROLE_ADMIN');
            } else if (in_array("ROLE_VALIDATED", $usuari->getRoles())) {
                $form->get('roles')->setData('ROLE_VALIDATED');
            } else {
                $form->get('roles')->setData('ROLE_USER');
            }

            $form->handleRequest($request);

            //Si el formulari es enviat, capturar dades i actualitzar a DB
            if ($form->isSubmitted() && $form->isValid()) {

                //Comprovar el select de ROLE
                $role =  $form->get('roles')->getData();
                if ($role == 'ROLE_ADMIN') {
                    $usuari->setRoles(['ROLE_USER', 'ROLE_VALIDATED', 'ROLE_ADMIN']);
                } else if ($role == 'ROLE_VALIDATED') {
                    $usuari->setRoles(['ROLE_USER', 'ROLE_VALIDATED']);
                } else {
                    $usuari->setRoles(['ROLE_USER']);
                }

                //Comprovar el select de eliminar imatge de perfil es true
                if ($form->get('imatge')->getData()) {
                    $usuari->setImatge('');
                }

                //Persistir dades i pujar a DB
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



    /**
     * ELIMINAR ARTICLE
     * @Route("/admin/delete/article/{id}/{slug}/{autor}", name="adminEliminarArticle")
     */
    public function eliminarArticle($id, $slug, $autor, ArticleRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $article = $repository->findOneBy(array('id' => $id));

            //Comprovar segon i tercer paramentres per seguretat
            if ($article && ($article->getSlug() === $slug) && ($article->getAutor()->getUsername() === $autor)) {
                //Eliminar de la DB
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($article);
                $entityManager->flush();
            }
            return $this->redirectToRoute('adminArticles');
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * ELIMINAR CATEGORIA
     * @Route("/admin/delete/categoria/{id}", name="adminEliminarCategoria")
     */
    public function eliminarCategoria($id, CategoriaRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $categoria = $repository->findOneBy(array('id' => $id));

            //Si la categoria te articles, anular el delete
            if (count($categoria->getArticles()) > 0) {
                return $this->redirectToRoute('adminCategories', [
                ]);
            }

            //Eliminar de la DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoria);
            $entityManager->flush();

            return $this->redirectToRoute('adminCategories');
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * ELIMINAR COMENTARI
     * @Route("/admin/comentari/eliminar/{id}/{autor}", name="adminEliminarComentari")
     */
    public function eliminarComentari($id, $autor, ComentariRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $comment = $repository->findOneBy(array('id' => $id));

            //Comprovar segon paramatre d'entrada per mes seguretat
            if ($comment && ($comment->getUser()->getUsername() === $autor)) {

                //Eliminar de la DB
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($comment);
                $entityManager->flush();
            }
            return $this->redirectToRoute('adminComentaris');
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }

    /**
     * ELIMINAR USUARI
     * @Route("/admin/delete/user/{username}", name="eliminarUsuari")
     */
    public function eliminarUsuari($username, UserRepository $repository)
    {
        //Si hi ha un usuari ROLE_ADMIN logejat,
        if ($this->getUser() && in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $usuari = $repository->findOneBy(array('username' => $username));

            //Eliminar de la DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuari);
            $entityManager->flush();

            return $this->redirectToRoute('adminUsuaris');
        }

        //Si no hi havia ROLE_ADMIN loguejat
        return $this->redirectToRoute('homepage');
    }
}
