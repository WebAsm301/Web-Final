<?php

namespace App\Form;

use App\Entity\Suppliers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class SuppliersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SupplierName')
            ->add('Birthday', DateType::class, [
                'years' => range(2023, 1990)
            ])
            ->add('Suppliernation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Suppliers::class,
        ]);
    }
}