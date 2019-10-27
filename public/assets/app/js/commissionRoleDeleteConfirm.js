jQuery(document).ready(function() {

    $('.ffcb-commission-role-delete-button').on('click', function () {
        var commissionRoleId = $(this).data("id");
        var commissionRoleNom = $(this).data("nom");


        $('.ffcb-commission-role-modal-delete .modal-body p').text('Vous supprimez "'+ commissionRoleNom + '" !').attr('class', 'font-weight-bold text-center');

        // "window.globalVars.appUrl" for different environments
        $('.ffcb-commission-role-modal-delete .modal-footer a').attr('href', window.globalVars.appUrl + '/commissions-role/suppression/' + commissionRoleId);



        $('.ffcb-commission-role-modal-delete').show('fast');
    });
    $('.close').on('click', function () {
        $('.ffcb-commission-role-modal-delete').hide('fast');
    });
});