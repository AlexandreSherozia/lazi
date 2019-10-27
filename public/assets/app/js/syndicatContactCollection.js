var $syndicatContactCollHolder;

// setup an "add a tag" link
var $addSyndicatContactButton = $('<button type="button" class="btn btn-primary flaticon-add-circular-button" style="margin: 20px;padding: 5px;" id="syndicatContactBtn"></button>');
var $newLinkSyndicatContact = $('<li></li>').append($addSyndicatContactButton);


jQuery(document).ready(function() {

    $(".syndicatContact select").datepicker();

    $syndicatContactCollHolder = $('ul.syndicatContact');

    // add a delete link to all of the existing tag form li elements
    // $syndicatContactCollHolder.find('tr').each(function() {
    $syndicatContactCollHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // $syndicatContactCollHolder.children().css('display', 'inline-block');
    // add the "add a tag" anchor and li to the tags ul
    $syndicatContactCollHolder.append($newLinkSyndicatContact);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $syndicatContactCollHolder.data('index', $syndicatContactCollHolder.find(':input').length);

    $addSyndicatContactButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($syndicatContactCollHolder, $newLinkSyndicatContact);
    });

    function addTagForm($syndicatContactCollHolder, $newLinkSyndicatContact) {
        // Get the data-prototype explained earlier
        var prototype = $syndicatContactCollHolder.data('prototype');

        // get the new index
        var index = $syndicatContactCollHolder.data('index');

        var newForm = prototype;

        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        $syndicatContactCollHolder.data('index', index + 1);

        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkSyndicatContact.after($newFormLi);

        // add a delete link to the new form
        addTagFormDeleteLink($newFormLi);
    }

    function addTagFormDeleteLink($tagFormLi) {
        var $removeFormButton = $('<button type="button" class="btn btn-danger flaticon-delete" style="padding: 5px;"></button>');
        $tagFormLi.append($removeFormButton);

        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            $tagFormLi.remove();
        });
    }

    $("#syndicatContactBtn").on("click", function () {
        $(".syndicatContact select").select2()/*.removeAttr('multiple')*/;
    });

});