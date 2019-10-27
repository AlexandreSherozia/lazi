jQuery(document).ready(function() {

    // var $ifCheckedOrNot = false;
    var checkbox = $('#entreprise_souhaiteAdherer:checkbox:checked').length > 0;

        if (checkbox) {
            // $('#raison_adhesion-title').html('Souhaite adhérer et verse mes cotisations pour l\'année courrante, selon les modalités ci-après');

            $('#adhesion').show('', function() {

                $('#raison_non_adhesion').hide('');
            });

        } else {
            // $('#raison_adhesion-title').html('Ne souhaite pas adhérer à la FFCB pour la raison suivante :');

            $('#raison_non_adhesion').show('', function () {

                $('#adhesion').hide('');
            });

        }


    $('#entreprise_souhaiteAdherer').change(function() {

        if ($('#entreprise_souhaiteAdherer').prop('checked')) {

            // $('#raison_adhesion-title').html('Souhaite adhérer et verse mes cotisations pour l\'année courrante, selon les modalités ci-après');

            $('#adhesion').show('', function() {

                $('#raison_non_adhesion').hide('');
            });

            $('#entrepriseForm').on("submit", function () {

                $('#raison_non_adhesion').remove();

            });

        } else {

            /* Si on ne souhaite pas adhérer, on '.remove' du DOM les infos inutiles rempli par erreur */

            // $('#raison_adhesion-title').html('Ne souhaite pas adhérer à la FFCB pour la raison suivante :');

            $('#raison_non_adhesion').show('', function () {

                $('#adhesion').hide('');
            });

            $('#entrepriseForm').on("submit", function () {

                $('#adhesion').remove();

            });
        }
    })

});