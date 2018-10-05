<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Venue;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('time', TimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker']
            ])
            ->add('price', MoneyType::class)
            ->add('description')
            ->add('bands', EntityType::class, [
                'multiple' => true,
                'class' => Band::class,
                'label' => 'add subscribed bands',
                'attr' => array(
                    'class' => 'js-example-basic-multiple fullwidth'
                ),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->where('b.active = true');
                },
            ])
            ->add('unsubscribedBands', CollectionType::class, array(
                'label' => false,
                'entry_type' => UnsubscribedBandType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('typeVenue', ChoiceType::class, [
                'attr' => [
                    'class' => 'js-venuetype js-example-basic-single'
                ],
                'choices' => [
                    'subscribed' => 1,
                    'unsubscribed' => 2,
                ]
            ])
            ->add('venue', EntityType::class, [
                'attr' => [
                    'class' => 'js-venue js-example-basic-single'
                ],
                'multiple' => false,
                'class' => Venue::class,
                'label' => 'set subscribed venue',
                'placeholder' => '--choose or fill the next form--',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                        ->where('v.active = true');
                },
            ])
            ->add('unsubscribedVenue', UnsubscribedVenueType::class, [
                'required' => false
            ])
            ->add('styles')
            ->add('flyer', ImageType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,


        ]);
    }
}
