jQuery(document).ready(function() {


    $('#syndicat_type_0').change(function () {
        if ($('#syndicat_type_0').prop('checked')) {

            $('.departemental').show('', function () {

                $('.regional').hide('');

            });

            $('#syndicatForm').on("submit", function () {

                $('.regional').remove();
            });
        }
    });

    $('#syndicat_type_1').change(function () {
        if ($('#syndicat_type_1').prop('checked')) {

            $('.regional').show('', function () {

                $('.departemental').hide('');

            });

            $('#syndicatForm').on("submit", function () {

                $('.departemental').remove();
            });
        }
    });

    if ($('#syndicat_type_0').prop('checked')) {

        // $('#secteur_activite_titre').html("Type d'espèces transportées :");
        $('.departemental').show('', function () {

            $('.regional').hide('');

            // $('#entreprise_secteurActivite_10').closest('div').show('fast');

        });

        $('#syndicatForm').on("submit", function () {

            $('.regional').remove();
        });
    }

    if ($('#syndicat_type_1').prop('checked')) {

        $('.regional').show('', function () {

            $('.departemental').hide('');

            // $('#entreprise_secteurActivite_10').closest('div').show('fast');

        });

        $('#syndicatForm').on("submit", function () {

            $('.departemental').remove();
        });
    }

    // })



});