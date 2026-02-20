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
            // RÉCUPÉRATION DE L’IMAGE
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                //ON STOCKE LE NOM DU FICHIER EN BASE
                $recipe->setImage($newFilename);
            }

            $em = $doctrine->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('read_recipe', [
                'id' => $recipe->getId()
            ]);
        }

        return $this->render('recipe/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route("/recipe/edit/{id}", name: "recipe_edit")]
    public function edit(Request $request, ManagerRegistry $doctrine, Recipe $recipe): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $recipe->setImage($newFilename);
            }

            $em = $doctrine->getManager();
            $em->flush();

            return $this->redirectToRoute('read_all_recipe', ['id' => $recipe->getId()]);

        }

        return $this->render("recipe/form.html.twig", [
            "form" => $form->createView()
        ]);
    }



    #[Route("recipe/read/{id}", name: "read_recipe")]
    public function read(Recipe $recipe): Response
    {
        return $this->render('recipe/read.html.twig', ['recipe' => $recipe]);
    }

    #[Route("recipe/read-all", name: "read_all_recipe")]
    public function readAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Recipe::class);
        $recipe = $repository->findAll();
        return $this->render('recipe/read-all.html.twig', ['recipe' => $recipe]);
    }

    #[Route("/recipe/delete/{id}", name: "delete_recipe")]
    public function delete(ManagerRegistry $doctrine, Recipe $recipe): Response
    {
        $em = $doctrine->getManager();
        $em->remove($recipe);
        $em->flush();
        return $this->redirectToRoute("manage_recipe");
    }

    #[Route("/recipe/manage", name: "manage_recipe")]
    public function manage(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Recipe::class);
        $recipes = $repository->findAll();

        return $this->render('recipe/manage.html.twig', [
            'recipes' => $recipes
        ]);
    }

}

