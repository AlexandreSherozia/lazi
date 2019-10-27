var $repereCollectionHolder;

// setup an "add a tag" link
var $addRepereButton = $('<button type="button" class="btn btn-primary flaticon-add-circular-button" style="margin: 20px;padding: 5px;">Rajouter nouveau</button>');
var $newLinkRepere = $('<li></li>').append($addRepereButton);
// var $newLinkRepere = $('<tr class="repeat"></tr>').append($addRepereButton);

jQuery(document).ready(function() {

    // $('#entreprise_contact_1_dateNaissance').parent('div').css('display','none');
    // Get the ul that holds the collection of tags
    // $repereCollectionHolder = $('tbody.reperes');
    $repereCollectionHolder = $('ul.reperes');

    // add a delete link to all of the existing tag form li elements
    // $repereCollectionHolder.find('tr').each(function() {
    $repereCollectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $repereCollectionHolder.append($newLinkRepere);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $repereCollectionHolder.data('index', $repereCollectionHolder.find(':input').length);

    $addRepereButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($repereCollectionHolder, $newLinkRepere);
    });

    function addTagForm($repereCollectionHolder, $newLinkRepere) {
        // Get the data-prototype explained earlier
        var prototype = $repereCollectionHolder.data('prototype');

        // get the new index
        var index = $repereCollectionHolder.data('index');

        var newForm = prototype;
        // You need this only if you didn't set 'label' => false in your tags field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, index);

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        $repereCollectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        // var $newFormLi = $('<tr class="repeat"></tr>').append(newForm);
        var $newFormLi = $('<li></li>').append(newForm);
        $newLinkRepere.after($newFormLi);

        // add a delete link to the new form
        addTagFormDeleteLink($newFormLi);
    }

    function addTagFormDeleteLink($tagFormLi) {
        var $removeFormButton = $('<button type="button" class="btn btn-danger flaticon-delete" style="padding: 5px;margin: 5px;"></button>');
        $tagFormLi.append($removeFormButton);

        $removeFormButton.on('click', function(e) {
            // remove the li for the tag form
            $tagFormLi.remove();
        });
    }
});