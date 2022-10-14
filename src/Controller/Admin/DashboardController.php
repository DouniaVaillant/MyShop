<?php

namespace App\Controller\Admin;


use App\Entity\Membre;
use App\Entity\Produit;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<b>MYSHOP</b>');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Accueil', 'fa fa-home'),
            MenuItem::section('Membres'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', Membre::class),
            MenuItem::section('Commerce'),
            MenuItem::linkToRoute('Site', 'fa fa-home', 'accueil'),
            MenuItem::linkToCrud('T-shirts', 'fa fa-store', Produit::class),
            MenuItem::linkToCrud('Commandes', 'fas fa-cash-register', Commande::class),

        ];
    }
}
