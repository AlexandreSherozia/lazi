jQuery(document).ready(function() {

    if($('#cotisation_edition_cotisationStatut_2').is(':checked') || $('#cotisation_form_cotisationStatut_2').is(':checked')) {
        $(".non_paye").hide();
        /*$("#cotisationForm").on("submit", function () {
            $(".non_paye").remove();
        });*/
    }
    $('input:radio[name="cotisation_edition[cotisationStatut]"]').change(
        function(){
            if (this.checked && this.value === '2') {
                $(".non_paye").hide('');
                $("#cotisationForm").on("submit", function () {
                    $(".non_paye").remove();
                })
            } else {
                $(".non_paye").show('');
            }
        });

    $('input:radio[name="cotisation_form[cotisationStatut]"]').change(
        function(){
            if (this.checked && this.value === '2') {
                $(".non_paye").hide('');
                $("#cotisationForm").on("submit", function () {
                    $(".non_paye").remove();
                })
            } else {
                $(".non_paye").show('');
            }
        });
});