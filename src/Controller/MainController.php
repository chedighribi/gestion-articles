<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home', methods: ['GET'])]
    public function home(): Response {
        return $this->render('main/home.html.twig');
    }
    #[Route('/other', name: 'main_other', methods: ['GET'])]
    public function other(): Response {
        return new Response('other test!');
    }

    #[Route('/about-us', name:'main_about', methods: ['GET'])]
    public function aboutUs(): Response {
        return $this->render('main/about_us.html.twig');
    }


}