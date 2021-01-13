<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
            'user' => $user,
        ]);
    }

    /**
     * @Route("/idarticle/delete/{id}", name="delete")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $article = $entityManager->getRepository(Article::class)->find($id);
        

        $entityManager->remove($article);

        $entityManager->flush();

        return $this->redirectToRoute('profil', [
            'name' => $this->getUser()->getUsername()
        ]);
    }

    /**
     * @Route("/idarticle/update/{id}", name="update")
     */
    public function update(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $article = $entityManager->getRepository(Article::class)->find($id);
        
        if (!$article) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('profil', [
                'name' => $this->getUser()->getUsername()
            ]);
        }

        return $this->render('article/updateArticle.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }


    /**
     * @Route("/profil/manage/{name}", name="manage")
     */
    public function manageProfile(Request $request, UserPasswordEncoderInterface $encode): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        

        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encode->encodePassword($user,$user->getPassword()));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profil', [
                'name' => $this->getUser()->getUsername()
            ]);
        }

        return $this->render('profil/manage.html.twig', [
            'formUser' => $form->createView()
        ]);
    }
}
