<?php

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Personnes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class articleController extends AbstractController{

    private $manager;

public function __construct(EntityManagerInterface $manager){
    $this->manager = $manager;
}

/**
 * @Route("/description/{id_art}", name="detail");
 */

 public function detailArticle($id_art){
     $article = $this->manager->getRepository(Article::class)->find($id_art);
     return $this->render("details_art.html.twig", ["nom" => "Details", "details" => $article]);
 }

/**
 * @Route("/suppression/{id_art}", name="suppression", requirements={"id_art"="\d+"})
 */

 public function suppression($id_art){

$article = $this->manager->getRepository(Article::class)->find($id_art);

$this->manager->remove($article);
$this->manager->flush();

return $this->redirectToRoute("article");

 }

 /**
  * @Route("/update/{id_art}", name="modify", requirements={"id_art"="\d+"})
  */

  public function update($id_art, Request $request){
$article = $this->manager->getRepository(Article::class)->find($id_art);

$article->setLibelle($request->get("libelle"))
->setPu($request->get("pu"))
->setQuantity($request->get("quantity"))
->setStatut($request->get("statut"));

$this->manager->persist($article);
$this->manager->flush();

return $this->redirectToRoute("article", array("art" => $article));
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

}

?>