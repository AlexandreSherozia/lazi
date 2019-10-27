let class_name;
let mailHeader;
let content;
let switch_button = $("#sms_sender_form_isDraft");
let count_models = $("#count_models");

jQuery(document).ready(function () {

    switch_button.change(function (event) {
        event.preventDefault();

        if (switch_button.prop('checked')) {

            let content = $("#sms_sender_form_message").val();

            $.ajax({
                method: 'POST',
                url: window.globalVars.appUrl + '/sms/record-model/' + content,

            }).done(function (object) {

                count_models.text(object.countModels).css('border', '1px solid green');
            });
        }
    });

    $("#m_modal_4").click(function () {
        loadModel();
        deleteModel();
    });

    function loadModel() {
        //gets the button which class contains the string "loaded_model_"
        $("button[class*='loaded_model_']").on('click', function () {

            class_name = this.className;//and retrieves his hole className

            content = $("article." + class_name).text(); //retrieves the saved model of the same class

            let textarea = $("#sms_sender_form_message");
            textarea.css('text-align', 'left');
            textarea.val(content);

        });
    }

    function deleteModel() {

        $(".selection-btn a").on('click', function () {

            let id = this.className;//retrieves retrieves his hole className

            $.ajax({
                method: 'POST',
                url: window.globalVars.appUrl + '/delete-model/' + id,

            }).done(function (object) {
                // On success, we decrement the counter, and hide the appropriate row(tr)
                count_models.text(object.countModels).css('border', '1px solid green');
                let id = object.modelClass;
                $("tr." + id).hide('fast');
            });


        });


    }

});




