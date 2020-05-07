<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\TemaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{

    /**
     * JO CREC QUE AQUEST CONTROLADOR HAURIA DE SER EL DE LA API
     * TOTS ELS METODES D'AQUEST CONTROLLADOR HAURIEN DE SER DE RETURN JSON
     * 
     * Per exemple:
     * Les validacions de formularis
     * Obtenir tots els temes
     * Obtenir numero de "likes" d'un article
     * 
     *      
     * LES FUNCIONS QUE HE COPIAT A ALTRES CONTROLLERS
     * LES HE COMENTAT (NO ELIMINAT) AIXI PODREM VEURE
     * QUINA ESTRUCUTRA ENS AGRADA MES
     *
     *********************************************************/


    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository)
    {

        return $this->redirectToRoute('homepage');
        // return $this->render('article/index.html.twig', [
        //     'articles' => $articleRepository->findAll(),
        // ]);
    }

    // /**
    //  * @Route("/new", name="article_new", methods={"GET","POST"})
    //  */
    // public function new(Request $request)
    // {
    //     $article = new Article();
    //     $form = $this->createForm(ArticleType::class, $article);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $article->setDataPublicacio(new \DateTime());
    //         $article->setUser($this->getUser());
    //         $article->setSlug(strtolower(str_replace(" ", "-", $article->getTitol())));
    //         $entityManager->persist($article);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('index');
    //     }

    //     return $this->render('article/new.html.twig', [
    //         'article' => $article,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'Admin',
        ]);
    }

    // /**
    //  * @Route("/profile/{userName}", name="userProfile")
    //  */
    // public function userProfile($userName)
    // {
    //     if ($this->getUser()->getEmail() != $userName) {
    //         return $this->redirectToRoute('index');
    //     }

    //     return $this->render('app/index.html.twig', [
    //         'controller_name' => $userName,
    //     ]);
    // }

    // /**
    //  * @Route("/profile", name="userProfileRedirect")
    //  */
    // public function userProfileRedirect()
    // {
    //     if (!$this->getUser()) {
    //         return $this->redirectToRoute('app_login');
    //     }

    //     return $this->redirectToRoute('userProfile', [
    //         'userName' => $this->getUser()->getEmail()
    //     ]);
    // }

    // /**
    //  * @Route("/{tema}", name="tema", methods={"GET"})
    //  */
    // public function tema($tema, ArticleRepository $articleRepository, TemaRepository $temaRepository)
    // {

    //     $temaId = $temaRepository->findOneBy(array('nom' => $tema))->getId();

    //     return $this->render('article/index_tema.html.twig', [
    //         'tema' => $tema,
    //         'articles' => $articleRepository->findBy(array('tema' => $temaId)),
    //     ]);
    // }

    // /**
    //  * @Route("/{tema}/{slug}", name="slug", methods={"GET"})
    //  */
    // public function slug($tema, $slug, ArticleRepository $articleRepository)
    // {
    //     return $this->render('article/show.html.twig', [
    //         'article' => $articleRepository->findOneBy(array('slug' => $slug)),
    //     ]);
    // }
}
