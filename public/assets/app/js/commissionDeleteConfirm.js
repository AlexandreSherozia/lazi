jQuery(document).ready(function() {

    $('.ffcb-delete-button').on('click', function () {
        var id = $(this).data("id");
        var nom = $(this).data("nom");


        $('.ffcb-modal-delete .modal-body p').text('Vous supprimez "'+ nom + '" !').attr('class', 'font-weight-bold text-center');

        // "window.globalVars.appUrl" for different environments
        $('.ffcb-modal-delete .modal-footer a').attr('href', window.globalVars.appUrl + '/commissions/suppression/' + id);



        $('.ffcb-modal-delete').show('fast');
    });
    $('.close').on('click', function () {
        $('.ffcb-modal-delete').hide('fast');
    });
});