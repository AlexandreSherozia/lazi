var isTransporter = $('#entreprise_isTransporter');
var volaille = $('#volailles');

jQuery(document).ready(function() {

    // All transporter type components are hidden while loading "entrepriseFrom"

    if (isTransporter.prop('checked')) {

        volaille.css('display', 'inline-block');
        $('.transporteur').show('');
        $('.negoce').hide('');
    } else {
        $('.transporteur').css('display','none');
    }

    $(isTransporter.change(function() {

        if ($(this).prop('checked')) {

            $('#secteur_activite_titre').html("Type d'espèces transportées :");
            $('.transporteur').show('', function () {

            $('#volailles').show('').css('display', 'inline-block');

                $('.negoce').hide('');

            });

            /*$('#entrepriseForm').on("submit", function () {

                // $('.negoce').remove();
                $('#entreprise_secteurActivite_4').closest('div').remove();
            });*/

        } else {

            /* Si on est commerçant, on '.remove' du DOM les infos inutiles rempli par erreur */

            $('#secteur_activite_titre').html("Secteur d'activité :");

            $('#volailles').hide('');

            $('.negoce').show('', function() {

                $('.transporteur').hide('');
            });

            $('#entrepriseForm').on("submit", function () {

                $('.transporteur').remove();
                volaille.closest('div').remove();

            });
        }
    })
    )
});