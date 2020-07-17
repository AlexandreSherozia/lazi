<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//    	dd($options['data']->getAvatar(), $builder);
        $builder
	        ->add('avatar', FileType::class, [
	        	'required' => false,
//		        'empty_data' => $options['data']->getAvatar(),
		        'data_class' => null,
	        ])
            ->add('email', EmailType::class, [
                'required'=> false,
                'label' => false,
            ])
	        ->add('mobile', TelType::class, [
		        'required'=> false,
		        'label' => false,
	        ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('password', PasswordType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => false
            ])
	        ->add('contact', ContactFormType::class, [
		        'required' => false,
		        'label' => false
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
