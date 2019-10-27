<?php

namespace App\Form;

use App\Entity\SmsSender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SmsSenderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $stringifiedNumbers = $options['stringifiedNumbers'];

        $builder
            ->add('senderFrom', TextType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('recipientTo', TextType::class, [
                'required' => false,
                'label' => false,
                'data' => $stringifiedNumbers
            ])
            ->add('message', TextareaType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('isDraft', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-size' => 'small',
                    'data-width' => '154',
                    'data-on' => 'Enregistrer modèle',
                    'data-off' => 'Enregistrer modèle',
                    'data-onstyle' => 'primary',
                    'data-offstyle' => 'text-secondary',
//                    'checked' => 'checked'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SmsSender::class,
            'stringifiedNumbers' => null
        ]);
    }
}
