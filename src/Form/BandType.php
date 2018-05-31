<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('mail')
            ->add('phone')
            ->add('website')
            ->add('description')
            ->add('locality')
            ->add('styles')
            ->add('logo', ImageType::class, array(
                'label'=>false
            ))
            ->add('users', EntityType::class, [
                'multiple' => true,
                'class' => User::class,
                'label' => 'Subscribed members'
            ])
            ->add('unscribedMembers', CollectionType::class, array(
                'label'=>'Unscribed Members',
                'entry_type' => UnscribedMemberType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Band::class,

        ]);
    }
}
