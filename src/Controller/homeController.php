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

}

?>