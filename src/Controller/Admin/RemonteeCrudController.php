<?php

namespace App\Controller\Admin;

use App\Entity\Remontee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use phpDocumentor\Reflection\Types\Boolean;

class RemonteeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Remontee::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            BooleanField::new('open'),
            
            TimeField::new('open_time'),
            TimeField::new('close_time'),
            AssociationField::new('station'),
        ];
    }

}
