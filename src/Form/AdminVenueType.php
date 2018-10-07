<?php

namespace App\Form;

use App\Entity\Venue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminVenueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('streetName')
            ->add('houseNb')
            ->add('mail')
            ->add('website')
            ->add('phone')
            ->add('locality')
            ->add('styles')
            ->add('photo', ImageType::class)
            ->add('videoPlaylist', null, [
                'label' => 'Url Youtube Playlist'
            ])
            ->add('managers')
            ->add('active', ChoiceType::class, [
                'choices' => [
                    'Oui' => false,
                    'Non' => true
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Venue::class,
        ]);
    }
}
