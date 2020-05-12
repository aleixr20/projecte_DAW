<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use App\Entity\User;
use App\Entity\Tema;
use App\Entity\Article;
use DateTime;

class ArticlesFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        // $admin = new User();
        // $admin->setEmail('admin@admin.com')
        // ->setPassword($this->passwordEncoder->encodePassword($admin, "admin"));
        // $manager->persist($admin);
        
        // $categoria_php = new Tema();
        // $categoria_php->setNom('PHP');
        // $manager->persist($categoria_php);

        // $categoria_css = new Tema();
        // $categoria_css->setNom('CSS');
        // $manager->persist($categoria_css);

        // $article_php1 = new Article();
        // $article_php1->setTitol("Funciones PHP para validar formularios")
        // ->setSubtitol('htmlentities() vs htmlspecialchars() vs FILTER_INPUT')
        // ->setDataPublicacio(new DateTime())
        // ->setSlug(str_replace(" ", "-", $article_php1->getTitol()))
        // ->setUser($admin)
        // ->setTema($categoria_php)
        // ->setContingut("Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem eaque ipsa, praesentium officia illo dignissimos aperiam ex veritatis qui optio quaerat tempore impedit enim esse unde, autem obcaecati. Excepturi, provident?");
        // $manager->persist($article_php1);

        // $article_php2 = new Article();
        // $article_php2->setTitol("Model Vista Controlador (MVC) amb PHP")
        // ->setSubtitol("Estrucutura bàsica d'un MVC")
        // ->setDataPublicacio(new DateTime())
        // ->setSlug(str_replace(" ", "-", $article_php1->getTitol()))
        // ->setUser($admin)
        // ->setTema($categoria_php)
        // ->setContingut("Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem eaque ipsa, praesentium officia illo dignissimos aperiam ex veritatis qui optio quaerat tempore impedit enim esse unde, autem obcaecati. Excepturi, provident?");
        // $manager->persist($article_php2);

        // // $product = new Product();
        // // $manager->persist($product);

        // $manager->flush();
    }
}


