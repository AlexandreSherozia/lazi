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

class SearchCriteriumType extends AbstractType
{
    private $entityFormType;
    private $entrepriseFields;
    private $etablissementFields;
    private $contactFields;
    private $syndicatFields;
    private $cotisationFields;
    private $repereFields;
    private $typeAdherentTerms;
    private $booleanTerms;
    private $fieldNameChoices;
    private $typeSyndicatTerms;
    private $entities;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->entityFormType = $options['entityFormType'];

        switch ($this->entityFormType) {
            case 'entreprise':
                $this->entities = [
                    'Entreprise' => 'entreprise',
                    'Etablissement' => 'etablissements',
                    'Contact' => 'contact',
                    'Syndicat' => 'syndicat',
                    'Cotisation' => 'cotisation'
                ];
                break;
            case 'contact':
                $this->entities = [
                    'Contact' => 'contact',
                    'Entreprise' => 'entreprise',
                    'Etablissement' => 'etablissements',
                    'Syndicat' => 'syndicat',
                    'Cotisation' => 'cotisation',
                    'Repère' => 'repere'
                ];
                break;
            case 'syndicat':
                $this->entities = [
                    'Syndicat' => 'syndicat',
                    'Entreprise' => 'entreprise',
                ];
                break;
            case 'cotisation':
                $this->entities = [
                    'Cotisation' => 'cotisation',
                    'Entreprise' => 'entreprise',
                    'Etablissement' => 'etablissements',
                    'Syndicat' => 'syndicat',
                ];
                break;
        }
        $builder
            ->add('entity', ChoiceType::class, [
                'label' => 'Critère Entité',
                'placeholder' => false,
                'required' => false,
                'choices' => $this->entities
            ]);

        $builder
            ->add('field', ChoiceType::class, [
                'choices' => $this->getCorrespondingNameChoices($this->entityFormType),//Charge les fields correspondants
                'label' => false,
                'placeholder' => false,
                'required' => false,
            ]);

        // This is useful for Ajax calls
        /*$builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {

                $data = $event->getData();
                if (!$data) {
                    return;
                }
                $this->setupCorrespondingEntityFields($event->getForm(), $data->getEntity());
            }
        );*/

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

    //State of all fields on load
    private function getCorrespondingNameChoices(string $entityName)
    {
        switch ($this->entityFormType) {
            case 'entreprise':
                $this->entrepriseFields = [
                    'Raison Sociale' => 'raisonSocial',
                    'Nom groupement' => 'groupeEntreprise',
                    'Type adhérent' => 'isTransporter',
                    'Département Nom' => 'departement',
                    'Département Id' => 'numDepart',
                    'Code Postal' => 'codePostal',
                    'Ville' => 'ville',
                    'Rattachement Syndicat' => 'syndicat',
                    'Code Siren' => 'codeSiren',
                    'Code APE' => 'codeApe',
                    'Ancien Identifiant' => 'ancienIdentifiant',
                    'ID Compta' => 'identifientCompta',
                    'Numéro TVA Intracom' => 'numTvaIntracom',
                    'Numéro EDE(Négoce)' => 'numEdeNegoce',
                    'Numéro EDE(Centre)' => 'numEdeCentre',
                    'Numéro EDE(Elevage)' => 'numEdeElevage',
                    'Secteur Activité' => 'activity',
                    'Souhaite adhérer' => 'souhaiteAdherer',
                    'Raison non adhésion' => 'raisonNonAdhesion',
                    'Souhaite figurer annuaire adhérent' => 'figurerAnnuaireAdherents',
                    'Souhaite figurer annuaire Internet' => 'figurerAnnuaireInternet',
                ];
                $this->syndicatFields = [
                    'Nom Syndicat' => 'nom',
                    'Type Syndicat' => 'type',
                    'Département syndicat' => 'departement',
                ];
                $this->etablissementFields = [
                    'Nom Etablissement' => 'nom',
                    'Département' => 'departement',
                    'Code Siret' => 'codeSiret',
                    'ville' => 'ville',
                ];
                $this->cotisationFields = [
                    'Année Cotisation' => 'anneeCotisation',
                    'Statut Cotisation' => 'cotisationStatut',
                    'Montant' => 'montantCotisation'
                ];
                break;
            case 'contact':
                $this->entrepriseFields = [
                    'Raison Sociale' => 'raisonSocial',
                    'Nom groupement' => 'groupeEntreprise',
                    'Type Adhérent' => 'isTransporter',
                    'Département Nom' => 'departement',
                    'Département Id' => 'numDepart',
                    'Code Postal' => 'codePostal',
                    'Ville' => 'ville',
                    'Rattachement Syndicat' => 'syndicat',
                    'Secteur Activité' => 'activity',
                    'Souhaite adhérer' => 'souhaiteAdherer',
                    'Raison non adhésion' => 'raisonNonAdhesion',
                    'Souhaite figurer annuaire adhérent' => 'figurerAnnuaireAdherents',
                    'Souhaite figurer annuaire Internet' => 'figurerAnnuaireInternet',
                ];
                $this->syndicatFields = [
                    'Nom Syndicat' => 'nom',
                ];
                $this->etablissementFields = [
                    'Nom Etablissement' => 'nom',
                    'Département nom' => 'departement',
                    'Département Id' => 'numDepart',
                    'Code Siret' => 'codeSiret',
                    'ville' => 'ville',
                ];
                $this->cotisationFields = [
                    'Année Cotisation' => 'anneeCotisation',
                    'Statut Cotisation' => 'cotisationStatut',
                    'Montant' => 'montantCotisation'
                ];
                break;

            case 'syndicat':
                $this->entrepriseFields = [
                    'Raison Sociale' => 'raisonSocial',
                    'Syndicat de Rattachement' => 'syndicat',
                ];
                $this->syndicatFields = [
                    'Nom Syndicat' => 'nom',
                    'Type de Syndicat' => 'type',
                    'Département nom' => 'departement',
                    'Département Id' => 'numDepart',
                    'Région nom' => 'region',
                ];
                break;

            case 'cotisation':
                $this->entrepriseFields = [
                    'Identifiant Comptabilité' => 'identifientCompta',
                    'Raison Sociale' => 'raisonSocial',
                    'Département nom' => 'departement',
                    'Département Id' => 'numDepart',
                    'Code Siren' => 'codeSiren',
                    'Code APE' => 'codeApe',
                    'Numéro TVA Intracom' => 'numTvaIntracom',
                    'Numéro EDE(Négoce)' => 'numEdeNegoce',
                    'Numéro EDE(Centre)' => 'numEdeCentre',
                    'Numéro EDE(Elevage)' => 'numEdeElevage',
                    'Secteur Activité' => 'activity',
                ];
                $this->cotisationFields = [
                    'Année Cotisation' => 'anneeCotisation',
                    'Statut Cotisation' => 'cotisationStatut',
                    'Montant' => 'montantCotisation'
                ];
                $this->etablissementFields = [
                    'Nom Etablissement' => 'nom',
                    'Code Siret' => 'codeSiret',
                ];
                break;
        }
        $this->contactFields = [
            'Nom' => 'nom',
            'Prénom' => 'prenom',
            'Email' => 'emailContact',
            'Portable' => 'telPortable',
            'Nom du rôle dans Entreprise' => 'roleEntreprise',
            'Nom du rôle dans Syndicat(actif)' => 'syndicatContacts',
            'Nom du rôle dans Commission(actif)' => 'commissionsContacts',
            'Nom du rôle dans Conseil Administration(actif)' => 'contactConseilAdministrations',
        ];

        $this->repereFields = [
            'Nom Repère' => 'nom',
        ];

        $entityNameChoices = [
            'entreprise' => $this->entrepriseFields,
            'etablissements' => $this->etablissementFields,
            'contact' => $this->contactFields,
            'syndicat' => $this->syndicatFields,
            'cotisation' => $this->cotisationFields,
            'repere' => $this->repereFields,
        ];
        return $entityNameChoices[$entityName];
    }

    /**
     * @param FormInterface $form
     * @param string $entityName
     */
    private function setupCorrespondingEntityFields(FormInterface $form, ?string $entityName): void
    {
        $choices = $this->getCorrespondingNameChoices($entityName);

        $form->add('field', ChoiceType::class, [
            'choices' => $choices,
            'label' => false,
            'placeholder' => false,
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchCriteria::class,
            'entityFormType' => null,
            'fieldNames' => null
        ]);
    }
}
