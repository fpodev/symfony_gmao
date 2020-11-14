<?php

namespace App\Form;

use App\Entity\Building;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $uri = $_SERVER['REQUEST_URI'];
      
        if(stristr($uri, 'addBuilding') != FALSE){
            $builder
            ->add('name')           
        ; 
        }
        else{
            $builder
            ->add('name')
            ->add('ville')
        ;
        }
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Building::class,            
        ]);
    }
}
