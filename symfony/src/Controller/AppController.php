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
     * Obtenir numero de "likes" d'un article
     *
     *********************************************************/


    /**
     * @Route("/editor", name="inline_editor_article", methods={"GET"})
     */
    public function inlineEditorArticle()
    {

        return $this->render('inline_editor/full_editor.html.twig');
    }

    /**
     * @Route("/editor/{slugArticle}", name="inline_editor", methods={"GET"})
     */
    public function inlineEditor($slugArticle, ArticleRepository $repositoryArticle)
    {

        $article = $repositoryArticle->findOneBy(['slug' => $slugArticle]);

        $html = $article->getHtml();
        $css = $article->getCss();
        $js = $article->getJs();

        if(!isset($html)){
            $html = "";
        }

        if(!isset($css)){
            $css = "";
        }

        if(!isset($js)){
            $js = "";
        }

        return $this->render('inline_editor/full_editor.html.twig', [
            'html' => $html,
            'css' => $css,
            'js' => $js
        ]);
    }


}
