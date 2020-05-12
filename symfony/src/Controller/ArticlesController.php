<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;

use App\Entity\Categoria;
//use App\Repository\TemaRepository;
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

            $article->setTitol($form->get('titol')->getData())
                ->setSubtitol($form->get('subtitol')->getData())
                ->setDataPublicacio(new \DateTime());

                //Aquest funcio s'ha de revisar
                $text = $form->get('titol')->getData();
                $slug = strtolower(str_replace(" ", "-",$text));
                $article->setSlug($slug);

            $article->setUser($this->getUser())
                ->setContingut($form->get('contingut')->getData());
                
            $inputTagMeta = $form->get('tag_meta')->getData();
            $arrayTagMeta = explode(",", $inputTagMeta);

            $inputTagWeb = $form->get('tag_web')->getData();
            $arrayTagWeb = explode(",", $inputTagWeb);

            $article->setTagMeta($arrayTagMeta)
                ->setTagWeb($arrayTagWeb);


                $categoria = $form->get('categoria')->getData();

            if($categoria->getNom() == "afegir nova categoria"){

                $afegirCategoria = new Categoria();
                $afegirCategoria->setNom($form->get('nova_categoria')->getData());
                $afegirCategoria->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
                $entityManager->persist($afegirCategoria);

                $categoria=$afegirCategoria;
            }

            $article->setCategoria($categoria);

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'formNouArticle' => $form->createView(),
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

    /**
     * @Route("/post/{slug}", name="slug", methods={"GET"})
     */
    public function slug($slug, ArticleRepository $articleRepository)
    {

        $post_repository = $this->getDoctrine()->getRepository(Article::class);
        $post = $post_repository->findOneBy(array('slug' => $slug));

        return $this->render('articles/index.html.twig', [
            'article' => $post
        ]);
    }

    /**
     * @Route("/inPHP", name="inPHP")
     */
    public function getAll()
    {
        $cat_repository = $this->getDoctrine()->getRepository(Categoria::class);
        $cat = $cat_repository->findBy(['nom' => "PHP"]);

        $post_repository = $this->getDoctrine()->getRepository(Article::class);
        $posts = $cat[0]->getArticles();

        return $this->render('articles/llista_articles.html.twig', [
            'articles' => $posts,
        ]);
    }
}
