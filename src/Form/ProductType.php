<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('code', TextType::class, [
                'required'    => true,
                'constraints' => [
                    new length([
                        'min' => 4,
                        'max' => 10,
                        'minMessage' => "El código debe tener minimo 4 caracteres",
                        'maxMessage' => "El código debe tener maximo 10 caracteres"
                    ])
                ]
            ])
            ->add('nombre', TextType::class, [
                'required'    => true,
                'constraints' => [
                    new length([
                        'min' => 4,
                        'minMessage' => "El nombre debe tener minimo 4 caracteres"
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'required'    => true,
                'constraints' => [
                    new length([
                        'min' => 4,
                        'minMessage' => "La descrpción debe tener minimo 4 caracteres"
                    ])
                ]
            ])           
            ->add('brand', TextType::class, [
                'required'    => true,
                'constraints' => [
                    new length([
                        'min' => 2,
                        'minMessage' => "La marca debe tener minimo 2 caracteres"
                    ])
                ]
            ])
            ->add('price', NumberType::class, [
                'required'    => true,
                'constraints' => [
                    new length([
                        'min' => 2,
                        'minMessage' => "La marca debe tener minimo 2 caracteres"
                    ])
                ]
            ])           
            ->add('category', EntityType::class, [                
                'class'        => Category::class,
                'choice_label' => 'name',
            ])        
            ->add('Aceptar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
