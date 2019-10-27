<?php

namespace App\Form;

use App\Model\Search\SearchCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCriteriaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $entityFormType = $options['entityFormType'];
        $builder
            ->add('entity', ChoiceType::class, [
                'label' => 'Critère Entité',
                'placeholder' => false,
                'required' => false,
                'choices' => [
                    'Entreprise' => 'entreprise',
                    'Etablissement' => 'etablissements',
                    'Contact' => 'contact',
                    'Syndicat' => 'syndicat',
                    'Cotisation' => 'cotisation'
                ]
            ])
        ;

        $builder
            ->add('field', ChoiceType::class, [
                'choices' => $this->getCorrespondingNameChoices('entreprise'),
                'label' => false,
                'placeholder' => false,
                'required' => false,
            ]);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var SearchCriteria $data */
                $data = $event->getData();
                if (!$data) {
                    return;
                }
                $this->setupCorrespondingEntityFields($event->getForm(), $data->getEntity());
            }
        );

        $builder->get('entity')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->setupCorrespondingEntityFields($form->getParent(), $form->getData());
            }
        );

        $builder
            ->add('term', TextType::class, [
                'label' => 'Valeur',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchCriteria::class,
            'entityFormType'=> null
        ]);
    }

    private function getCorrespondingNameChoices(string $entityName)
    {
        $entrepriseFields = [
            'Raison Sociale'        => 'raisonSocial',
            'Nom groupement'        => 'groupeEntreprise',
            'Type adhérent'         => 'isTransporter',
            'Département'           => 'departement',
            'Code Postal'           => 'codePostal',
            'Ville'                 => 'ville',
//            'Région'              => 'regions',
            'Rattachement Syndicat' => 'syndicat',
            'Code Siren'            => 'codeSiren',
            'Code APE'              => 'codeApe',
            'Numéro Matricule'      => 'Raison',
            'ID Compta'             => 'identifientCompta',
            'Numéro TVA Intracom'   => 'numTvaIntracom',
            'Numéro EDE(Négoce)'    => 'numEdeNegoce',
            'Numéro EDE(Centre)'    => 'numEdeCentre',
            'Numéro EDE(Elevage)'   => 'numEdeElevage',
            'Secteur Activité'      => 'activity',
            'Souhaite adhérer'      => 'souhaiteAdherer',
            'Raison non adhésion'   => 'raisonNonAdhesion',
            'Souhaite figurer annuaire adhérent'        => 'figurerAnnuaireAdherents',
            'Souhaite figurer annuaire Internet'        => 'figurerAnnuaireInternet',
        ];

        $etablissementFields = [
            'Nom Etablissement' => 'nom',
            'Département'       => 'departement',
            'Code Siret'        => 'codeSiret',
            'Ville'             => 'ville',
        ];

        $contactFields = [
//            'Type de contact'   => 'typeContact',
            'Nom'               => 'nom',
            'Prénom'            => 'prenom',
            'Email'             => 'emailContact',
//            'Rôle/Fonction dans l\'entreprise' => 'role',
        ];

        $syndicatFields = [
            'Nom syndicat'          => 'nom',
            'Type Syndicat'         => 'type',
            'Département syndicat'  => 'departement',
            'Région syndicat'       => 'region',
        ];

        $cotisationFields = [
            'Année Cotisation' => 'anneeCotisation',
            'Statut Cotisation' => 'cotisationStatut',
            'Montant'           => 'montantCotisation'
        ];

        $entityNameChoices = [
            'entreprise' => $entrepriseFields,
            'etablissements' => $etablissementFields,
            'contact' => $contactFields,
            'syndicat' => $syndicatFields,
            'cotisation' => $cotisationFields
        ];

        return $entityNameChoices[$entityName];
    }

    /**
     * @param FormInterface $form
     * @param string $entityName
     */
    private function setupCorrespondingEntityFields(FormInterface $form, ?string $entityName): void
    {
        if (null === $entityName) {
            $form->remove('field');
            return;
        }
        $choices = $this->getCorrespondingNameChoices($entityName);

        if (null === $choices) {
            $form->remove('field');
            return;
        }

        $form->add('field', ChoiceType::class, [
            'choices' => $choices,
            'label' => false,
            'placeholder' => false,
            'required' => false,
        ]);
    }
}
