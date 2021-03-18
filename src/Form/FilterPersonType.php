<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterPersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        Formularz filtrowania dla Person
        $builder
            ->add('search', TextType::class,[
                'attr' => [
                    'class' => 'form-control mr-sm-2',
                    'placeholder' => 'Search'
                ],
                'label' => false,
                'required' => false

            ])
            ->add('stateActive', CheckboxType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'label_attr' => [
                  'class' => 'form-check-label'
                ],
                'label' => 'Stan Aktywny '
            ])
            ->add('stateBanned', CheckboxType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'label_attr' => [
                  'class' => 'form-check-label'
                ],
                'label' => 'Stan Banned '
            ])
            ->add('stateDeleted', CheckboxType::class,[
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'label_attr' => [
                  'class' => 'form-check-label'
                ],
                'label' => 'Stan Usunięty '
            ])
            ->add('submit', SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-outline-success my-2 my-sm-0'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
