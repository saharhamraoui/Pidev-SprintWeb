<?php

namespace App\Form;

use App\Entity\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('namep', TextType::class ,  ['required' => false, 'label' =>'Name of Dish', 'attr' => array('style' => 'width: 300px')])                                      
            ->add('categoryp', ChoiceType::class ,  [
                'required' => false,
                'label' => 'Category',
                'attr' => [
                    'style' => 'width: 300px'
                ],
                'choices'  => [
                    "Appetizers"=>"Appetizers",
                    "Main Courses"=>"Main Courses",
                    "Side Dishes"=>"Side Dishes",
                    "Desserts"=>"Desserts",
                    "Beverages"=> "Beverages"
                ],
            ])
            ->add('pricep')
            ->add('ingredientsp')
            ->add('imagep')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
