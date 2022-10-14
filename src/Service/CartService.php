<?php


namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService {

    private $repo;
    private $rs;

    public function __construct(ProduitRepository $repo, RequestStack $rs)
    {
        $this->repo = $repo;
        $this->rs = $rs;
    }

    public function add($id)
    {
        $session = $this->rs->getSession(); /// Nous allons récupérer ou créer une session grâce à la classe RequestStack
        $cart = $session->get('cart', []); /// Je récupère l'attr de session 'cart' s'il existe sinon un tableau vide
                
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1; /// Dans un tableau $cart, à la case $id, j'insère la valeur 1
        }
        
        $session->set('cart', $cart); /// Je savegarde l'état de mon panier en session à l'atr de session de 'cart'
    }

    public function remove($id)
    {
        $session = $this->rs->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart); /// Je savegarde l'état de mon panier en session à l'atr de session de 'cart'
    }

    public function removeOne($id)
    {
        $session = $this->rs->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            if ($cart[$id] !== 0) {
                $cart[$id]--;
            }
            unset($cart[$id]);
        }

        $session->set('cart', $cart); /// Je savegarde l'état de mon panier en session à l'atr de session de 'cart'
    }

    public function getCartWithData()
    {
        $session = $this->rs->getSession();
        $cart = $session->get('cart', []);
        $qt = 0;

        /// Nous allons créer un nvo tableau qui contiendra des objets Produit et les quantités de chaque objet 
        $cartWithData = [];

        foreach ($cart as $id => $quantite) {
            $cartWithData[] = [
                'produit' => $this->repo->find($id),
                'quantite' => $quantite
            ];
            $qt += $quantite; 
        }

        $session->set('qt', $qt);

        return $cartWithData;
    }

    public function getTotal()
    {
        $cartWithData = $this->getCartWithData();
        $total = 0;

        // dd($cartWithData);
        
        foreach ($cartWithData as $item) {
            $totalUnitaire = $item['produit']->getPrix() * $item['quantite'];
            $total += $totalUnitaire;
        }
    
        return $total;
    }

}



