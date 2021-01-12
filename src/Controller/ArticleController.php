<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/idarticle/{id}", name="id_article")
     */
    public function index(int $id): Response
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);
        

        return $this->render('article/index.html.twig', [
            'articleTitle' => $article->getTitle(),
            'articleContent' => $article->getContent(),
        ]);
    }
}
