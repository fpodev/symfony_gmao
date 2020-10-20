<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) :void
    {
        $builder                       
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'required' => true,
                'attr' => [
                    'class' => 'form-controle'
                ]                 
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'S\'il vous plait, entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 10,
                            'max' => 500,
                        ]),
                        new Regex([
                            'pattern' => "#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#",
                            'match' => false,
                            'message' => 'Veuillez entrer un mot de passe valide'
                        ])
                        ],
                'label' => 'Nouveau mot de passe',
                'required' => true,
                'attr' => [
                    'class' => 'form-controle'
                ]
                ],
                'second_options' => [
                    'label' => 'Confimer nouveau mot de passe',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-controle',
                    ]
                    ], 
                'invalid_message' => "Les mots de passes ne corespondent pas" ,
                'mapped' => false,              
            ])                                     
            ->add('valider', SubmitType::class);
            
    }

    public function configureOptions(OptionsResolver $resolver) :void
    {
        $resolver->setDefaults([]);
    }
}
