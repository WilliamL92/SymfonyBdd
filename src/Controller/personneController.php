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

private $manager;

public function __construct(EntityManagerInterface $manager){
    $this->manager = $manager;
}

/**
* @Route("/personnes", name="personnes")
*/

    public function liste_personne(EntityManagerInterface $manager2){

        $personnes = $manager2->getRepository(Personnes::class)->findAll();

        return $this->render("personnes.html.twig", array("pers" => $personnes));

    }

/**
 * @Route("/descriptionP/{id_pers}", name="detailP");
 */

public function detailpersonne($id_pers){
    $personne = $this->manager->getRepository(Personnes::class)->find($id_pers);
    return $this->render("details_pers.html.twig", ["nom" => "Details", "detailsP" => $personne]);
}

/**
 * @Route("/suppressionP/{id_pers}", name="suppressionP", requirements={"id_pers"="\d+"})
 */

public function suppressionPersonne($id_pers){

    $personne = $this->manager->getRepository(Personnes::class)->find($id_pers);
    
    $this->manager->remove($personne);
    $this->manager->flush();
    
    return $this->redirectToRoute("personne");
    
     }

 /**
  * @Route("/updateP/{id_pers}", name="modifyP", requirements={"id_pers"="\d+"})
  */

  public function update($id_pers, Request $request){
    $personne = $this->manager->getRepository(Personnes::class)->find($id_pers);
    
    $personne->setNom($request->get("nom"))
    ->setPrenom($request->get("prenom"));
    
    $this->manager->persist($personne);
    $this->manager->flush();
    
    return $this->redirectToRoute("personne", array("pers" => $personne));
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
        $this->addFlush("warning", "Erreur de saisie");
            }
        return $this->redirectToRoute("personnes");
    }
}

?>