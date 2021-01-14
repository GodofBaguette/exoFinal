<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */

class AdminController extends AbstractController
{
    /**
     * @Route("/profil/{name}/admin", name="admin")
     */
    public function index(): Response
    {
        $article = $this->getDoctrine()
                        ->getRepository(Article::class)
                        ->findAll();

        return $this->render('admin/index.html.twig', [
            'articles' => $article,
        ]);
    }

    /**
     * @Route("/profil/{id}/admin/report", name="report")
     */
    public function report(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $article = $entityManager->getRepository(Article::class)->find($id);

        $article->setReport(TRUE);

        $entityManager->persist($article);

        $entityManager->flush();

        return $this->redirectToRoute('admin', [
            'name' => $this->getUser()->getUsername()
        ]);
    }

    /**
     * @Route("/profil/{name}/admin/alluser", name="allUser")
     */
    public function allUser(): Response
    {
        $user = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->findAll();

        return $this->render('admin/userDelete.html.twig', [
            'users' => $user,
        ]);
    }

    /**
     * @Route("/profil/{name}/admin/deleteuser/{id}", name="deleteUser")
     */
    public function deleteUser(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $user = $entityManager->getRepository(User::class)->find($id);
        

        $entityManager->remove($user);

        $entityManager->flush();

        return $this->redirectToRoute('allUser', [
            'name' => $this->getUser()->getUsername()
        ]);
    }
}
