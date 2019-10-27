<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Messenger;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class MessengerType extends AbstractType
{
    private $connected_user;

    /**
     * MessengerType constructor.
     */
    public function __construct(Security $security)
    {
        $this->connected_user = $security->getUser();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $stringifiedEmails = $options['stringifiedEmails'];

        $builder
            ->add('senderEmail', TextType::class, [
                'required' => false,
                'data' => $this->connected_user->getEmail(),
                'empty_data' => $this->connected_user->getEmail(),
            ])
            ->add('recipientEmail', TextType::class, [
                'required' => false,
                'data' => $stringifiedEmails,
            ])
            ->add('ccRecipientEmail', TextType::class, [
                'required' => false,
                'label' => false,
                'data' => $this->connected_user->getEmail(),
            ])
            ->add('messageHeader', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=> 'ex: Mon titre',
                ]
            ])
            ->add('messageBody', TextareaType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('senderName')
            ->add('senderFrom')
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

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Messenger::class,
            'stringifiedEmails' => null
        ]);
    }
}
