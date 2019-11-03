<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
            	'required' => false,
	            'attr' => [
	            	'class' => 'form-control m-input'
	            ]
            ])
            ->add('firstName', TextType::class, [
            	'required' => false,
	            'attr' => [
	            	'class' => 'form-control m-input'
	            ]
            ])
	        ->add('password', RepeatedType::class, [
	        	'type' => PasswordType::class,
		        'label' => false,
		        'invalid_message' => 'Les deux champs de mot de passe ne se correspondent pas !',
		        'required' => true,
		        'first_options'  => ['label' => 'Password'],
		        'second_options' => ['label' => 'Repeat Password'],
	        ])
            ->add('lastName', TextType::class,[
            	'required' => false,
	            'attr' => [
		            'class' => 'form-control m-input'
	            ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
