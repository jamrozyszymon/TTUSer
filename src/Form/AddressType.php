<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\GeoType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street', TextType::class, ['label' => 'Ulica'])
            ->add('suite', TextType::class, ['label' => 'Numer'])
            ->add('city', TextType::class, ['label' => 'Miejscowość'])
            ->add('zipcode', TextType::class, ['label' => 'Kod pocztowy'])
        ;

        $builder->add('geos', GeoType::class, ['label'=>'Współrzędne']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
