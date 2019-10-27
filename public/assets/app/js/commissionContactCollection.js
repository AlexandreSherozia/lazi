var $commissionContactCollectionHolder;

// setup an "add a tag" link
var $addcommissionContactButton = $('<button type="button" class="btn btn-primary flaticon-add-circular-button" style="margin: 20px;padding: 5px;" id="commissionContactBtn"></button>');
var $newLinkCommissionContact = $('<li></li>').append($addcommissionContactButton);


jQuery(document).ready(function() {

    // $(".commission select").removeAttr("multiple");
    // $('#entreprise_contact_1_dateNaissance').parent('div').css('display','none');
    // Get the ul that holds the collection of tags
    // $commissionContactCollectionHolder = $('tbody.reperes');
    $commissionContactCollectionHolder = $('ul.commission');

    // add a delete link to all of the existing tag form li elements
    // $commissionContactCollectionHolder.find('tr').each(function() {
    $commissionContactCollectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // $commissionContactCollectionHolder.children().css('display', 'inline-block');
    // add the "add a tag" anchor and li to the tags ul
    $commissionContactCollectionHolder.append($newLinkCommissionContact);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $commissionContactCollectionHolder.data('index', $commissionContactCollectionHolder.find(':input').length);

    $addcommissionContactButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($commissionContactCollectionHolder, $newLinkCommissionContact);
    });

    function addTagForm($commissionContactCollectionHolder, $newLinkCommissionContact) {
        // Get the data-prototype explained earlier
        var prototype = $commissionContactCollectionHolder.data('prototype');

        // get the new index
        var index = $commissionContactCollectionHolder.data('index');

        var newForm = prototype;
        // You need this only if you didn't set 'label' => false in your tags field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, index);

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        $commissionContactCollectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        // var $newFormLi = $('<tr class="repeat"></tr>').append(newForm);
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkCommissionContact.after($newFormLi);

        // add a delete link to the new form
        addTagFormDeleteLink($newFormLi);
    }

    function addTagFormDeleteLink($tagFormLi) {
        var $removeFormButton = $('<button type="button" class="btn btn-danger flaticon-delete" style="padding: 5px; margin: 5px;"></button>');
        $tagFormLi.append($removeFormButton);

        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            $tagFormLi.remove();
        });
    }

    $("#commissionContactBtn").on("click", function () {
        $(".commission select").select2()/*.removeAttr("multiple")*/;
    });

});