<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextareaField::new('description')->setMaxLength(20),
            // TextEditorField::new('description')->onlyOnForms(),
            TextField::new('couleur'),
            ChoiceField::new('taille')->setChoices([
                    '8 ans' => 'enfantAge8',
                    '12 ans' => 'enfantAge12',
                    'XS' => 'xs',
                    'S' => 's',
                    'M' => 'm',
                    'L' => 'l',
                    'XL' => 'xl',
                    'XXL' => 'xxl',
                    '3XL' => 'xxxl'
                ]),
            ChoiceField::new('collection')->setChoices([
                    'Homme' => 'h',
                    'Femme' => 'f',
                    'Enfant' => 'e'
                ]), // ° Erreur
            TextField::new('photo'),
            // NumberField::new('prix')->setNumDecimals(2), // ° Virgule
            MoneyField::new('prix')->setCurrency('EUR'),

            IntegerField::new('stock'),
            DateTimeField::new('date_enregistrement')->setFormat('d/M/Y à H:m:s')->hideOnForm()
        ];
    }       
    
    
    public function createEntity(string $entityFqcn)
    {
        // createEntity est exécuté lorsque je clique sur add user
        // Elle permet d'exécuter du code avant d'afficher la page de creation
        // ici je vais définir une date de creation
        $user = new $entityFqcn; /// *ici équivaut à $artile = new user;
        $user->setDateEnregistrement(new \DateTime);
        return $user;
    }

}
