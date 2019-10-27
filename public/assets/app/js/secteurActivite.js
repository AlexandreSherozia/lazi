jQuery(document).ready(function() {

    /* L'affichage des toggles dépendent des id depuis BDD. I.e Les fixtures peuvent modifier les ids */

    $('#entreprise_secteurActivite_1').attr({'data-toggle': 'toggle', 'data-on': 'Bovins', 'data-off': 'Bovins'});
    $('#entreprise_secteurActivite_2').attr({'data-toggle': 'toggle', 'data-on': 'Veaux', 'data-off': 'Veaux', 'data-size': 'small'}).bootstrapToggle('disable');
    $('#entreprise_secteurActivite_3').attr({'data-toggle': 'toggle', 'data-on': 'Maigres', 'data-off': 'Maigres', 'data-size': 'small'}).bootstrapToggle('disable');
    $('#entreprise_secteurActivite_4').attr({'data-toggle': 'toggle', 'data-on': 'Elev./Reprod', 'data-off': 'Elev./Reprod', 'data-size': 'small'}).bootstrapToggle('disable');
    $('#entreprise_secteurActivite_5').attr({'data-toggle': 'toggle', 'data-on': 'Boucherie', 'data-off': 'Boucherie', 'data-size': 'small'}).bootstrapToggle('disable');
    $('#entreprise_secteurActivite_6').attr({'data-toggle': 'toggle', 'data-on': 'Ovins', 'data-off': 'Ovins'});
    $('#entreprise_secteurActivite_7').attr({'data-toggle': 'toggle', 'data-on': 'Porcins', 'data-off': 'Porcins'});
    $('#entreprise_secteurActivite_8').attr({'data-toggle': 'toggle', 'data-on': 'Equins', 'data-off': 'Equins'});
    $('#entreprise_secteurActivite_9').attr({'data-toggle': 'toggle', 'data-on': 'Caprins', 'data-off': 'Caprins'});
    // $('#entreprise_secteurActivite_10').closest('div').attr({'class':'transporteur'});//ne marche pas
    $('#entreprise_secteurActivite_10').attr({'data-toggle': 'toggle', 'data-on': 'Volailles', 'data-off': 'Volailles'});

    $('#entreprise_secteurActivite_1').change(function() {

        if ($(this).prop('checked')) {

            //$('#raison_adhesion-title').html('Souhaite adhérer et verse mes cotisations annuelles 2018, selon les modalités ci-après');
            /*$('#entreprise_secteurActivite_2').bootstrapToggle('enable');
            $('#entreprise_secteurActivite_3').bootstrapToggle('enable');
            $('#entreprise_secteurActivite_4').bootstrapToggle('enable');
            $('#entreprise_secteurActivite_5').bootstrapToggle('enable');*/

            $('#entreprise_secteurActivite_2').prop('enable');
            $('#entreprise_secteurActivite_3').prop('enable');
            $('#entreprise_secteurActivite_4').prop('enable');
            $('#entreprise_secteurActivite_5').prop('enable');


        } else {
            // $('#raison_adhesion-title').html('Ne souhaite pas adhérer à la FFCB pour la raison suivante :');

            $('#entreprise_secteurActivite_2').bootstrapToggle('off').bootstrapToggle('disable');
            $('#entreprise_secteurActivite_3').bootstrapToggle('off').bootstrapToggle('disable');
            $('#entreprise_secteurActivite_4').bootstrapToggle('off').bootstrapToggle('disable');
            $('#entreprise_secteurActivite_5').bootstrapToggle('off').bootstrapToggle('disable');

        }
    })



});