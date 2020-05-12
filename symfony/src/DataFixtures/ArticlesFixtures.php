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

        //Creem un usuari amb role admin, per afegir alguns articles de prova
        $admin = new User();
        $admin->setEmail('admin@admin.com')
            ->setNom('Aleix')->setCognom('Revesado')->setCodiPostal('08400')
            ->setNomUsuari('aleixMaki')->setDataRegistre(new DateTime())
            ->setPassword($this->passwordEncoder->encodePassword($admin, "admin"))
            ->setImatge('62-5ebb15c428d2f.jpeg');

        $roles = ["ROLE_ADMIN"];
        $admin->setRoles($roles);

        $manager->persist($admin);

        //Creem algunes categories predefinides per anar provant
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

        /**
         * Aquesta categoria, s'ha de manualment cambiar l'ID a la base de dades
         * per un valor molt alt (p.e; 100) ja que d'aquest manera, sempre sortirà
         * com a l'ultima categoria al desplegable del frontend.
         * Si l'autoincrement de l'index ID, fa saltar a valors 101, 102...
         * haurem de fer-ho a l'inversa, posar-la com a primera opcio
         * */

        $nova_categoria = new Categoria();
        $nova_categoria->setNom('afegir nova categoria');
        $nova_categoria->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
        $manager->persist($nova_categoria);


        //Creem alguns articles lorem ipsum de prova per poder treballar amb el frontend
        
        //ARTICLE 1
        $titol_php1 = "Funciones PHP para validar formularios";

        $article_php1 = new Article();
        $article_php1->setTitol($titol_php1)
        ->setSubtitol('htmlentities() vs htmlspecialchars() vs FILTER_INPUT')
        ->setDataPublicacio(new DateTime())
        ->setSlug(str_replace(" ", "-", $titol_php1))
        ->setUser($admin)
        ->setCategoria($categoria_php)
        ->setTagMeta(['form', 'php', 'htmlentities', 'htmlspecialchars', 'FILTER_INPUT'])
        ->setContingut("Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem eaque ipsa, praesentium officia illo dignissimos aperiam ex veritatis qui optio quaerat tempore impedit enim esse unde, autem obcaecati. Excepturi, provident?");
        
        $manager->persist($article_php1);

        //ARTICLE 2
        $titol_php2 = "Model Vista Controlador (MVC) amb PHP";

        $article_php2 = new Article();
        $article_php2->setTitol($titol_php2)
        ->setSubtitol("Estrucutura bàsica d'un MVC")
        ->setDataPublicacio(new DateTime())
        ->setSlug(str_replace(" ", "-", $titol_php2))
        ->setUser($admin)
        ->setCategoria($categoria_php)
        ->setTagMeta(['mvc', 'php', 'modelo', 'vista', 'controlador'])
        ->setContingut("Exercitationem eaque ipsa, praesentium officia illo dignissimos aperiam ex veritatis qui optio quaerat tempore impedit enim esse unde, autem obcaecati. Excepturi, provident?");
        $manager->persist($article_php2);

        $manager->flush();

    }
}
