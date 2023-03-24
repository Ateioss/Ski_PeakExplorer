<?php

namespace App\Form;

use App\Entity\Piste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('difficulte')
            ->add('ouverture')
            ->add('horaire_ouverture')
            ->add('horaire_fermeture')
            ->add('station')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piste::class,
        ]);
    }
}
