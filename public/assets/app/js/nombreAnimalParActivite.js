jQuery(document).ready(function() {

    var veaux = $('#entreprise_activity_2');
    var nombreVeaux = $('#entreprise_nombreVeaux');
    var maigres = $('#entreprise_activity_3');
    var nombreMaigres = $('#entreprise_nombreMaigres');
    var elevReprod = $('#entreprise_activity_4');
    var nombreElevReprod = $('#entreprise_nombreElevProd');
    var boucherie = $('#entreprise_activity_5');
    var nombreBoucherie = $('#entreprise_nombreBoucherie');
    var ovins = $('#entreprise_activity_6');
    var nombreOvins = $('#entreprise_nombreOvins');
    var porcins = $('#entreprise_activity_7');
    var nombrePorcins = $('#entreprise_nombrePorcins');
    var equins = $('#entreprise_activity_8');
    var nombreEquins = $('#entreprise_nombreEquins');
    var caprins = $('#entreprise_activity_9');
    var nombreCaprins = $('#entreprise_nombreCaprins');

    /* ON LOAD */
    if (veaux.prop('checked')) {
        nombreVeaux.css('display', 'inline-block');
    } else {
        nombreVeaux.css('display','none');
            nombreVeaux.val('');
    }
    if (maigres.prop('checked')) {
        nombreMaigres.css('display', 'inline-block');
    } else {
        nombreMaigres.css('display','none');
            nombreMaigres.val('');
    }
    if (elevReprod.prop('checked')) {
        nombreElevReprod.css('display', 'inline-block');
    } else {
        nombreElevReprod.css('display','none');
            nombreElevReprod.val('');
    }
    if (boucherie.prop('checked')) {
        nombreBoucherie.css('display', 'inline-block');
    } else {
        nombreBoucherie.css('display','none');
            nombreBoucherie.val('');
    }
    if (ovins.prop('checked')) {
        nombreOvins.css('display', 'inline-block');
    } else {
        nombreOvins.css('display','none');
            nombreOvins.val('');
    }
    if (porcins.prop('checked')) {
        nombrePorcins.css('display', 'inline-block');
    } else {
        nombrePorcins.css('display','none');
            nombrePorcins.val('');
    }
    if (equins.prop('checked')) {
        nombreEquins.css('display', 'inline-block');
    } else {
        nombreEquins.css('display','none');
            nombreEquins.val('');
    }
    if (caprins.prop('checked')) {
        nombreCaprins.css('display', 'inline-block');
    } else {
        nombreCaprins.css('display','none');
            nombreCaprins.val('');
    }

/* ON CHANGE */

    veaux.change(function() {
        if ($(this).prop('checked')) {
            nombreVeaux.show();
        } else {
            nombreVeaux.hide();
                nombreVeaux.val('');
        }
    });

    maigres.change(function() {
        if ($(this).prop('checked')) {
            nombreMaigres.show();
        } else {
            nombreMaigres.hide();
                nombreMaigres.val('');
        }
    });
    elevReprod.change(function() {
        if ($(this).prop('checked')) {
            nombreElevReprod.show();
        } else {
            nombreElevReprod.hide();
                nombreElevReprod.val('');
        }
    });
    boucherie.change(function() {
        if ($(this).prop('checked')) {
            nombreBoucherie.show();
        } else {
            nombreBoucherie.hide();
                nombreBoucherie.val('');
        }
    });
    ovins.change(function() {
        if ($(this).prop('checked')) {
            nombreOvins.show();
        } else {
            nombreOvins.hide();
                nombreOvins.val('');
        }
    });
    porcins.change(function() {
        if ($(this).prop('checked')) {
            nombrePorcins.show();
        } else {
            nombrePorcins.hide();
                nombrePorcins.val('');
        }
    });
    equins.change(function() {
        if ($(this).prop('checked')) {
            nombreEquins.show();
        } else {
            nombreEquins.hide();
                nombreEquins.val('');
        }
    });
    caprins.change(function() {
        if ($(this).prop('checked')) {
            nombreCaprins.show();
        } else {
            nombreCaprins.hide();
                nombreCaprins.val('');
        }
    });



});