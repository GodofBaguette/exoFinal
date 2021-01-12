<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil/{name}", name="profil")
     */
    public function index(): Response
    {
        
        $user = $this->getUser();

        $article = $user->getArticles();      

        return $this->render('article/idarticle.html.twig', [
            'articles' => $article,
        ]);
    }

    /**
     * @Route("/product/update/{id}", name="update")
     */
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Article::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('id_article', [
            'id' => $product->getId()
        ]);
    }
}
