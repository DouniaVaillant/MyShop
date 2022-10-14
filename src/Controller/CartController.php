<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Service\CartService;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
     */
    // #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs): Response
    {

        $cartWithData = $cs->getCartWithData();
        // dd($cartWithData);
        $total = $cs->getTotal();
        
        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }
    
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    // #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add($id, CartService $cs)
    {
        
        $cs->add($id);

        return $this->redirectToRoute('app_cart');

    }

    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    // #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove($id, CartService $cs)
    {

        $cs->remove($id);

        return $this->redirectToRoute('app_cart');

    }

    /**
     * @Route("/cart/minus/{id}", name="cart_remove_one")
     */
    // #[Route('/cart/minus/{id}', name: 'cart_remove_one')] // ° Fusionner avec remove
    public function removeOne($id, CartService $cs)
    {

        $cs->removeOne($id);

        return $this->redirectToRoute('app_cart');

    }

    /**
     * @Route("/commande/{id}", name="commande")
     */
    // #[Route('/commande/{id}', name: 'commande')] 
    public function commande($id, CommandeRepository $repo, RequestStack $rs, Request $globals, EntityManagerInterface $manager, CartService $cs)
    {
    
        $cart = $cs->getCartWithData();
        
        $commande = new Commande;
        $commande->setDateEnregistrement(new \DateTime);
        $commande->setMembre($this->getUser());
        $commande->setProduit($cart[0]['produit']);
        $commande->setEtat('En cours de traitement');
        
        $quantite = $cart[0]['quantite'];
        $montant = $cs->getTotal();
        $commande->setQuantite($quantite);
        $commande->setMontant($montant);
        
        $manager->persist($commande);
        $manager->flush();

        $cs->remove($id);

        $this->addFlash('success', "La commande a bien été enregistré !");
    
        return $this->redirectToRoute('produits');
        
            

    }















}
