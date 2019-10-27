let class_name;
let mailHeader;
let content;
let message_header = $("#messenger_messageHeader");
let record_model = $("#messenger_isDraft");
let count_models = $("#count_models");

jQuery(document).ready(function () {

    record_model.change(function (event) {
        event.preventDefault();

        if (record_model.prop('checked')) {
            var header = $("#messenger_messageHeader").val();
            var content = $(".note-editable").text();

            $.ajax({
                method: 'POST',
                url: window.globalVars.appUrl + '/ffcb/emailing/record-model/' + header + '/' + content,

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

            mailHeader = $("p." + class_name).text();
            content = $("article." + class_name).text(); //retrieves the saved model of the same class

            message_header.val(mailHeader);
            $(".note-editable").text(content);

        });
    }

    function deleteModel() {

        $(".selection-btn a").on('click', function () {

            let id = this.className;//retrieves retrieves his hole className

            $.ajax({
                method: 'POST',
                url: window.globalVars.appUrl + '/delete-sms-model/' + id,

            }).done(function (object) {
                // On success, we decrement the counter, and hide the appropriate row(tr)
                count_models.text(object.countModels).css('border', '1px solid green');
                let id = object.modelClass;
                $("tr." + id).hide('fast');
            });


        });


    }

});




