<?php

namespace App\Form;

use App\Entity\Sector;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Sector1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $uri = $_SERVER['REQUEST_URI'];

        if(stristr($uri, 'addSector') != FALSE){
            $builder
                ->add('name')                
            ;
        }
        else{
            $builder
                ->add('name')
                ->add('Building', TextType::class,[
                    'disabled' => true,
                ])
                ->add('equipement', TextType::class,[
                    'mapped' => false,
                ])
           ; 
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sector::class,
        ]);
    }
}
