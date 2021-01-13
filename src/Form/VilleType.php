<?php

namespace App\Form;

use App\Entity\Ville;
use App\Entity\Building;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class VilleType extends AbstractType
{      
    public function buildForm(FormBuilderInterface $builder, array $options)
    {      
        $builder            
            ->add('name')
            ->add('adress')
            ->add('zip_code')
            ->add('contact') 
            ->add('building', TextType::class, [
                'mapped' => false
            ])                                 
        ;       
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,           
        ]);
    }
}
