<?php

namespace App\Form;

use App\Entity\Geo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GeoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lat', TextType::class, ['label' => 'Szarokość geograficzna'])
            ->add('lng', TextType::class, ['label' => 'Długość geograficzna'])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Geo::class,
        ]);
    }
}
