jQuery(document).ready(function() {

    $('.ffcb-delete-button').on('click', function () {
        var entrepriseId = $(this).data("entreprise");
        var id = $(this).data("id");
        var nom = $(this).data("nom");


        $('.ffcb-modal-delete .modal-body p').text(entrepriseId+ ' ,'+ id +' ,'+ nom).attr('class', 'font-weight-bold text-center');

        $('.ffcb-modal-delete .modal-footer a').attr('href','/supprimer-etablissement/' + entrepriseId + '/'+ id);


        $('.ffcb-modal-delete').show('fast');
    });
    $('.close').on('click', function () {
        $('.ffcb-modal-delete').hide('fast');
    });
});