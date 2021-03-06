<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//      Formylarz Dodawania produktów
//      przygotowanie formatu daty do wykorzystania w przycisku Date

        $today = new \DateTime();
        $t = $today->format('Y-m-d');

//        Tworzenie pól do formularza
        $builder
            ->add('name', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Name'
                ],
                'label' => false
            ])
            ->add('info', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Info'
                ],
                'label' => false
            ])
            ->add('public_date', DateType::class,[
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'value' => $t,
                    'data-toggle' => "tooltip",
                    'data-placement' => "top",
                    'title' => "Data rozpoczęcia wydarzenia"
                ],
                'label' => 'Data Publikacji'
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
            'data_class' => Product::class,
        ]);
    }
}
