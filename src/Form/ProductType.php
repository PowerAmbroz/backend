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
        $today = new \DateTime();
        $t = $today->format('Y-m-d');

        $builder
            ->add('name', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('info', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
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
                'label' => false
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
