<?php

namespace App\Form;

use App\Entity\SmsApiParams;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SmsApiParamFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('applicationKey', TextType::class, [
                'required' => false,
                'help' => 'Ce champ est uniquement informatif'
            ])
            ->add('consumerKey', TextType::class, [
                'required' => false,
                'help' => 'Respectez la casse (minuscules/MAJUSCULES)'
            ])
            ->add('applicationSecret', TextType::class, [
                'required' => false,
                'help' => 'Respectez la casse (minuscules/MAJUSCULES)'
            ])
            ->add('endPoint', TextType::class, [
                'required' => false,
                'help' => 'Respectez la casse (minuscules/MAJUSCULES)'
            ])
            ->add('providerName', null, [
                'required' => false,
                'help' => 'Respectez la casse (minuscules/MAJUSCULES)'
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SmsApiParams::class,
        ]);
    }
}
