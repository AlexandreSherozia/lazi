<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
                'label' => false,
                'attr' => [
                    'class' => 'form-control m_input',
                    'placeholder' => 'Nom',
                ]
            ])
            ->add('prenom',TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control m_input',
                    'placeholder' => 'Prénom',
                ]
            ])
            ->add('telPortable', TelType::class, [
                'required' => false,
                'label' => false,
                'data' => '0033',
                'attr' => [
                    'class' => 'form-control m_input phone-number',
                    'placeholder' => 'Portable'
                ]
            ])
            ->add('telPortable2', TelType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control m_input phone-number',
                    'placeholder' => 'Portable'
                ]
            ])
            ->add('emailContact', EmailType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control m_input',
                    'placeholder' => 'Email'
                ]
            ])
            ->add('dateNaissance', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control m-input m_datepicker_1',
                    'placeholder' => 'Naissance'
                ]
            ])
            ->add('isPrivileged', CheckboxType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('adresse', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('adresse2', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('ville', TextType::class, [
                'required' => false,
                'label' => false
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
