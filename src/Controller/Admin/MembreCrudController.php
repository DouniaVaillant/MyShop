<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MembreCrudController extends AbstractCrudController
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        // Je crée un constructeur pour appeler le service UserPasswordHasherInterface
        $this->hasher = $hasher;
    }
    
    public static function getEntityFqcn(): string
    {
        return Membre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('pseudo'),
            TextField::new('email'),
            TextField::new('password', 'Mot de passe')->setFormType(PasswordType::class)->onlyWhenCreating(),
            ChoiceField::new('civilite')->setChoices([
                'Homme' => 'h',
                'Femme' => 'f',
                'Enfant' => 'e'
            ]), // ° Faire un choice
            CollectionField::new('roles')->setTemplatePath('admin/field/roles.html.twig'),
            DateTimeField::new('date_enregistrement')->setFormat('d/M/Y à H:m:s')->hideOnForm()
        ];                              
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // $entityInstance correspond à l'objet User ($user)
        if (!$entityInstance->getId()) {
            $entityInstance->setPassword(
                $this->hasher->hashPassword(
                    $entityInstance, $entityInstance->getPassword()
                )
            );
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
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
