jQuery(document).ready(function() {

$('.ffcb-delete-button').on('click', function () {
    var id = $(this).data("id");
    var entrepriseId = $(this).data("entrepiseId");
    var nom = $(this).data("nom");


    $('.ffcb-modal-delete .modal-body p').text('Vous supprimez "'+ nom + '" !').attr('class', 'font-weight-bold text-center');
    $('.ffcb-modal-delete .modal-footer a').attr('href', window.globalVars.appUrl + '/groupe/suppression/' + id);



    $('.ffcb-modal-delete').show('fast');
    });
    $('.close').on('click', function () {
    $('.ffcb-modal-delete').hide('fast');
    });
});