$(document).ready(function() {

    /*toggle contactResponsible from dbb*/
    $("#switchContactButton").on('click', function () {

        $("#contactResponsable").toggleClass('switch-display-off');
        $("#contactResponsableList").toggleClass('switch-display-on');

        if ( '> Choisir depuis la BDD >' === $("#switchContactButton").text()) {

            $("#switchContactButton").text('< Créer un Responsable <');
            // $("#contactResponsable").remove();

        } else {
            $("#switchContactButton").text('> Choisir depuis la BDD >');
            // $("#contactResponsableList").remove();
        }
    });



    /*fill fields regarding selected email*/
    $("#entreprise_contactResponsableList").change(function(){
        $.ajax({
            method: 'POST',
            url: window.globalVars.appUrl + '/contact/responsible/ajax/'+ $('#entreprise_contactResponsableList option:selected').text(),

            data:  'emailContact=' + $('#entreprise_contactResponsableList option:selected').text(),
        }).done(function (contactResponse) {
            $("#responsableFromListPrenom").text(contactResponse.prenom);
            $("#responsableFromListNom").text(contactResponse.nom);
            $("#responsableFromListEmail").text(contactResponse.email);
            $("#responsableFromListTel").text(contactResponse.portable);
            $("#responsableFromListDate").text(contactResponse.dateNaissance);

        });
    });
});