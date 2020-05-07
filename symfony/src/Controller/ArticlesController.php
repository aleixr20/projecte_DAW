<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;

use App\Entity\Tema;
use App\Repository\TemaRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
//Faltaran afegir el USE dels components de formularis



use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends AbstractController
{

    /**
     * AQUI ES ON TENIM EL PROBLEMON
     * 
     * COM DEIA L'ALEIX, NO PODEM POSAR EL PRIMER TERME DE LA RUTA URL
     * AMB UNA VARIABLE NO DEFINIDA, JA QUE LLAVORS PETEN ELS ALTRES ENRUTATS
     * 
     * PER NO QUEDARNOS ENCALLATS, ARA PER ARA, CREEM TANTS METODES COM SIGUIN
     * NECESSARIS I DESPRES JA APLICAREM EL DRY (DONT REPEAT YOURSELF)
     * 
     * CREIE-ME QUE A MI EM FA MES MAL A A VISTA QUE A NINGU, PERO NO ENS ENCALLEM
     * TIREM AMB ALGO ENCARA QUE SIGUI POC REUTILITZABLE
     *
     *********************************************************/

    /**
     * METODE PER AFEGIR UN NOU ARTICLE
     * No entenc perque especifiques metodes GET i POST (els dos??)
     * 
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $article->setDataPublicacio(new \DateTime());
            $article->setUser($this->getUser());
            $article->setSlug(strtolower(str_replace(" ", "-", $article->getTitol())));
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }


    /**
     * METODE PER EDITAR UN ARTICLE EXISTENT
     * Podem entrar per nom(slug) o per id
     * 
     * @Route("/article/editar/$id", name="article_update", methods={"GET","POST"})
     */
    public function update(Request $request)
    {

        //PENDENT IMPLEMENTAR
    }



    /*************************************************
     * AQUI ES ON ENS ESTEM FOTENT D'OSTIES NO?
     * ***********************************************/


    // /**
    //  * @Route("/in{tema}", name="tema", methods={"GET"})
    //  */
    // public function tema($tema, ArticleRepository $articleRepository, TemaRepository $temaRepository)
    // {

    //     if ($tema == 'login') {
    //         // redirects to the "homepage" route
    //         return $this->redirectToRoute('app_login');
    //     }
    //     $temaId = $temaRepository->findOneBy(array('nom' => $tema))->getId();

    //     return $this->render('article/index_tema.html.twig', [
    //         'tema' => $tema,
    //         'articles' => $articleRepository->findBy(array('tema' => $temaId)),
    //     ]);
    // }

    // /**
    //  * @Route("/in{tema}/{slug}", name="slug", methods={"GET"})
    //  */
    // public function slug($tema, $slug, ArticleRepository $articleRepository)
    // {
    //     if ($tema == 'login') {
    //         // redirects to the "homepage" route
    //         return $this->redirectToRoute('app_login');
    //     }

    //     return $this->render('article/show.html.twig', [
    //         'article' => $articleRepository->findOneBy(array('slug' => $slug)),
    //     ]);
    // }

    /**
     * @Route("/inPHP", name="inPHP")
     */
    public function getAll()
    {
        $tema_repository = $this->getDoctrine()->getRepository(Tema::class);
        $tema = $tema_repository->findBy(['nom' => "PHP"]);

        $post_repository = $this->getDoctrine()->getRepository(Article::class);
        $posts = $post_repository->findBy(['tema' => $tema[0]]);

        return $this->render('articles/index.html.twig', [
            'articles' => $posts,
        ]);
    }
}
