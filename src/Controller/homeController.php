<?php

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Personnes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class homeController extends AbstractController{

    /**
     * @Route("/home", name="home")
     */

    public function home(){
        return $this->render('index.html.twig');
    }

     /**
      * @Route("/articles", name="articles")
      */

      public function liste_article(EntityManagerInterface $manager){

        $articles = $manager->getRepository(Article::class)->findAll();

        return $this->render("articles.html.twig", array("art" => $articles));

    }

/**
 * @param EntityManagerInterface $manager
 * @param Request $request
 * @Route("/create_new_article", methods="POST", name="create")
 */

    public function new_article(EntityManagerInterface $manager, Request $request){

        $article = new Article();

        $article->setLibelle($request->get('libelle'))
        ->setPu($request->get('pu'))
        ->setQuantity($request->get('quantity'))
        ->setStatut($request->get('statut'));

try{
    $manager->persist($article);
    $manager->flush();

}
catch(UniqueConstraintViolationException $e){
$this->addFlush("warning", 
                "Duplication de libelle"
);
}

        return $this->redirectToRoute("articles");

    }

      /**
      * @Route("/personnes", name="personnes")
      */

    public function liste_personne(EntityManagerInterface $manager2){

        $personnes = $manager2->getRepository(Personnes::class)->findAll();

        return $this->render("personnes.html.twig", array("pers" => $personnes));

    }

    /**
 * @param EntityManagerInterface $manager
 * @param Request $request
 * @Route("/create_new_personnes", methods="POST", name="createPersonne")
 */

public function new_personnes(EntityManagerInterface $manager, Request $request){

    $personnes = new Personnes();

    $personnes->setNom($request->get('nom'))
    ->setPrenom($request->get('prenom'));

try{
$manager->persist($personnes);
$manager->flush();

}
catch(UniqueConstraintViolationException $e){
$this->addFlush("warning", 
            "Erreur de saisie"
);
}

    return $this->redirectToRoute("personnes");

}

}

?>