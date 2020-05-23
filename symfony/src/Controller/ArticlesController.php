<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use App\Repository\UserRepository;




class ArticlesController extends AbstractController
{

    /**
     * METODE PER AFEGIR UN NOU ARTICLE
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function nouarticle(Request $request)
    {
        //Crear Objecte Article i Form
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        //Si el formulari es enviat, captura les dades i pujar nou article a DB
        if ($form->isSubmitted() && $form->isValid()) {
            //Crear EntityManager
            $entityManager = $this->getDoctrine()->getManager();

            //Capturar dades del formulari i assignar-les al article
            $article->setAutor($this->getUser())
                ->setDataPublicacio(new \DateTime());

            //Capturar el titol i convertir-lo a Slug amb lowercase i guions
            $text = strtolower($form->get('titol')->getData());
            $slug = strtolower(str_replace(" ", "-", $text));
            $article->setSlug($slug);

            //Capturar input type="text" (String) de camp meta i convertirlo a array
            $inputMetaTag = $form->get('meta_tag')->getData();
            $correccioTags = str_replace(', ', ',', $inputMetaTag);

            //Assignem a article els camps meta
            $article->setMetaTag($correccioTags);
            // ->setMetaDescription($form->get('meta_description')->getData());

            // //Capturem categoria del select del formulari
            $categoria1 = $form->get('categoria1')->getData();
            // //Si la categoria es "afegir nova categoria"
            if ($form->get('categoria1')->getData()->getNom() == "afegir nova categoria") {

                //Creem nova categoria amb el que hi hagi al input "nova categoria"
                $afegirCategoria = new Categoria();
                $afegirCategoria->setNom($form->get('nova_categoria')->getData());
                $afegirCategoria->setLogo('default-logo.png');
                $entityManager->persist($afegirCategoria);
                //fem el cambiazo
                $categoria1 = $afegirCategoria;
            }
            //Afegir les categories
            $article->addCategories($categoria1);

            if ($form->get('categoria2')->getData() != null) {
                $article->addCategories($form->get('categoria2')->getData());
            }

            if ($form->get('categoria3')->getData() != null) {
                $article->addCategories($form->get('categoria3')->getData());
            }
            //Persistir dades i pujar dades a DB
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_detall', ['slug' => $slug]);
        }

        return $this->render('articles/form_nou_article.html.twig', [
            // 'article' => $article,
            'formArticle' => $form->createView(),
        ]);
    }

    /**
     * METODE PER EDITAR UN ARTICLE EXISTENT
     * @Route("/article/editar/{slug}", name="article_update", methods={"GET","POST"})
     */
    public function editarArticle($slug, Request $request, ArticleRepository $post_repo, CategoriaRepository $cat_repo)
    {
        //Obtenir dades del article
        $article = $post_repo->findOneBy(array('slug' => $slug));
        $categories = $article->getCategories();

        //Crear formulari amb les dades del article obtingut
        $form = $this->createForm(ArticleType::class, $article);

        //Passar la Colecció de Categories als 3 camps del formulari
        $form->get('categoria1')->setData($categories[0]);

        if ($categories[1] != null) {
            $form->get('categoria2')->setData($categories[1]);
        }
        if ($categories[2] != null) {
            $form->get('categoria3')->setData($categories[2]);
        }

        $form->handleRequest($request);
        //Si el formulari es enviat, captura les dades i pujar nou article a DB
        if ($form->isSubmitted() && $form->isValid()) {

            //Crear EntityManager
            $entityManager = $this->getDoctrine()->getManager();

            //Capturar el titol i convertir-lo a Slug amb lowercase i guions
            $text = strtolower($form->get('titol')->getData());
            $slug = strtolower(str_replace(" ", "-", $text));
            //Assignar al article l'Slug creat
            $article->setSlug($slug);

            //Capturar input type="text" (String) de camp meta i convertirlo a array
            $inputMetaTag = $form->get('meta_tag')->getData();
            $correccioTags = str_replace(', ', ',', $inputMetaTag);
            $article->setMetaTag($correccioTags);

            //Capturem categoria del select del formulari
            $categoria1 = $form->get('categoria1')->getData();
            //Si la categoria es "afegir nova categoria"
            if ($categoria1->getNom() == "afegir nova categoria") {
                //Creem nova categoria amb el que hi hagi al input "nova categoria"
                $afegirCategoria = new Categoria();
                $afegirCategoria->setNom($form->get('nova_categoria')->getData());
                $afegirCategoria->setLogo('default-logo.png');
                $entityManager->persist($afegirCategoria);
                //fem el cambiazo
                $categoria1 = $afegirCategoria;
            }

            //Resetejar la coleccio de Categories
            $cats = $cat_repo->findAll();
            for ($i = 0; $i < count($cats); $i++) {
                $article->removeCategories($cats[$i]);
            }

            //Afegir les categories a la Collecioo
            $article->addCategories($categoria1);

            if ($form->get('categoria2')->getData() != null) {
                $article->addCategories($form->get('categoria2')->getData());
            }

            if ($form->get('categoria3')->getData() != null) {
                $article->addCategories($form->get('categoria3')->getData());
            }

            //Persistir dades i pujar a DB
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_detall', ['slug' => $slug]);
        }

        return $this->render('articles/form_nou_article.html.twig', [
            'article' => $article,
            'formArticle' => $form->createView(),
        ]);
    }

    /**
     * RETORNA TOTS ELS ARTICLES D'UN AUTOR
     * @Route("/posts/{username}", name="articlesAutor", methods={"GET"})
     */
    public function articlesPerAutor($username, ArticleRepository $post_repo, UserRepository $user_repo)
    {
        $user = $user_repo->findOneBy(array('nom_usuari' => $username));
        $posts = $post_repo->findBy(array('autor' => $user));

        return $this->render('articles/llista_articles.html.twig', [
            'articles' => $posts,
        ]);
    }

    /**
     * VEURE EL DETALL D'UN ARTICLE
     * @Route("/post/{slug}", name="article_detall", methods={"GET"})
     */
    public function slug($slug, ArticleRepository $repository)
    {

        $post = $repository->findOneBy(array('slug' => $slug));
        $cat = $post->getCategories();

        return $this->render('articles/index.html.twig', [
            'article' => $post,
            'color' => $cat[0]->getColor()
        ]);
    }

    /**
     * MOSTRAR TOTS ELS ARTICLES D'UNA CATEGORIA
     * SI NO TROBA UNA CATEGORIA AMB EL MATEIX NOM
     * REDIRIGEIX CAP AL HOMEPAGE (PODEM CREAR UN 404)
     * @Route("/{cat_name}", name="articles_categoria")
     */
    public function getArticles($cat_name, CategoriaRepository $repository, SerializerInterface $serializer)
    {
        $categories = $repository->findAll();

        //Comprovar si la categoria entrada coincideix amb el nom d'una categoria existent
        for ($i = 0; $i < count($categories); $i++) {
            if ($cat_name == $categories[$i]->getNom()) {
                $posts = $categories[$i]->getArticles();

                //Si hi ha coincidencia, fer return
                return $this->render('articles/llista_articles.html.twig', [
                    'articles' => $posts,
                    'categoria' => $categories[$i],
                    'color' => $categories[$i]->getColor()
                ]);

                //OPCIO JSON
                // $catJson = $serializer->serialize($posts, 'json', [
                //     'ignored_attributes' => ['user', 'categoria'],
                //     'circular_reference_handler' => function ($object) {
                //         return $object->getId();
                //     }
                // ]);

                // return new JsonResponse(json_decode($catJson));
            }
        }
        //Si ha fet tot el bucle i no ha trobat coincidencia, redirigir a homepage
        return $this->redirectToRoute('homepage');
    }
}
