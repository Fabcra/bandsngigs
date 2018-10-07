<?php

namespace App\Form;

use App\Entity\Band;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminBandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('mail')
            ->add('phone')
            ->add('website')
            ->add('description')
            ->add('videoPlaylist')
            ->add('audioPlaylist')
            ->add('active')
            ->add('members')
            ->add('locality')
            ->add('styles')

            ->add('active', ChoiceType::class, [
                'choices'=>[
                    'Non'=>true,
                    'Oui'=>false
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
