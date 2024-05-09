<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Dompdf\Dompdf;
use Twilio\Rest\Client;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    
    /*#[Route('/menu', name: 'app_addMenu2')]
    public function addMenu(): Response
    {
        return $this->render('menu/addMenu.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }*/


    #[Route('/menuFront/{id}', name: 'menu_showFront')]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/menuFront.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route('/listMenuFront', name: 'menuList_showFront')]
    public function showMenuF(MenuRepository $menuRepository): Response
    {
        $menu = $menuRepository->findAll();
        

        return $this->render('menu/listMenuFront.html.twig', [
            'controller_name' => 'MenuController',
            'menu'  => $menu,
        ]);
    }

    #[Route('/menuList', name: 'app_menu_getAll')]
    public function showMenu(MenuRepository $menuRepository): Response
    {
        $menu = $menuRepository->findAll();
        

        return $this->render('menu/showMenu.html.twig', [
            'controller_name' => 'MenuController',
            'menu'  => $menu,
        ]);
    }

    #[Route('/addMenu', name: 'app_addMenu')]
    public function new(Request $request, ManagerRegistry $doctrine) : Response {
        $entityManager = $doctrine->getManager();
        // creates a menu object and initializes some data for this example
        //$restaurant = $entityManager->getRepository(Restaurant::class)->find(2);
        $menu = new Menu();
        //$menu->setRestaurantid($restaurant);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($menu);
        $form = $this->createForm(MenuType::class, $menu); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $data = $form->getData();
            // dump($menu); for debugging
            // TODO ... perform some action, such as saving the task to the database
            $menu->setIngredientsp($data->getIngredientsp());
            $menu->setPricep($data->getPricep());
            $menu->setNamep($data->getNamep());
            $menu->setCategoryp($data->getCategoryp());
            $menu->setImagep($data->getImagep());

            $entityManager->flush();
            return $this->redirectToRoute('app_menu_getAll');
        }
        // rendering the form
        return $this->render('menu/addMenu.html.twig', [
            'form' => $form->createView(),
        ]);
             
    }



    #[Route('/deleteMenu/{id}', name: 'app_menu_delete')]
    public function deleteMenu(ManagerRegistry $doctrine, MenuRepository $menuRepository, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $menu = $menuRepository->find($id);
        $entityManager->remove($menu);
        $entityManager->flush();
        return $this->redirectToRoute('app_menu_getAll');
    }

    #[Route('/editMenu/{id}', name: 'app_menu_edit')]
    public function editMenu(ManagerRegistry $doctrine,Request $request, Menu $menu , MenuRepository $menuRepository, int $id): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            // $entityManager->persist($product), but it isn't necessary: 
            // Doctrine is already "watching" your object for changes.
            $entityManager->flush();
            $this->addFlash('success', 'post.updated_successfully');

            return $this->redirectToRoute('app_menu_getAll');
        }
        
        return $this->render('menu/editMenu.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/pdfMenu", name="menuPDF", methods={"GET"})
     */
    public function pdfMenu(MenuRepository $menuRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('menu/pdfMenu.html.twig', [
            'menu' => $menuRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Menu.pdf", [
            "menu" => true
        ]);
    }
}
