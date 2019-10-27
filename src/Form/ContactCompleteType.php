<?php

namespace App\Form;

use App\Entity\Bureau;
use App\Entity\Contact;
use App\Entity\Repere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactCompleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civilite', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => false,
                'choices' => [
                    'F' => 'Mme.',
                    'M' => 'Mr.',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('nom', TextType::class, [
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'required' => false,
            ])
            ->add('telPortable', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Au format international: "00336..."',
                    'class' => 'form-control phone-number m-input'
                ]
            ])
            ->add('telPortable2', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Au format international: "00336..."',
                    'class' => 'form-control phone-number m-input'
                ]
            ])
            ->add('telBureau', TextType::class, [
                'required' => false,
            ])
            ->add('emailContact', TextType::class, [
                'required' => false,
            ])
            ->add('dateNaissance', TextType::class, [
                'required' => false,
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
            ])
            ->add('adresse', TextType::class, [
                'required' => false,
            ])
            ->add('adresse2', TextType::class, [
                'required' => false,
            ])
            ->add('ville', TextType::class, [
                'required' => false,
            ])
            ->add('codePostal', TextType::class, [
                'required' => false,
            ])
            ->add('syndicatContacts', CollectionType::class, [
                'required' => false,
                'entry_type' => SyndicatContactType::class,
                'allow_add' => true,
                'allow_delete' => false, // This must be on False
                'by_reference' => false
            ])
            ->add('commissionsContacts', CollectionType::class, [
                'required' => false,
                'entry_type' => CommissionContactType::class,
                'allow_add' => true,
                'allow_delete' => false,// This must be on False
                'by_reference' => false
            ])
            ->add('contactConseilAdministrations', CollectionType::class, [
                'required' => false,
                'entry_type' => ContactConseilAdministrationType::class,
                'allow_add' => true,
//                'allow_delete' => true,
                'by_reference' => false
            ])
            ->add('reperesExistants', EntityType::class, [
                'required' => false,
                'class' => Repere::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'by_reference' => false
            ])
            ->add('repere', CollectionType::class, [
                'required' => false,
                'entry_type' => RepereType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
