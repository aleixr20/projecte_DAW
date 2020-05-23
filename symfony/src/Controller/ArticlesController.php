<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;

use App\Form\ArticleType;

use App\Entity\Categoria;

//use App\Repository\TemaRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
//Faltaran afegir el USE dels components de formularis



use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends AbstractController
{

    /**
     * METODE PER AFEGIR UN NOU ARTICLE
     * No entenc perque especifiques metodes GET i POST (els dos??)
     * 
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
            $article
                // ->setTitol($form->get('titol')->getData())
                // ->setSubtitol($form->get('subtitol')->getData())
                // //Ara per ara la data de publicació es fixa, un timestamp manual
                // ->setContingut($form->get('contingut')->getData())
                // ->setDataPublicacio(new \DateTime())
                // ->setVisible(true)
                ->setUser($this->getUser());

            //Capturar el titol i convertir-lo a Slug amb lowercase i guions
            $text = strtolower($form->get('titol')->getData());
            $slug = strtolower(str_replace(" ", "-", $text));
            //Assignar al article l'Slug creat
            $article->setSlug($slug);

            //Capturar input type="text" (String) de camp meta i convertirlo a array
            $inputMetaTag = $form->get('meta_tag')->getData();
            $correccioTags = str_replace(', ', ',', $inputMetaTag);

            //Assignem a article els camps meta
            $article->setMetaTag($correccioTags);
                // ->setMetaDescription($form->get('meta_description')->getData());

            // //Capturem categoria del selsect del formulari
            // $categoria = $form->get('categoria')->getData();
            // //Si la categoria es "afegir nova categoria"
            // if ($categoria->getNom() == "afegir nova categoria") {

                             if ($form->get('categoria')->getData()->getNom() == "afegir nova categoria") {

                //Creem nova categoria amb el que hi hagi al input "nova categoria"
                $afegirCategoria = new Categoria();
                $afegirCategoria->setNom($form->get('nova_categoria')->getData());
                $afegirCategoria->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
                $entityManager->persist($afegirCategoria);
                //fem el cambiazo
                $categoria = $afegirCategoria;
            }
            //Afegir la categoria
            $article->setCategoria($categoria);
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
     * Podem entrar per nom(slug) o per id
     * 
     * @Route("/article/editar/{slug}", name="article_update", methods={"GET","POST"})
     */
    public function editarArticle($slug, Request $request)
    {

        //Obtenir dades del article
        $post_repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $post_repository->findOneBy(array('slug' => $slug));
        //Crear formulari amb les dades del article obtingut
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        //Si el formulari es enviat, captura les dades i pujar nou article a DB
        if ($form->isSubmitted() && $form->isValid()) {
            //Crear EntityManager
            $entityManager = $this->getDoctrine()->getManager();
            //Capturar dades del formulari i assignar-les al article
            $article->setTitol($form->get('titol')->getData())
                ->setSubtitol($form->get('subtitol')->getData())
                //Ara per ara la data de publicació es fixa, un timestamp manual
                ->setContingut($form->get('contingut')->getData())
                ->setDataActualitzacio(new \DateTime())
                ->setUser($this->getUser());

            //Aquest funcio s'ha de revisar
            //Capturar el titol i convertir-lo a Slug amb lowercase i guions
            $text = strtolower($form->get('titol')->getData());
            $slug = strtolower(str_replace(" ", "-", $text));
            //Assignar al article l'Slug creat
            $article->setSlug($slug);

            //Capturar input type="text" (String) de camp meta i convertirlo a array
            $inputMetaTag = $form->get('meta_tag')->getData();
            $correccioTags = str_replace(', ', ',', $inputMetaTag);

            //Assignem a article els camps meta
            $article->setMetaTag($correccioTags)
                ->setMetaDescription($form->get('meta_description')->getData());

            //Capturem categoria del selsect del formulari
            $categoria = $form->get('categoria')->getData();
            //Si la categoria es "afegir nova categoria"
            if ($categoria->getNom() == "afegir nova categoria") {
                //Creem nova categoria amb el que hi hagi al input "nova categoria"
                $afegirCategoria = new Categoria();
                $afegirCategoria->setNom($form->get('nova_categoria')->getData());
                $afegirCategoria->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
                $entityManager->persist($afegirCategoria);
                //fem el cambiazo
                $categoria = $afegirCategoria;
            }
            //Afegir la categoria
            $article->setCategoria($categoria);
            //Persistir dades i pujar dades a DB
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
     * PER VEURE UN ARTICLE
     * @Route("/posts/{username}", name="articlesAutor", methods={"GET"})
     */
    public function articlesPerAutor($username, ArticleRepository $post_repo, UserRepository $user_repo)
    {

        $user = $user_repo->findOneBy(array('nom_usuari' => $username));
        $posts = $post_repo->findBy(array('user' => $user));

        return $this->render('articles/llista_articles.html.twig', [
            'articles' => $posts,
        ]);
    }

    /**
     * PER VEURE UN ARTICLE
     * @Route("/post/{slug}", name="article_detall", methods={"GET"})
     */
    public function slug($slug, ArticleRepository $articleRepository)
    {

        $post_repository = $this->getDoctrine()->getRepository(Article::class);
        $post = $post_repository->findOneBy(array('slug' => $slug));

        return $this->render('articles/index.html.twig', [
            'article' => $post,
            'color' => $post->getCategoria()->getColor()
        ]);
    }



    /**
     * PER A FRONTEND AMB VUE -> RETORNA UN ARRAY D'OBJECTES ARTICLE
     * @Route("/post_vue/{slug}", name="article_detall_vue")
     */
    public function slug_vue($slug, ArticleRepository $articleRepository, SerializerInterface $serializer): JsonResponse
    {

        $post_repository = $this->getDoctrine()->getRepository(Article::class);
        $post = $post_repository->findOneBy(array('slug' => $slug));

        // $result = $serializer->normalize($level1, null, [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]);
        $postJson = $serializer->serialize($post, 'json', [
            'ignored_attributes' => ['user', 'categoria'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return new JsonResponse(json_decode($postJson));
    }

    /**
     * RETORNA TOTS ELS ARTICLES D'UNA CATEGORIA
     * SI NO TROBA UNA CATEGORIA AMB EL MATEIX NOM
     * REDIRIGEIX CAP AL HOMEPAGE (PODEM CREAR UN 404)
     * @Route("/{cat_name}", name="articles_categoria")
     */
    public function getArticles($cat_name, SerializerInterface $serializer)
    {
        $cat_repository = $this->getDoctrine()->getRepository(Categoria::class);
        $categories = $cat_repository->findAll();

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
