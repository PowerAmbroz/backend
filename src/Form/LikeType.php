<?php

namespace App\Form;

use App\Entity\Like;
use App\Entity\Person;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LikeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('person_id', EntityType::class,[
                'class' => Person::class,
                'choice_label' => function(Person $person){
                return $person->getFName() .' '. $person->getLName();
                },
                'attr' => [
                    'class' => 'form-control'
                ]
                ])
            ->add('product_id', EntityType::class,[
                'class' => Product::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ]
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
            'data_class' => Like::class,
        ]);
    }
}
