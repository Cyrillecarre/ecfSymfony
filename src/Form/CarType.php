<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imagePath', FileType::class, [
                'label' => 'Photo principale',
                'mapped' => false,
            ])
            ->add('name')
            ->add('date')
            ->add('energie')
            ->add('power')
            ->add('gate')
            ->add('price')
            ->add('otherPhotos', FileType::class, [
                'label' => 'Autres photos',
                'multiple' => true,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
