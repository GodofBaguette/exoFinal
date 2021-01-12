<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        $user = new User();      
        $user->setEmail('nico@nico.fr');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->passwordEncoder->encodePassword($user,'password'));
        $manager->persist($user);
        $manager->flush();

        $user1 = new User();      
        $user1->setEmail('bibi@bibi.fr');
        $user1->setRoles(["ROLE_USER"]);
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,'password2'));
        $manager->persist($user1);
        $manager->flush();


        $userAdmin = new User();
        $userAdmin->setEmail("jean@jean.fr");
        $userAdmin->setRoles(["ROLE_USER","ROLE_ADMIN"]);
        $userAdmin->setPassword($this->passwordEncoder->encodePassword($userAdmin,'admin'));
        $manager->persist($userAdmin);
        $manager->flush();


        $article1 = new Article();
        $article1->setTitle('Nico')
                ->setContent("Salut c'est nico")
                ->setUser($user);
        $manager->persist($article1);

        $article2 = new Article();
        $article2->setTitle('Nico2')
                ->setContent("Salut c'est nico2")
                ->setUser($user);
        $manager->persist($article2);

        $article3 = new Article();
        $article3->setTitle('jean')
                ->setContent("Salut c'est jean")
                ->setUser($userAdmin);
        $manager->persist($article3);

        $article4 = new Article();
        $article4->setTitle('bibi')
                ->setContent("Salut c'est bibi")
                ->setUser($user1);
        $manager->persist($article4);

        $manager->flush();
    }
}
