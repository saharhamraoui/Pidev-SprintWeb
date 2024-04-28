<?php

namespace App\Form;

use App\Entity\Donation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Campaign;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class DonationType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valeurdon')
            ->add('idcamp', EntityType::class, [
                'class' => Campaign::class,
                'choice_label' => 'titre' // Replace 'titre' with the actual property representing the campaign's title
            ])
            ->add('iddonator', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname' // Replace 'firstname' with the actual property representing the user's first name
            ]);
    
        // Add an event listener to set the history field and update campaign's current value before submitting the form
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
    
            // Fetch the Campaign entity from the database based on the submitted idcamp
            $campaignId = $data['idcamp'];
            $campaign = $this->entityManager->getRepository(Campaign::class)->find($campaignId);
    
            // Set the history field to the current date and time
            $donation = new Donation(); // Create a new Donation object
            $donation->setValeurdon($data['valeurdon']); // Set the valeurdon property
            $donation->setHistory(new \DateTime());
    
            // Update the current value of the campaign
            $currentValue = $campaign->getCurrent() + $donation->getValeurdon();
            $campaign->setCurrent($currentValue);
        }); 
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donation::class,
        ]);
    }
}
