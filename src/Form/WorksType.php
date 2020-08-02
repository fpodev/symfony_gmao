<?php

namespace App\Form;

use App\Entity\Works;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('task')
            ->add('create_date')
            ->add('validate_date')
            ->add('estimate')
            ->add('invoice')
            ->add('start_datetime')
            ->add('finish_datetime')
            ->add('city')
            ->add('building')
            ->add('sector')
            ->add('epuipement')
            ->add('user_applicant')
            ->add('technician')
            ->add('external_responce')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Works::class,
        ]);
    }
}
