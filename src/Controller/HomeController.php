<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return new Response("<html><body>Voici mon site</body></html>");
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }

    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello(string $name): Response
    {
        return $this->render('home/hello.html.twig', ["name" => ucfirst($name)]);
    }

    #[Route('/base', name: 'app_base')]
    public function base(): Response
    {
        return $this->render('home/base.html.twig');
    }


    #[Route('/random', name: 'app_random')]
    public function random(): Response
    {
        $citations = [
            "La vie est un mystère qu'il faut vivre, et non un problème à résoudre.",
            "Le succès, c’est tomber sept fois, se relever huit.",
            "La simplicité est la sophistication suprême.",
            "Fais de ta vie un rêve, et d’un rêve une réalité.",
        ];

        $citationDuJour = $citations[array_rand($citations)];

        return $this->render('home/random.html.twig', [
            'citation' => $citationDuJour
        ]);
    }




}
