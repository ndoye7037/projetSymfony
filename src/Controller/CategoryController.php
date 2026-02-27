<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;


class CategoryController extends AbstractController
{
    #[Route('/category/new', name: 'category_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $category = new Category();
        $form = $this->createForm(RecipeType::class, $category);
        $form->handleRequest($request);

        return $this->render('recipe/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route("/category/edit/{id}", name: "category_edit")]
    public function edit(Request $request, ManagerRegistry $doctrine, Category $category): Response
    {
        $form = $this->createForm(RecipeType::class, $category);
        $form->handleRequest($request);

        return $this->render("recipe/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route("category/read/{id}", name: "read_category")]
    public function read(Category $category): Response
    {
        return $this->render('category/read.html.twig', ['category' => $category]);
    }

    #[Route("category/read-all", name: "read_all_category")]
    public function readAll(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Category::class);
        $category = $repository->findAll();
        return $this->render('category/read-all.html.twig', ['category' => $category]);
    }

    #[Route("/category/delete/{id}", name: "delete_category")]
    public function delete(ManagerRegistry $doctrine, Category $category): Response
    {
        $em = $doctrine->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute("manage_category");
    }

    #[Route("/category/manage", name: "manage_category")]
    public function manage(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Category::class);
        $category = $repository->findAll();

        return $this->render('category/manage.html.twig', [
            'category' => $category
        ]);
    }
}
