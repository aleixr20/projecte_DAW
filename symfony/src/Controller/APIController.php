<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Repository\CategoriaRepository;
use App\Repository\ArticleRepository;
use App\Repository\ComentariRepository;
use App\Entity\Comentari;
use App\Repository\UserRepository;

class APIController extends AbstractController
{
    /**
     * METODE PER OBTENIR LES CATEGORIES ACTUALS
     * @Route("/api/getCategories", name="apiGetCategories", methods={"GET"})
     */
    public function getCategories(CategoriaRepository $repository): JsonResponse
    {
        $categorias = $repository->findAll();
        $data = [];

        foreach ($categorias as $categoria) {
            $data[] = [
                'cat_id' => $categoria->getId(),
                'cat_nom' => $categoria->getNom(),
                'cat_logo' => 'http://www.b-nerd.cat/img/categories/' . $categoria->getLogo(),
                'cat_num_articles' => count($categoria->getArticles())
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * METODE PER OBTENIR TOTS ELS ARTICLES
     * @Route("/api/getArticles", name="apiGetArticles", methods={"GET"})
     */
    public function getArticles(ArticleRepository $repository): JsonResponse
    {
        $articles = $repository->findAll();
        $data = [];

        foreach ($articles as $article) {
            $data[] = [
                'aticle_id' => $article->getId(),
                'article_titol' => $article->getTitol(),
                'article_autor' => $article->getAutor()->getUsername(),
                'article_num_comentaris' => count($article->getComentaris())
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * METODE PER VEURE UN ARTICLE
     * @Route("/api/getArticle/{article_id}", name="apiGetArticle", methods={"GET"})
     */
    public function getArticle($article_id, ArticleRepository $repository): JsonResponse
    {
        $article = $repository->findOneBy(['id' => $article_id]);
        $data = [];

        $data[] = [
            'aticle_id' => $article->getId(),
            'article_titol' => $article->getTitol(),
            'article_resum' => $article->getResum(),
            'article_autor' => $article->getAutor()->getUsername(),
            'article_num_comentaris' => count($article->getComentaris())
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * METODE PER OBTENIR ELS ARTICLES D'UNA CATEGORIA
     * @Route("/api/getArticles/{categoria_id}", name="apiGetArticlesCategoria", methods={"GET"})
     */
    public function getArticlesCategoria($categoria_id, CategoriaRepository $repository): JsonResponse
    {
        $categoria = $repository->findOneBy(['id' => $categoria_id]);
        $articles = $categoria->getArticles();
        $data = [];

        foreach ($articles as $article) {
            $data[] = [
                'aticle_id' => $article->getId(),
                'article_titol' => $article->getTitol(),
                'article_autor' => $article->getAutor()->getUsername(),
                'article_num_comentaris' => count($article->getComentaris())
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * METODE PER OBTENIR ELS COMENTARIS D'UN ARTICLE
     * @Route("/api/getComentaris/{article_id}", name="apiGetComentarisArticle", methods={"GET"})
     */
    public function getComentarisArticle($article_id, ArticleRepository $articles_repo, ComentariRepository $repository)
    {
        $article = $articles_repo->findOneBy(['id' => $article_id]);

        $comentaris = $article->getComentaris();
        $data = [];

        foreach ($comentaris as $comentari) {
            $data[] = [
                'comentari_id' => $comentari->getId(),
                'comentari_tipus' => $comentari->getTipus(),
                'comentari_text' => $comentari->getText(),
                'comentari_autor' => $comentari->getUser()->getUsername(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * METODE PER AFEGRI UN COMENTARI via API
     * El JSON d'entrada ha de contenir un objecte amb article_id, comentari_tipus i comentari text
     * @Route("/api/postComentari", name="apiPostComentari", methods={"POST"})
     */
    public function postComentari(Request $request, UserRepository $user_repo, ArticleRepository $articles_repo): JsonResponse
    {
        //Descodificar dades rebudes per JSON
        $data = json_decode($request->getContent(), true);

        //Pasar les dades del JSON a variables locals
        $article_id = $data['article_id'];
        $comentari_tipus = $data['comentari_tipus'];
        $comentari_text = (string) $data['comentari_text'];

        //Obtenir usuari que faré servir sempre per aquest exercici
        $user = $user_repo->findOneBy(['nom_usuari' => 'anonimAPI']);
        //Obtenir l'article al que es vol referenciar el comentari
        $article = $articles_repo->findOneBy(['id' => $article_id]);

        //Crear un objecte comentari amb les dades JSON i default
        $comentari = new Comentari();
        $comentari->setUser($user)
            ->setTipus($comentari_tipus)
            ->setText($comentari_text)
            ->setArticle($article)
            ->setDataPublicacio(new \DateTime())
            ->setVisible(false);

        //Si hi havia dades buides, tirar una excepció
        if (empty($article_id) || empty($comentari_tipus) || empty($comentari_text)) {
            throw new NotFoundHttpException('No s\ha pogut afegir el comentari per falta de dades');
        } else {
            //Del contrari, si hi havia dades, les pugem a la DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comentari);
            $entityManager->flush();
        }
        //returnar misatge de resultats
        return new JsonResponse(['status' => 'Comentari afegit!'], Response::HTTP_CREATED);
    }

    /**
     * METODE PER MODIFICAR L'ESTAT VISIBLE D'UN COMENTARI
     * El JSON d'entrada ha de contenir un objecte amb comentari_id, visible(booleà)
     * @Route("/api/putComentari", name="apiPutComentari", methods={"PUT"})
     */
    public function putComentari(Request $request, ComentariRepository $repository): JsonResponse
    {
        //Descodificar dades rebudes per JSON
        $data = json_decode($request->getContent(), true);

        //Pasar les dades del JSON a variables locals
        $comentari_id = $data['comentari_id'];
        $comentari_visible = $data['comentari_visible'];


        //Si hi havia dades buides, tirar una excepció
        if (empty($comentari_id) || empty($comentari_visible)) {
            throw new NotFoundHttpException('No s\ha pogut modificar el comentari per falta de dades');
        } else {
            //Del contrari, si hi havia dades, obtenir el comentari de la DB
            $comentari = $repository->findOneBy(['id' => $comentari_id]);
            //Modificar-ne la visibilitat
            $comentari->setVisible($comentari_visible);
            //Persisitir dades a la DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comentari);
            $entityManager->flush();
        }
        //returnar misatge de resultats
        return new JsonResponse(['status' => 'Comentari modificat!'], Response::HTTP_CREATED);
    }


    /**
     * METODE PER ELIMINAR UN COMENTARI
     * El JSON d'entrada ha de contenir un objecte amb comentari_id.
     * Per garantir la integritat del projecte el metode requereix d'un password
     * @Route("/api/deleteComentari", name="apiDeleteComentari", methods={"DELETE"})
     */
    public function deleteComentari(Request $request, ComentariRepository $repository): JsonResponse
    {
        //Descodificar dades rebudes per JSON
        $data = json_decode($request->getContent(), true);

        //Pasar les dades del JSON a variables locals
        $comentari_id = $data['comentari_id'];
        $password = $data['password'];

        //Si hi havia dades buides, tirar una excepció
        if (empty($comentari_id) || empty($password)) {
            throw new NotFoundHttpException('No s\ha pogut eliminar el comentari per falta de dades');
        } else if ($password == 'm07act41') {
            //Del contrari, si hi havia dades, obtenir el comentari de la DB
            $comentari = $repository->findOneBy(['id' => $comentari_id]);
            //Eliminar de la DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comentari);
            $entityManager->flush();
        }
        //returnar misatge de resultats
        return new JsonResponse(['status' => 'Comentari eliminat!'], Response::HTTP_CREATED);
    }
}
