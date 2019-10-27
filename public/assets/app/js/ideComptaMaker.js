jQuery(document).ready(function() {
    var dep = '??';
    var raisonSociale = '????';

    var ideCompta = $("#entreprise_identifientCompta").val();
    if (ideCompta) {
        return ideCompta;
    } else {
        ideCompta.val('2'+'-'+dep+'-'+raisonSociale);
    }

    $("#entreprise_raisonSocial").on('keyup', function () {

        raisonSociale=$("#entreprise_raisonSocial").val();

        $("#entreprise_identifientCompta").val('2'+'-'+dep.slice(0,2)+'-'+raisonSociale.slice(0,4).toUpperCase());

    });
    $('.departement').change(function() {

        dep = $(this).find(':selected').text();

        $("#entreprise_identifientCompta").val('2'+'-'+dep.slice(0,2)+'-'+raisonSociale.slice(0,4).toUpperCase());
    })





});