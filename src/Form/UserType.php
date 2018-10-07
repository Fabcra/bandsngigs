<?php

namespace App\Form;

use App\Entity\Instrument;
use App\Entity\Locality;
use App\Entity\Style;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('age', IntegerType::class)
            ->add('gender', ChoiceType::class, [
                'choices'=>[
                    'Homme'=>'male',
                    'Femme'=>'female'
                ],
                'multiple'=>false,
            ])
         //   ->add('email', EmailType::class)
            ->add('phone')
            ->add('description', TextareaType::class)
            ->add('instruments', EntityType::class, array(
                'multiple'=>true,
                'class'=>Instrument::class,
            ))
            ->add('styles', EntityType::class, array(
                'multiple'=>true,
                'class'=>Style::class,
            ))
            ->add('locality', EntityType::class, array(
                'multiple'=>false,
                'class'=>Locality::class,
            ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
