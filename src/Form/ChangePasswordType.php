<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'pass',
                'required' => true,
                'attr' => [
                    'class' => 'form-controle'
                ]                 
            ])
            ->add('new_password', PasswordType::class, [
                'label' => 'newPass',
                'required' => true,
                'attr' => [
                    'class' => 'form-controle'
                ]
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => 'Confimer nouveau mot de passe',
                'required' => true,
                'attr' => [
                    'class' => 'form-controle'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
