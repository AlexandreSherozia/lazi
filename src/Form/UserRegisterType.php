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
	        ->add('password', PasswordType::class, [
	        	'required' => false,
		        'attr' => [
			        'class' => 'form-control m-input'
		        ]
	        ])
	        /*->add('password_2', PasswordType::class, [
		        'required' => false,
		        'constraints' => new NotBlank(),
		        'label' => 'repeat password',
		        'mapped' => false,
		        'attr' => [
			        'class' => 'form-control m-input'
		        ]
	        ])*/
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
