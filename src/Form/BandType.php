<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\UnscribedMember;
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
            ->add('logo', ImageType::class)
            ->add('users', EntityType::class, [
                'multiple' => true,
                'class' => User::class,
                'label' => 'add subscribed members'
            ])
            ->add('unscribedMembers', CollectionType::class, array(
                'entry_type' => UnscribedMemberType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true
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
