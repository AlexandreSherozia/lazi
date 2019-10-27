var $bureauCollectionHolder;

// setup an "add a tag" link
var $addBureauButton = $('<button type="button" class="btn btn-primary flaticon-add-circular-button" style="margin: 20px;padding: 5px;"></button>');
var $newLinkBureau = $('<li></li>').append($addBureauButton);


jQuery(document).ready(function() {


    // $('#entreprise_contact_1_dateNaissance').parent('div').css('display','none');
    // Get the ul that holds the collection of tags
    // $bureauCollectionHolder = $('tbody.reperes');
    $bureauCollectionHolder = $('ul.conseilAdministration');

    // add a delete link to all of the existing tag form li elements
    // $bureauCollectionHolder.find('tr').each(function() {
    $bureauCollectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // $bureauCollectionHolder.children().css('display', 'inline-block');
    // add the "add a tag" anchor and li to the tags ul
    $bureauCollectionHolder.append($newLinkBureau);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $bureauCollectionHolder.data('index', $bureauCollectionHolder.find(':input').length);

    $addBureauButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($bureauCollectionHolder, $newLinkBureau);
    });

    function addTagForm($bureauCollectionHolder, $newLinkBureau) {
        // Get the data-prototype explained earlier
        var prototype = $bureauCollectionHolder.data('prototype');

        // get the new index
        var index = $bureauCollectionHolder.data('index');

        var newForm = prototype;

        newForm = newForm.replace(/__name__/g, index);

        $bureauCollectionHolder.data('index', index + 1);

        var $newFormLi = $('<li style="margin-left: 150px"></li>').append(newForm).addClass('col-lg-8');
        $newLinkBureau.before($newFormLi);

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

});