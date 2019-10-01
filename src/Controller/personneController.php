<?php

namespace App\Controller;
use App\Entity\Article;
use App\Entity\Personnes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class personneController extends AbstractController{

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