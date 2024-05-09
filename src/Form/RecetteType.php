<?php

namespace App\Form;

use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder

            ->add('serves')
            ->add('description')
            ->add('date')
            ->add('rating')
            ->add('imagerec')
    
            ->add('nomrec', TextType::class ,  ['required' => false, 'label' =>'Name of recipe', 'attr' => array('style' => 'width: 300px')])                                      
            ->add('categoryr', ChoiceType::class ,  [
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
            ->add('difficulty', ChoiceType::class ,  [
                'required' => false,
                'label' => 'Difficulty',
                'attr' => [
                    'style' => 'width: 300px'
                ],
                'choices'  => [
                    "Easy"=>"Easy",
                    "Average"=>"Average",
                    "Difficult"=>"Difficult",
                ],
            ])
            
            ->add('prepHour', ChoiceType::class, [
                'required' => false,
                'label' => 'Preparation Hour',
                'attr' => [
                    'style' => 'width: 300px'
                ],
                'choices' => ["00H"=>"00H"
                ,"01H"=>"01H"
                , "02H"=>"02H"
                , "03H"=>"03H"
                , "+3H"=>"+3H"
            ],
            ])
            ->add('prepMin', ChoiceType::class, [
                'required' => false,
                'label' => 'Preparation Minute',
                'attr' => [
                    'style' => 'width: 300px'
                ],
                'choices' => [
                    "00min"=>"00min"
                    ,"05min"=>"05min"
                    , "10min"=>"10min"
                    , "15min"=>"15min"
                    , "20min"=>"20min"
                    ,"25min"=>"25min"
                    , "30min"=>"30min"
                    , "35min"=>"35min"
                    , "40min"=>"40min"
                    ,"45min"=>"45min"
                    , "50min"=>"50min"
                    , "55min"=>"55min"
                    ,]
                ,
            ])
            ->add('prep', HiddenType::class, [
                'mapped' => false, // This field won't be mapped to any entity property
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
