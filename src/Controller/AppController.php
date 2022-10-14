<?php

namespace App\Controller;

use App\Service\CartService;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    // #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
    
    /**
     * @Route("/produits", name="produits")
     */
    // #[Route('/produits', name: 'produits')]
    public function produits(ProduitRepository $repo, CartService $cs): Response
    {

        $produits = $repo->findAll();
        // $qt = getCartWithData();

        return $this->render('app/produits.html.twig', [
            'produits' => $produits,
            // 'qt' => $qt
        ]);
    }
    
    /**
     * @Route("/profil", name="profil")
     */
    // #[Route('/profil', name: 'profil')]
    public function profil(CommandeRepository $repo, CartService $cs): Response
    {
        $commandes = $repo->findAll();

        return $this->render('app/profil.html.twig', [
            'commandes' => $commandes
        ]);
    }
}
