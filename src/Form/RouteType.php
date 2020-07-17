<?php

namespace App\Form;

use App\Entity\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
            	'required' => false,
	            'attr' => [
		            'class' => 'form-control select2'
	            ]
            ])
//            ->add('routeName')
//            ->add('route')
//            ->add('routeRequirements')
            ->add('bootstrapIcon', TextType::class, [
		        'required' => false,
		        'attr' => [
			        'class' => 'form-control select2'
		        ]
	        ])
//            ->add('isAdminMenu')
            ->add('parent', EntityType::class, [
		        'required' => false,
            	'placeholder' => 'Principale',
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
            'data_class' => Route::class,
        ]);
    }
}
