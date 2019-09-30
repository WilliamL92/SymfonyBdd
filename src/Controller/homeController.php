<?php

namespace App\Controller;
use App\Entity\Article;
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
        ->setPu($request->get('pu'));

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

      public function personnes(){
        return $this->render('personnes.html.twig');
    }

}

?>