<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Route;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
            	'required' => false,
	            'attr' => [
		            'class' => 'form-control m-input'
	            ]
            ])
            ->add('content', TextareaType::class, [
            	'required' => false,
	            'attr' => [
	            	'class' => 'summernote'
	            ]
            ])
	        ->add('route', EntityType::class, [
	        	'class' => Route::class,
		        'choice_label' => 'name',
		        'attr' => [
		        	'class' => 'form-control select2'
		        ]
	        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
