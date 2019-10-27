let selector_checkbox = $("#selector_checkbox");
var emails= [];
var inputs = $('.selection input:checkbox');

jQuery(document).ready(function() {

    selector_checkbox.change(function () {
        if (selector_checkbox.prop('checked')) {
            inputs.not(this).prop('checked', true);
        }
        else {
            inputs.not(this).prop('checked', false);
        }
    });

    // Allows only one checkbox to be selected("Pour l'envoi d'email" OR "Pour l'envoi de SMS").
    $('input.sendingTypeSelector').on('change', function() {
        $('input.sendingTypeSelector').not(this).prop('checked', false);
    });
});

//This would be for Ajax auto completion for Emailing system
/*$("input[class*='selected_email_']").on('click', function () {

        class_name = this.className;//retrieves clicked class name finished by the proper number

        emails.push($("td."+class_name).text()); //selects the tag <td> which has the retrieved class name
    });

    emailButton.click(function(event){
        event.preventDefault();

        stringifiedEmails = emails.join(' ');

        window.location.href = window.globalVars.appUrl + '/ffcb-emailing/'+ stringifiedEmails;*/


/*$.ajax({
    method: 'POST',
    asinc: false,
    // url: window.globalVars.appUrl + '/ffcb-emailing/'+ stringifiedEmails,

    data:  'recipientEmail=' + stringifiedEmails,
}).done(function (object) {

    //on success redirects to the route "send_email" of MailController
    window.location.href = window.globalVars.appUrl + '/ffcb-emailing/'+ stringifiedEmails;

});*/

/*$.post(stringifiedEmails,function (data, status) {
    window.location.href = window.globalVars.appUrl + '/ffcb-emailing/'+ stringifiedEmails;
    alert(data + status);
});*/
// });
