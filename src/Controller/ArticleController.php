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
            'articleId' => $article->getId(),
        ]);
    }

    /**
     * @Route("/idarticle/{id}/warning", name="warning")
     */
    public function warning(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $article = $entityManager->getRepository(Article::class)->find($id);

        $report = $article->getReport();

        if($report === TRUE){
            return new Response('Votre article ne correspond à notre charte merci de le modifier');
        }else{
            return new Response("Cette article n'a aucun avertissement");
        }
    }
}
