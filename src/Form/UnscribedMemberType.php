<?php

namespace App\Form;

use App\Entity\UnscribedMember;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnscribedMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickName', null, array(
                'label'=>'Nickname'
            ))
            ->add('instruments', null, array(
                'label'=>'Instrument(s)',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UnscribedMember::class
        ]);
    }
}
