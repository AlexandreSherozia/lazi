$(document).ready(function() {
    var $entitySelect = $('.js-field-form-select');
    var $correspondingFieldTarget = $('.js-field-name-target');
    $correspondingFieldTarget.removeClass('d-none');

    $entitySelect.on('change', function(e) {
        $.ajax({
            url: $entitySelect.data('corresponding-field-url'),
            data: {
                entity: $entitySelect.val()
            },
            success: function (html) {

                if (!html) {
                    $correspondingFieldTarget.find('select').remove();
                    $correspondingFieldTarget.addClass('d-none');
                    return;
                }
                // Replace the current field and show
                $correspondingFieldTarget.html(html).removeClass('d-none');
                // $correspondingFieldTarget.addClass('select-width');
                // $correspondingFieldTarget.find("select").select2();
                $correspondingFieldTarget.find("select").addClass('form-control').css('width','300px');
            }
        });
    });
});