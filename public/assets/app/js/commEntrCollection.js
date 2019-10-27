var $commEntrCollectionHolder;

// setup an "add a tag" link
var $addcommEntrButton = $('<button type="button" class="btn btn-primary" style="padding: 5px;" id="addCommissionBtn"><span style="padding-right: 8px" class="flaticon-attachment"></span>Assigner une Commission</button>');
var $newLinkcommEntr = $('<li></li>').append($addcommEntrButton);


jQuery(document).ready(function() {


    // $('#entreprise_contact_1_dateNaissance').parent('div').css('display','none');
    // Get the ul that holds the collection of tags
    // $commEntrCollectionHolder = $('tbody.reperes');
    $commEntrCollectionHolder = $('ul.commissionEntreprise');

    // add a delete link to all of the existing tag form li elements
    // $commEntrCollectionHolder.find('tr').each(function() {
    $commEntrCollectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // $commEntrCollectionHolder.children().css('display', 'inline-block');
    // add the "add a tag" anchor and li to the tags ul
    $commEntrCollectionHolder.append($newLinkcommEntr);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $commEntrCollectionHolder.data('index', $commEntrCollectionHolder.find(':input').length);

    $addcommEntrButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($commEntrCollectionHolder, $newLinkcommEntr);
    });

    function addTagForm($commEntrCollectionHolder, $newLinkcommEntr) {
        // Get the data-prototype explained earlier
        var prototype = $commEntrCollectionHolder.data('prototype');

        // get the new index
        var index = $commEntrCollectionHolder.data('index');

        var newForm = prototype;
        // You need this only if you didn't set 'label' => false in your tags field in TaskType
        // Replace '__name__label__' in the prototype's HTML to
        // instead be a number based on how many items we have
        // newForm = newForm.replace(/__name__label__/g, index);

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        newForm = newForm.replace(/__name__/g, index);

        // increase the index with one for the next item
        $commEntrCollectionHolder.data('index', index + 1);

        // Display the form in the page in an li, before the "Add a tag" link li
        // var $newFormLi = $('<tr class="repeat"></tr>').append(newForm);
        var $newFormLi = $('<li class="row" style="margin: 10px 0"></li>').append(newForm);
        $newLinkcommEntr.before($newFormLi);

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

    $("#addCommissionBtn").on("click", function () {
        $("select").select2();
    })

});