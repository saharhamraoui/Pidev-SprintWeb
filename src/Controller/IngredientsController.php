<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Entity\Recette;
use App\Form\IngredientType;
use App\Repository\IngredientsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Routing\Annotation\Route;

class IngredientsController extends AbstractController
{

    #[Route('/ingredientsList/{id}', name: 'app_ingredients_getAll')]
    public function showingredients(int $id,IngredientsRepository $ingredientsRepository,ManagerRegistry $doctrine): Response
    {
        $ingredients = $ingredientsRepository->findAll();
        $entityManager = $doctrine->getManager();
        $recette = $entityManager->getRepository(Recette::class)->find($id);

        return $this->render('ingredients/showIngredients.html.twig', [
            'controller_name' => 'IngredientsController',
            'ingredients'  => $ingredients,
            'id' => $id,
            'recette' => $recette,
        ]);
    }


    #[Route('/addIngredient/{id}', name: 'app_addIngredient')]
    public function newIng($id,Request $request, ManagerRegistry $doctrine) : Response {
        $entityManager = $doctrine->getManager();
        $recipe = $entityManager->getRepository(Recette::class)->find($id);
        if (!$recipe) {throw $this->createNotFoundException('Recette not found');}
        $recipe = $this->getDoctrine()
        ->getRepository(Recette::class)
        ->find($id);

        // creates an ingredients object and initializes some data for this example
        //$recipe = $entityManager->getRepository(Recette::class)->find(2);
        $ingredients = new Ingredients();
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($ingredients);
        $form = $this->createForm(IngredientType::class, $ingredients); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $data = $form->getData();
            //dump($ingredients); //for debugging
            $ingredients->setNameing($data->getNameing());
            $ingredients->setAmount($data->getAmount());
            $ingredients->setIDrec($recipe);

            $entityManager->flush();
            return $this->redirectToRoute('app_ingredients_getAll',['id' => $id]);
        }
        // rendering the form

        return $this->render('ingredients/addIngredient.html.twig', [
            'id' => $id,
            'form' => $form->createView(),
        ]);
             
    }


    #[Route('/deleteingredient/{id}', name: 'app_ingredients_delete')]
    public function deleteIngredients(ManagerRegistry $doctrine, IngredientsRepository $ingredientsRepository, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $ingredient = $ingredientsRepository->find($id);
        $recipe = $entityManager->getRepository(Recette::class)->find($ingredient->getIdrec());

        $entityManager->remove($ingredient);
        $entityManager->flush();
        return $this->redirectToRoute('app_ingredients_getAll',
        ['id' => $recipe->getIdrec()]);
    }


    #[Route('/edit/{id}', name: 'app_ingredients_edit')]
    public function editIngredients(ManagerRegistry $doctrine,Request $request, Ingredients $ingredients , IngredientsRepository $ingredientsRepository, int $id): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredients);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            // $entityManager->persist($product), but it isn't necessary: 
            // Doctrine is already "watching" your object for changes.
            $entityManager->flush();
            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('app_ingredients_getAll',['id' => $id]);
        }
        
        return $this->render('ingredients/editIngredients.html.twig', [
            'ingredients' => $ingredients,
            'form' => $form->createView(),
        ]);
    }
}
