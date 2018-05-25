function addmemberFormDeleteLink($memberFormLi) {
    var $removeFormA = $('<a href="#"> delete</a>');
    $memberFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the member form
        $memberFormLi.remove();
    });
}