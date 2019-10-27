jQuery(document).ready(function() {

    $( "#entreprise_raisonNonAdhesion" )
        .change(function() {
            var str = "";
            $( "select option:selected" ).each(function() {
                str = $( this ).text();
            });
            if ("Changement de secteur d'activité" === str || "Raison de non adhésion" === str ) {
                $( "#radionButtonInput" ).hide();
                $( "#radionButtonTextarea" ).hide();
            } else if ("Cessation d'activité depuis" === str ) {
                $( "#radionButtonTextarea" ).hide();
                $( "#radionButtonInput" ).show();
            } else if ("Indiquez une autre raison" === str ) {
                $( "#radionButtonInput" ).hide();
                $( "#radionButtonTextarea" ).show();
            }
        })
        .trigger( "change" );


});