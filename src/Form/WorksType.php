<?php

namespace App\Form;

use App\Entity\Works;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {       
        $builder
            ->add('title')
            ->add('description', CKEditorType::class)
            ->add('create_date')
            ->add('validate_date', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'calendar'
                ]
            ])
            ->add('estimate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'calendar'
                ]
            ])
            ->add('invoice', Filetype::class)
            ->add('start_datetime')
           ->add('finish_datetime')
            ->add('ville')
            ->add('building')
            ->add('sector')
            ->add('equipement')
            ->add('user_request', TextType::class, [
                'disabled' => true,
                'mapped' => false, 
                           
            ])
         
            ->add('user_technicien')
            ->add('compagny_service')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Works::class,
        ]);
    }
}
