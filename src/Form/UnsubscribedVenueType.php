<?php

namespace App\Form;

use App\Entity\Locality;
use App\Entity\UnsubscribedVenue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnsubscribedVenueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('streetName')
            ->add('houseNb')
            ->add('locality', EntityType::class, array(
                'class'=> Locality::class,
                'placeholder'=>'--set locality--'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UnsubscribedVenue::class,
        ]);
    }
}
