var $collectionHolder;

// setup an "add a member" link
var $addmemberLink = $('<a href="#" class="add_member_link">Add</a>');
var $newLinkLi = $('<li></li>').append($addmemberLink);

jQuery(document).ready(function () {
    // Get the ul that holds the collection of members
    $collectionHolder = $('ul.members');

    // add a delete link to all of the existing member form li elements
    $collectionHolder.find('li').each(function() {
        addmemberFormDeleteLink($(this));
    });

    // add the "add a member" anchor and li to the members ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addmemberLink.on('click', function (e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new member form (see next code block)
        addmemberForm($collectionHolder, $newLinkLi);
    });
});