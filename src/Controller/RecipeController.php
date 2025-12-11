<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

class RecipeController extends AbstractController
{
    #[Route('/recipe/new', name: 'recipe_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($recipe);
            $em->flush();
        }

        return $this->render('recipe/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

}

