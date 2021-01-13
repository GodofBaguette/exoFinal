<?php

namespace App\Controller;

use App\Entity\Article;
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
}
