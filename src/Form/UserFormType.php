<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required'=> false,
                'label' => false,
                'attr'=> [
                    'autocomplete' => 'nope'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'required'=> false,
                'label' =>false,
                'multiple'=> true,
                'expanded' => true,
                'choices' => [
                    'Admin'=>'ROLE_ADMIN',
                    'FFCB'=> 'ROLE_FFCB',
                    'Comptable'=> 'ROLE_COMPTABLE',
                ]
            ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'label' => false,
                'attr'=> [
                    'autocomplete' => 'new-password'
                ]
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => false
            ])
//            ->add('contact')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
