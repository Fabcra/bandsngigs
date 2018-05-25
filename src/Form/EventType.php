<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Venue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date', DateType::class, [
                'widget'=>'single_text',
                'attr'=>['class'=>'js-datepicker']
            ])
            ->add('time')
            ->add('price')
            ->add('description')
            ->add('bands', EntityType::class,[
                'multiple'=>true,
                'class'=>Band::class,
                'label'=>'add subscribed bands'
            ])
            ->add('unsubscribedBands', CollectionType::class, array(
                'label'=>false,
                'entry_type'=>UnsubscribedBandType::class,
                'entry_options'=>array('label'=>false),
                'allow_add'=>true,
                'allow_delete'=>true,
                'by_reference'=>false
            ))
            ->add('venue', EntityType::class,[
                'multiple'=>false,
                'class'=>Venue::class,
                'label'=>'set subscribed venue',
                'placeholder'=>'--choose or let blank--',
                'required'=>false
            ])
            ->add('unsubscribedVenue', UnsubscribedVenueType::class)
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
