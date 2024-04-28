<?php

namespace App\Form;

use App\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('goal')
            ->add('titre')
            ->add('associationname')
            ->add('campaigntype', ChoiceType::class, [
                'choices' => [
                    'Food' => 'Food',
                    'Money' => 'Money',
                ],
                'multiple' => false, // Allow selecting only one role
                'expanded' => false, // Display as dropdown list
            ]) 
            ->add('description')
            ->add('current')
            ->add('image', FileType::class, [    
                // unmapped means that this field is not associated to any entity property
                'mapped' => true,
    
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                
    
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        
                       
                    ])
                    
                ],
            ])
            ->add('Submit', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campaign::class,
        ]);
    }
}
