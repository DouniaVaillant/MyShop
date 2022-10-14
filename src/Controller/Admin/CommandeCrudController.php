<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('membre')->renderAsNativeWidget(),
            AssociationField::new('produit')->renderAsNativeWidget(),
            IntegerField::new('quantite'),
            // IntegerField::new('montant'),
            MoneyField::new('montant')->setCurrency('EUR'),
            ChoiceField::new('etat')->setChoices([
                'En cours de traîtement' => 'En cours de traitement',
                'Envoyé' => 'Envoyé',
                'Livré' => 'Livré'
            ]),
            DateTimeField::new('date_enregistrement')->setFormat('d/M/Y à H:m:s')->hideOnForm()
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        // createEntity est exécuté lorsque je clique sur add user
        // Elle permet d'exécuter du code avant d'afficher la page de creation
        // ici je vais définir une date de creation
        $user = new $entityFqcn; /// ici équivaut à $artile = new user;
        $user->setDateEnregistrement(new \DateTime);
        return $user;
    }
   
}


/* 
membre_id	
quantite	
montant	
etat	
date_enregistrement	
produit_id

*/