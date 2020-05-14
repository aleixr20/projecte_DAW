<?php

namespace App\DataFixtures;

use App\Entity\HomepageSections;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class HomepageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $section1 = new HomepageSections();
        $section1->setTitol("Quienes somos y esas cosas")
        ->setSubtitol("text de subtitol")
        ->setContingut("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Posuere ac ut consequat semper viverra nam libero justo laoreet. At imperdiet dui accumsan sit amet nulla. Fermentum leo vel orci porta non pulvinar neque laoreet. Praesent tristique magna sit amet purus gravida quis. Integer quis auctor elit sed. Nunc sed velit dignissim sodales ut eu sem integer vitae. Fringilla est ullamcorper eget nulla facilisi etiam. Scelerisque eu ultrices vitae auctor. Vestibulum mattis ullamcorper velit sed. Tristique magna sit amet purus gravida quis blandit turpis cursus. Morbi tristique senectus et netus et malesuada fames ac. Egestas quis ipsum suspendisse ultrices gravida dictum. Id venenatis a condimentum vitae sapien. Quis ipsum suspendisse ultrices gravida dictum fusce ut placerat. Montes nascetur ridiculus mus mauris vitae ultricies.")
        ->setVisible(true)
        ->setMenulink("NERDS to DEVELOPE");
        $manager->persist($section1);

        $section2 = new HomepageSections();
        $section2->setTitol("Llista de categories")
        ->setSubtitol("text alternatiu")
        ->setContingut("Eget nunc lobortis mattis aliquam. Ut lectus arcu bibendum at varius vel pharetra vel. Fusce ut placerat orci nulla pellentesque. Eu non diam phasellus vestibulum lorem sed risus ultricies. Diam in arcu cursus euismod quis viverra nibh cras pulvinar. Euismod elementum nisi quis eleifend quam adipiscing vitae proin sagittis. Volutpat consequat mauris nunc congue nisi vitae suscipit. Consectetur adipiscing elit duis tristique sollicitudin nibh sit amet commodo. Pellentesque adipiscing commodo elit at imperdiet dui. Enim tortor at auctor urna nunc id cursus metus aliquam. Magna fringilla urna porttitor rhoncus dolor purus non enim. Quis hendrerit dolor magna eget est lorem ipsum dolor. Nulla aliquet enim tortor at. Mattis aliquam faucibus purus in massa tempor nec feugiat nisl.")
        ->setVisible(true)
        ->setMenulink("SOFT SKILLS");
        $manager->persist($section2);

        $section3 = new HomepageSections();
        $section3->setTitol("Contacte amb nosaltres")
        ->setSubtitol("text alternatiu")
        ->setContingut("Eget nunc lobortis mattis aliquam. Ut lectus arcu bibendum at varius vel pharetra vel. Fusce ut placerat orci nulla pellentesque. Eu non diam phasellus vestibulum lorem sed risus ultricies. Diam in arcu cursus euismod quis viverra nibh cras pulvinar. Euismod elementum nisi quis eleifend quam adipiscing vitae proin sagittis. Volutpat consequat mauris nunc congue nisi vitae suscipit. Consectetur adipiscing elit duis tristique sollicitudin nibh sit amet commodo. Pellentesque adipiscing commodo elit at imperdiet dui. Enim tortor at auctor urna nunc id cursus metus aliquam. Magna fringilla urna porttitor rhoncus dolor purus non enim. Quis hendrerit dolor magna eget est lorem ipsum dolor. Nulla aliquet enim tortor at. Mattis aliquam faucibus purus in massa tempor nec feugiat nisl.")
        ->setVisible(true)
        ->setMenulink("CONTACTE");
        $manager->persist($section3);
        
        $manager->flush();
    }
}
