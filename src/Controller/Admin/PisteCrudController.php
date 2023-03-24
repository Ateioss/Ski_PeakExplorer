<?php

namespace App\Controller\Admin;

use App\Entity\Piste;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
class PisteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Piste::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->setRequired(true),
            ChoiceField::new('difficulte')->setChoices([
                'Facile' => 'Facile',
                'Moyen' => 'Moyen',
                'Difficile' => 'Difficile'
            ])->setRequired(true),
            ChoiceField::new('ouverture')
                ->setLabel('Ouverture')
                ->setChoices([
                    'Fermée' => 0,
                    'Ouverte' => 1,
                ]),
            TextareaField::new('fermeture_expectionelle')->setLabel('Message de fermeture exceptionnelle')->hideOnIndex(),
            TimeField::new('horaire_ouverture')->setRequired(true),
            TimeField::new('horaire_fermeture')->setRequired(true),
        ];
    }
}
