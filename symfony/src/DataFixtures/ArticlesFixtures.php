<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


use App\Entity\User;
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
            ->setNom('Aleix')->setCognom('Revesado')
            ->setNomUsuari('aleixMaki')->setDataRegistre(new DateTime())
            ->setPassword($this->passwordEncoder->encodePassword($admin, "admin"))
            ->setImatge('perfil_random.png')
            ->setDescripcio('
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
            ')
            ->setGithub('aleixr20')
            ->setLinkedin('aleixLink20');
        $roles = ["ROLE_ADMIN"];
        $admin->setRoles($roles);
        $manager->persist($admin);

        $user1 = new User();
        $user1->setEmail('user1@admin.com')
            ->setNom('User')->setCognom('Uname')
            ->setNomUsuari('usuario')->setDataRegistre(new DateTime())
            ->setPassword($this->passwordEncoder->encodePassword($user1, "user1"))
            ->setImatge('62-5ec4629f12c91.jpeg')
            ->setDescripcio('
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et ltricies tristique nulla.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
            ')
            ->setGithub('yoquese')
            ->setLinkedin('miLinkedin');
        $roles = ["ROLE_VALIDATED"];
        $user1->setRoles($roles);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@admin.com')
            ->setNom('Paco')->setCognom('Malote')
            ->setNomUsuari('bigHacker')->setDataRegistre(new DateTime())
            ->setPassword($this->passwordEncoder->encodePassword($user2, "user2"))
            ->setDescripcio('
<p>Pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<p>Tortor condimentum lacam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
            ')
            ->setGithub('hacker')
            ->setLinkedin('random');

        $roles = ["ROLE_VALIDATED"];
        $user2->setRoles($roles);
        $manager->persist($user2);


        $user3 = new User();
        $user3->setEmail('user3@admin.com')
            ->setNom('Anonim')->setCognom('No Verified')
            ->setNomUsuari('quePalo')->setDataRegistre(new DateTime())
            ->setPassword($this->passwordEncoder->encodePassword($user3, "user3"));

        $roles = ["ROLE_USER"];
        $user3->setRoles($roles);
        $manager->persist($user3);


        //Creem algunes categories predefinides per anar provant
        $categoria_html = new Categoria();
        $categoria_html->setNom('HTML')
            ->setTipus('frontend')
            ->setLogo('html-5ebfc71598190.png');
        $manager->persist($categoria_html);

        $categoria_css = new Categoria();
        $categoria_css->setNom('CSS')
            ->setTipus('frontend')
            ->setColor('royalblue')
            ->setLogo('css-3-5ebbbde6704a2.svg');

        $manager->persist($categoria_css);

        $categoria_bootstrap = new Categoria();
        $categoria_bootstrap->setNom('Bootstrap')
            ->setTipus('frontend')
            ->setColor('purple')
            ->setLogo('bootstrap_logo.jpg');
        $manager->persist($categoria_bootstrap);

        $categoria_js = new Categoria();
        $categoria_js->setNom('JS')
            ->setTipus('frontend')
            ->setColor('gold')
            ->setLogo('js-5ebfc77478271.png');
        $manager->persist($categoria_js);

        $categoria_vue = new Categoria();
        $categoria_vue->setNom('VUE')
            ->setTipus('frontend')
            ->setColor('mediumseagreen')
            ->setLogo('vue_logo.png');
        $manager->persist($categoria_vue);

        //Backend
        $categoria_sql = new Categoria();
        $categoria_sql->setNom('SQL')
            ->setTipus('backend')
            ->setLogo('sql_logo.png');
        $manager->persist($categoria_sql);

        $categoria_mongo = new Categoria();
        $categoria_mongo->setNom('MongoDB')
            ->setTipus('backend')
            ->setLogo('mongodb_logo.png');
        $manager->persist($categoria_mongo);

        $categoria_php = new Categoria();
        $categoria_php->setNom('PHP')
            ->setTipus('backend')
            ->setColor('#9966ff')
            ->setLogo('php-5ebbbc8aa8516.svg');
        $manager->persist($categoria_php);

        $categoria_symfony = new Categoria();
        $categoria_symfony->setNom('Symfony')
            ->setTipus('backend')
            ->setLogo('symfony_logo.jpg');
        $manager->persist($categoria_symfony);

        $categoria_java = new Categoria();
        $categoria_java->setNom('Java')
            ->setTipus('backend')
            ->setLogo('java-logo-5ebfc790a1585.png');
        $manager->persist($categoria_java);

        //Sistemes
        $categoria_node = new Categoria();
        $categoria_node->setNom('Node')
            ->setTipus('sistemes')
            ->setLogo('nodejs_logo_1.png');
        $manager->persist($categoria_node);

        $categoria_apache = new Categoria();
        $categoria_apache->setNom('Apache')
            ->setTipus('sistemes')
            ->setLogo('apache_logo.png');
        $manager->persist($categoria_apache);

        $categoria_nginx = new Categoria();
        $categoria_nginx->setNom('NGINX')
            ->setTipus('sistemes')
            ->setLogo('nginx_logo.png');
        $manager->persist($categoria_nginx);
        /**
         * Aquesta categoria, s'ha de manualment cambiar l'ID a la base de dades
         * per un valor molt alt (p.e; 100) ja que d'aquest manera, sempre sortirà
         * com a l'ultima categoria al desplegable del frontend.
         * Si l'autoincrement de l'index ID, fa saltar a valors 101, 102...
         * haurem de fer-ho a l'inversa, posar-la com a primera opcio
         * */

        $nova_categoria = new Categoria();
        $nova_categoria->setNom('afegir nova categoria')
            ->setTipus('oculta')
            ->setLogo('http://www.squaredbrainwebdesign.com/images/resources/PHP-logo.png');
        $manager->persist($nova_categoria);




        //Creem alguns articles lorem ipsum de prova per poder treballar amb el frontend

        //ARTICLE 1
        $titol_php1 = "Funciones PHP para validar formularios";

        $article_php1 = new Article();
        $article_php1->setTitol($titol_php1)
            ->setResum('Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem eaque ipsa, praesentium officia illo dignissimos aperiam ex.')
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_php1)))
            ->setAutor($admin)
            ->addCategories($categoria_php)
            ->addCategories($categoria_symfony)

            ->setMetaTag('php,form,htmlentities')
            ->setContingut('
<p>Meetus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit.</p>          
<p>Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>           
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 
 
<p>Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<pre><code class="language-php hljs">
$postJson = $serializer-&gt;serialize($post, &#39;json&#39;, [
    &#39;circular_reference_handler&#39; =&gt; function ($object) {
    return $object-&gt;getId();aaa
    }
]);
</code></pre> 
 
<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>            
            ')
            ->setVisible(true);
        $manager->persist($article_php1);

        //ARTICLE 2
        $titol_php2 = "Model Vista Controlador (MVC) amb PHP";

        $article_php2 = new Article();
        $article_php2->setTitol($titol_php2)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_php2)))
            ->setAutor($admin)
            ->addCategories($categoria_php)
            ->setMetaTag('mvc,php,modelo,vista,controlador')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>
            ')
            ->setVisible(true);
        $manager->persist($article_php2);

        //ARTICLE 3
        $titol_apa1 = "Configuració Apache";

        $article_apa1 = new Article();
        $article_apa1->setTitol($titol_apa1)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_apa1)))
            ->setAutor($admin)
            ->addCategories($categoria_apache)
            ->setMetaTag('servidor,apache, localhost')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>
            ')
            ->setVisible(true);
        $manager->persist($article_apa1);

        //ARTICLE 4
        $titol_nginx1 = "Algo de JS";

        $article_nginx1 = new Article();
        $article_nginx1->setTitol($titol_nginx1)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_nginx1)))
            ->setAutor($admin)
            ->addCategories($categoria_js)
            ->addCategories($categoria_css)
            ->setMetaTag('servidor,nginx,localhost')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>
           ')
            ->setVisible(true);
        $manager->persist($article_nginx1);

        //ARTICLE 5
        $titol_sql1 = "funcions de geolocalitzacio amb JS";

        $article_sql1 = new Article();
        $article_sql1->setTitol($titol_sql1)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_sql1)))
            ->setAutor($admin)
            ->addCategories($categoria_js)
            ->addCategories($categoria_css)
            ->setMetaTag('bbdd,sql,')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>
            ')
            ->setVisible(true);
        $manager->persist($article_sql1);

        //ARTICLE 6
        $titol_mongo = "Configuració MongoDB";

        $article_mongo1 = new Article();
        $article_mongo1->setTitol($titol_mongo)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_mongo)))
            ->setAutor($user1)
            ->addCategories($categoria_mongo)
            ->setMetaTag('servidor,nginx,localhost')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>
            ')
            ->setVisible(false);
        $manager->persist($article_mongo1);

        //ARTICLE 7
        $titol_symfony1 = "Instal·lació Symfony";

        $article_symfony1 = new Article();
        $article_symfony1->setTitol($titol_symfony1)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_symfony1)))
            ->setAutor($user2)
            ->addCategories($categoria_symfony)
            ->setMetaTag('servidor,nginx,localhost')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>         
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

            ')
            ->setVisible(false);
        $manager->persist($article_symfony1);

        //ARTICLE 8
        $titol_symfony2 = "Crear Entity a Symfony";

        $article_symfony2 = new Article();
        $article_symfony2->setTitol($titol_symfony2)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_symfony2)))
            ->setAutor($user2)
            ->addCategories($categoria_symfony)
            ->setMetaTag('servidor,nginx,localhost')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>
            ')
            ->setVisible(true);
        $manager->persist($article_symfony2);

        //ARTICLE 9
        $titol_java1 = "VUE contra API";

        $article_java1 = new Article();
        $article_java1->setTitol($titol_java1)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_java1)))
            ->setAutor($admin)
            ->addCategories($categoria_vue)
            ->addCategories($categoria_js)

            ->setMetaTag('servidor,nginx,localhost')
            ->setContingut('<
p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>

            ')
            ->setVisible(true);
        $manager->persist($article_java1);

        //ARTICLE 10
        $titol_java2 = "Getters i setters(Java)";

        $article_java2 = new Article();
        $article_java2->setTitol($titol_java2)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_java2)))
            ->setAutor($admin)
            ->addCategories($categoria_java)
            ->setMetaTag('servidor,nginx,localhost')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<p>Ullamcorper morbi tincidunt ornare massa eget egestas purus viverra accumsan. Tempor commodo ullamcorper a lacus vestibulum sed arcu. Sit amet volutpat consequat mauris nunc congue. Dis parturient montes nascetur ridiculus mus mauris vitae. Magna fermentum iaculis eu non diam phasellus vestibulum.</p>
            ')
            ->setVisible(true);
        $manager->persist($article_java2);

        //ARTICLE 11
        $titol_html1 = "Algo de HTML";

        $article_htm1 = new Article();
        $article_htm1->setTitol($titol_html1)
            ->setResum("Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa.")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_html1)))
            ->setAutor($user1)
            ->addCategories($categoria_html)
            ->addCategories($categoria_css)

            ->setMetaTag('servidor,nginx,localhost')
            ->setContingut('
<p>Metus dictum at tempor commodo. Sapien et ligula ullamcorper malesuada proin libero nunc. Donec ac odio tempor orci dapibus ultrices in iaculis nunc. Risus nec feugiat in fermentum. Pulvinar sapien et ligula ullamcorper malesuada proin. Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.</p>
<p>Tortor condimentum lacinia quis vel eros donec ac odio. Varius quam quisque id diam vel quam elementum pulvinar etiam. Vestibulum rhoncus est pellentesque elit ullamcorper dignissim. Id semper risus in hendrerit. Elementum pulvinar etiam non quam lacus suspendisse faucibus interdum posuere. Urna et pharetra pharetra massa massa. Fermentum posuere urna nec tincidunt praesent.</p>
-ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
<p>Mi eget mauris pharetra et ultrices neque ornare. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Aliquet porttitor lacus luctus accumsan tortor posuere. Morbi tristique senectus et netus et malesuada fames ac.Vulputate dignissim suspendisse in est ante in nibh. Enim ut sem viverra aliquet eget sit amet tellus cras. Mattis molestie a iaculis at erat pellentesque adipiscing. Sed risus ultricies tristique nulla.</p>
<pre><code class="language-php hljs">
$result = $serializer-&gt;normalize($level1, null, [
    AbstractObjectNormalizer::ENABLE_MAX_DEPTH =&gt; true
]);
</code></pre> 

<ul>
    <li>Elementum pulvinar etiam</li>
    <li>non quam lacus suspendisse faucibus interdum posuere.</li>
    <li>Urna et pharetra pharetra massa massa.</li>
    <li>Fermentum posuere urna nec tincidunt praesent.</li>
</ul>
            ')
            ->setVisible(true);
        $manager->persist($article_htm1);

        //ARTICLE 12
        $titol_html2 = "Estructura HTML";

        $article_html2 = new Article();
        $article_html2->setTitol($titol_html2)
            ->setResum("Exemple bàsic de la estructura HTML")
            ->setDataPublicacio(new DateTime())
            ->setSlug(str_replace(" ", "-", strtolower($titol_html2)))
            ->setAutor($user1)
            ->addCategories($categoria_html)
            ->setMetaTag('html,disseny, estructures')
            ->setContingut('
<pre><code class="language-html hljs">
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset=utf-8>
<title>Sample HTML5 Structure</title>
</head>
<body>
    <div id="container">
        <header>
            <h1>Sample HTML5 web document</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </nav>
        </header>
        <section>
        <hgroup>
            <h1>Main Section</h1>
            <h2>This is a sample HTML5 Page</h2>
        </hgroup>
        <article>
            <p>Content of the first article</p>
        </article>
        <article>
            <p>Content of the second article</p>
        </article>
        </section>
        <footer>
            <p>This is the Footer of the web document</p>
        </footer>
    </div>
</body>
</html> 
            ')
            ->setVisible(true);
        $manager->persist($article_html2);




        $manager->flush();
    }
}
