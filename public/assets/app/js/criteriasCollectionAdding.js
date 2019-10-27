let $collectionHolder;
let repository;
let fieldsToSelect;
let termsToSelect;
let $entitySelect;
let $correspondingFieldTarget;
var yesOrNo;
let form;

// setup an "add a tag" link
let $addTagButton = $('<button type="button" class="btn btn-primary flaticon-add-circular-button" style="margin: 20px;padding: 5px;"> Ajouter des critères</button>');
let $newLinkLi = $('<li></li>').append($addTagButton);

jQuery(document).ready(function() {

    let index = sessionStorage.getItem('index');
    if (index) {
        let existingTerm = $('#advanced_search_searchCriteria_'+index+'_term');
        let value = existingTerm.val();
        if ('1' === value) {
            yesOrNo = 'Transporteur';
        }
        if ('0'===value) {
            yesOrNo = 'Négoce';
        }
        existingTerm.val(yesOrNo);
    }

    // console.log(index);

    form =  $('form#advancedSearchForm');

    repository = $('#repository').text();
    if ('ENTREPRISE'===repository) {
        fieldsToSelect={
            "entreprise":
                {'Raison Sociale' : 'raisonSocial','Nom groupement' : 'groupeEntreprise',
                    'Type adhérent' : 'isTransporter', 'Département Nom' : 'departement','Département Id':'numDepart',
                    'Code Postal' : 'codePostal', 'Ville' : 'ville',
                    'Rattachement Syndicat' : 'syndicat', 'Code Siren' : 'codeSiren',
                    'Code APE' : 'codeApe','Ancien Identifiant' : 'ancienIdentifiant', 'Identifiant Comptabilité' : 'identifientCompta',
                    'Num TVA Intracom' : 'numTvaIntracom', 'Num EDE(Négoce)' : 'numEdeNegoce',
                    'Num EDE(Centre)' : 'numEdeCentre', 'Num EDE(Elevage)' : 'numEdeElevage',
                    'Secteur Activité' : 'activity', 'Souhaite adhérer' : 'souhaiteAdherer',
                    'Raison non adhésion' : 'raisonNonAdhesion', 'Souhaite figurer annuaire adhérent' : 'figurerAnnuaireAdherents',
                    'Souhaite figurer annuaire Internet' : 'figurerAnnuaireInternet'},
            "contact":
                { "Nom":"nom","Prénom":"prenom","Email":"emailContact"},
            "etablissements":
                {'Nom Etablissement': 'nom','Département': 'departement','Code Siret': 'codeSiret','ville': 'ville'},
            "syndicat":
                {'Nom Syndicat' : 'nom','Type Syndicat' : 'type', 'Département syndicat' : 'departement'},
            "cotisation":
                { 'Année Cotisation': 'anneeCotisation','Statut Cotisation' : 'cotisationStatut', 'Montant' : 'montantCotisation'},
        };
    }
    else if ('CONTACT'===repository) {
        fieldsToSelect={
            "contact":
                { "Nom":"nom","Prénom":"prenom","Email":"emailContact",
                    "Portable": "telPortable",
                    "Nom du rôle dans Entreprise": "roleEntreprise",
                    "Nom du rôle dans Syndicat(actif)": "syndicatContacts",
                    "Nom du rôle dans Commission(actif)": "commissionsContacts",
                    "Nom du rôle dans Conseil Administration(actif)": "contactConseilAdministrations",
                },
            "entreprise":
                {'Raison Sociale' : 'raisonSocial','Nom groupement' : 'groupeEntreprise','Type adhérent' : 'isTransporter',
                    'Département Nom' : 'departement','Département Id':'numDepart','Code Postal' : 'codePostal', 'Ville' : 'ville',
                    'Rattachement Syndicat' : 'syndicat','Secteur Activité' : 'activity', 'Souhaite adhérer' : 'souhaiteAdherer',
                    'Raison non adhésion' : 'raisonNonAdhesion', 'Souhaite figurer annuaire adhérent' : 'figurerAnnuaireAdherents',
                    'Souhaite figurer annuaire Internet' : 'figurerAnnuaireInternet'},
            "etablissements":
                { "Nom Etablissement": "nom",'Département nom' : 'departement', 'Département Id':'numDepart', 'Code Siret' : 'codeSiret','ville' : 'ville'},
            "cotisation":
                { 'Année Cotisation': 'anneeCotisation','Statut Cotisation' : 'cotisationStatut', 'Montant' : 'montantCotisation'},
            "syndicat":
                { "Nom Syndicat": "nom"},
            "repere":
                { "Nom Repère": "nom"},
        };

    }
    else if ('SYNDICAT'===repository) {
        fieldsToSelect={
            "syndicat":
                {'Nom Syndicat':'nom', 'Type de Syndicat':'type','Département nom':'departement','Département Id':'numDepart','Région nom':'region'},

            "entreprise":
                {'Raison Sociale' : 'raisonSocial','Syndicat de Rattachement' : 'syndicat'},
        };
    }
    else if ('COTISATION'===repository) {
        fieldsToSelect={
            "cotisation":
                { 'Année Cotisation': 'anneeCotisation','Statut Cotisation' : 'cotisationStatut', 'Montant' : 'montantCotisation'},
            "contact":
                { "Nom":"nom","Prénom":"prenom","Email":"emailContact"},
            "entreprise":
                {'Identifiant Comptabilité' : 'identifientCompta','Raison Sociale' : 'raisonSocial','Département' : 'departement','Département Id':'numDepart',
                    'Code Siren' : 'codeSiren','Code APE' : 'codeApe','Numéro TVA Intracom' : 'numTvaIntracom',
                    'Numéro EDE(Négoce)' : 'numEdeNegoce','Numéro EDE(Centre)' : 'numEdeCentre',
                    'Numéro EDE(Elevage)' : 'numEdeElevage','Secteur Activité' : 'activity'},
            "etablissements":
                { "Nom Etablissement": "nom",'Code Siret' : 'codeSiret'},

            "syndicat":
                { "Nom Syndicat": "nom"},
            "repere":
                { "Nom Repère": "nom"},
        };
    }
//__________________________________________________________________________________________//
    termsToSelect = {
        "isTransporter":
            {'Négoce': '0','Transporteur':'1'},
        "souhaiteAdherer":
            {'Oui': '1', 'Non':'0'},
        "figurerAnnuaireAdherents":
            {'Oui':'1','Non':'0'},
        "figurerAnnuaireInternet":
            {'Oui':'1','Non':'0'},
        "cotisationStatut":
            {'Payé':'payé','Non Payé':'non payé','Paiement Partiel':'paiement partiel'},
        "typeSyndicat":
            {'Départemental':'depart','Régional':'region'},
        "roleEntreprise":
            {'Responsable': 'isResponsible', 'Privilégié': 'isPrivileged'}
    };
//__________________________________________________________________________________________//
        /*var termsData = [];
        $("input[name*='term']").each(function(){
            termsData.push($(this).val());
        });

        var pos = [];
        var i;

        for (i = 0; i<termsData.length; i++)  {

            if (termsData[i] === '0') {
                pos.push(i);
            }
        }*/

    $collectionHolder = $('ul.advancedSearch');

    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
    var indexes = [];

    // "+AJOUTER DES CRITERES" BUTTON
    function addTagForm($collectionHolder, $newLinkLi) {
        // alert($collectionHolder);
        let prototype = $collectionHolder.data('prototype');
        // get the new index
        let index = $collectionHolder.data('index');

        let newForm = prototype;
        newForm = newForm.replace(/__name__/g, index);
        $collectionHolder.data('index', index + 1);

        // console.log(index);
        let $newFormLi = $('<li style="margin: 30px 0 10px"></li>').append(newForm);
        $newLinkLi.before($newFormLi);

        // add a delete link to the new form
        addTagFormDeleteLink($newFormLi);

        //NEW Details added
        $entitySelect = $('#advanced_search_searchCriteria_'+index+'_entity');
        $entitySelect.addClass('js-field-form-select form-control');

        $correspondingFieldTarget = $('#advanced_search_searchCriteria_'+index+'_field');

        $entitySelect.on('change', function() {
            $correspondingFieldTarget.empty();
            let entityName = $(this).val();
            let selectedFields = fieldsToSelect[entityName] || [];
            let html = $.map(selectedFields, function(value, index){
                    return '<option value="' + value + '">' + index + '</option>';
                }).join('');
            $correspondingFieldTarget.html(html);

            /*$.ajax({
                url: $entitySelect.data('corresponding-field-url'),
                data: {
                    entity: $entitySelect.val()
                },
                success: function (html) {
                    /!*if (!html) {
                        $correspondingFieldTarget.find('select').remove();
                        $correspondingFieldTarget.addClass('d-none');
                        return;
                    }*!/
                    // Replace the current field and show
                    $correspondingFieldTarget.html(html).removeClass('d-none');
                    // console.log(html);
                }
            });*/
        });
        termFieldsModulator();

        function termFieldsModulator() {
            $correspondingFieldTarget.on('change', function() {
                let $termField = $('#advanced_search_searchCriteria_'+index+'_term');
                $termField.empty();
                let termFields;
                let fieldName = $(this).val();
                let nameAttrForTerm="advanced_search[searchCriteria]["+index+"][term]";
                let idAttrForTerm = "advanced_search_searchCriteria_"+index+"_term";
                let fieldsToAvoid = ['isTransporter','souhaiteAdherer','figurerAnnuaireAdherents','figurerAnnuaireInternet','cotisationStatut'];

                switch (fieldName) {
                    case 'isTransporter':
                        termFields = termsToSelect['isTransporter'] || [];
                        // indexes.push(index);
                        sessionStorage.setItem('index', fieldName);

                        switchInputToSelect($termField,termFields,idAttrForTerm,nameAttrForTerm);
                        break;
                    case 'souhaiteAdherer':
                        termFields = termsToSelect['souhaiteAdherer'] || [];

                        switchInputToSelect($termField,termFields,idAttrForTerm,nameAttrForTerm);
                        break;

                    case 'figurerAnnuaireAdherents':
                        termFields = termsToSelect['figurerAnnuaireAdherents'] || [];

                        switchInputToSelect($termField,termFields,idAttrForTerm,nameAttrForTerm);
                        break;

                    case 'figurerAnnuaireInternet':
                        termFields = termsToSelect['figurerAnnuaireInternet'] || [];

                        switchInputToSelect($termField,termFields,idAttrForTerm,nameAttrForTerm);
                        break;

                    case 'cotisationStatut':
                        termFields = termsToSelect['cotisationStatut'] || [];

                        switchInputToSelect($termField,termFields,idAttrForTerm,nameAttrForTerm);
                        break;

                    case 'type':
                        termFields = termsToSelect['typeSyndicat'] || [];

                        switchInputToSelect($termField,termFields,idAttrForTerm,nameAttrForTerm);
                        break;

                    case 'roleEntreprise':
                        termFields = termsToSelect['roleEntreprise'] || [];

                        switchInputToSelect($termField,termFields,idAttrForTerm,nameAttrForTerm);
                        break;
                }

                if(jQuery.inArray(fieldName, fieldsToAvoid) === -1) {
                // if (fieldName in termsToSelect) {
                    $termField.replaceWith(
                        '<input class="form-control" type="text" id="' + idAttrForTerm + '" name="' + nameAttrForTerm + '">'
                    );
                }
                termFieldsModulator(); //Recursive function
            });


        }


    }



    function switchInputToSelect($termField,termFields,idAttrForTerm,nameAttrForTerm){
        $termField.replaceWith(
            '<select class="form-control modulator" id="' +  idAttrForTerm + '" name="'+ nameAttrForTerm +'">' +
            $.map(termFields, function(value, index){
                return '<option value="' + value + '">' + index + '</option>'
            }).join('')+
            '</select>'
        );
    }

    function addTagFormDeleteLink($tagFormLi) {
        let $removeFormButton = $('<button type="button" class="btn btn-danger" style="padding: 5px;margin-left: 5px;">X</button>');
        $tagFormLi.append($removeFormButton);

        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            $tagFormLi.remove();
        });
    }


});