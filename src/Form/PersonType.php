<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('f_name', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('l_name', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('state', ChoiceType::class,[
                'choices' => [
                    'aktywny' => 1,
                    'banned' => 2,
                    'usuniety' => 3
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'expanded' => true
            ])
            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'form-control btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
