<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,  
                'attr' => [
                    'class' => 'form-control'  
                ]           
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,  
                'attr' => [
                    'class' => 'form-control'  
                ]           
            ])
            ->add('email', EmailType::class, [
                'required' => true,  
                'attr' => [
                    'class' => 'form-control'  
                ]           
            ])
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                ])        
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles'
                
            ]);            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
