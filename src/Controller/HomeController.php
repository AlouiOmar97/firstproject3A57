<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home2')]
    public function index(): Response
    {
        $title="3A57";
        dump('bonjour');
        dd($title);
       // die();
        return $this->render('home/index2.html.twig', [
            'controller_name' => 'Accueil',
            't'=>$title
        ]);
    }

    #[Route('/home/{name}', name: 'app_home')]
    public function index2($name):      Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home Controller!',
            'name'=> $name
        ]);
    }


    #[Route('/hello', name:'app_hello')]
    public function hello(){
        return new Response('Bonjour mes étudiants');
    }

    #[Route('/bonjour', name:'app_bonjour')]
    public function goToHello(){
        return $this->redirectToRoute('app_hello');
    }

}
