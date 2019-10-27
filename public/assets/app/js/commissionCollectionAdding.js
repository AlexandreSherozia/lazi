var $commissionCollection;

// setup an "add a tag" link
var $addButton = $('<button type="button" class="btn btn-default" style="padding: 5px;"><span style="padding-right: 8px" class="flaticon-add-circular-button"></span>Créer une Commission</button>');
var $newLink = $('<li></li>').append($addButton);

// (function ($) {
    

    jQuery(document).ready(function() {

        // $('#entreprise_contact_1_dateNaissance').parent('div').css('display','none');
        // Get the ul that holds the collection of tags
        // $commissionCollection = $('tbody.contacts');
        $commissionCollection = $('ul.commission');

        // add a delete link to all of the existing tag form li elements
        // $commissionCollection.find('tr').each(function() {
        $commissionCollection.find('li').each(function() {
            addTagFormDeleteLink($(this));
        });

        // add the "add a tag" anchor and li to the tags ul
        $commissionCollection.append($newLink);

        // count the current form inputs we have (e.g. 2), use that as the new
        // index when inserting a new item (e.g. 2)
        $commissionCollection.data('index', $commissionCollection.find(':input').length);

        $addButton.on('click', function(e) {
            // add a new tag form (see next code block)
            addTagForm($commissionCollection, $newLink);
        });

        function addTagForm($commissionCollection, $newLink) {
            // Get the data-prototype explained earlier
            var prototype = $commissionCollection.data('prototype');

            // get the new index
            var index = $commissionCollection.data('index');

            var commissionForm = prototype;
            // You need this only if you didn't set 'label' => false in your tags field in TaskType
            // Replace '__name__label__' in the prototype's HTML to
            // instead be a number based on how many items we have
            // commissionForm = commissionForm.replace(/__name__label__/g, index);

            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            commissionForm = commissionForm.replace(/__name__/g, index);

            // increase the index with one for the next item
            $commissionCollection.data('index', index + 1);

            // Display the form in the page in an li, before the "Add a tag" link li
            // var $newFormLi = $('<tr class="repeat"></tr>').append(commissionForm);
            var $newFormLi = $('<li class="row" style="margin: 10px 0"></li>').append(commissionForm);
            $newLink.before($newFormLi);

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

// })(jQuery);