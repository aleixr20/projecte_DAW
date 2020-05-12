<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use App\Entity\User;
//use App\Entity\Tema;
use App\Entity\Article;
use App\Entity\Categoria;

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

         $admin = new User();
         $admin->setEmail('admin@admin.com')
        ->setNom('Aleix')->setCognom('Revesado')->setCodiPostal('08400')
        ->setNomUsuari('aleixMaki')->setDataRegistre(new DateTime())
         ->setPassword($this->passwordEncoder->encodePassword($admin, "admin"));
         $manager->persist($admin);
        
        $categoria_php = new Categoria();
        $categoria_php->setNom('PHP');
        $categoria_php->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
        $manager->persist($categoria_php);

        $categoria_css = new Categoria();
        $categoria_css->setNom('CSS');
        $categoria_css->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
        $manager->persist($categoria_css);

        $categoria_html = new Categoria();
        $categoria_html->setNom('HTML');
        $categoria_html->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
        $manager->persist($categoria_html);

        $categoria_js = new Categoria();
        $categoria_js->setNom('JS');
        $categoria_js->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
        $manager->persist($categoria_js);

        $categoria_java = new Categoria();
        $categoria_java->setNom('Java');
        $categoria_java->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
        $manager->persist($categoria_java);

        

        $manager->flush();

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


