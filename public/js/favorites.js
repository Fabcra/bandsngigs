jQuery(document).ready(function () {
    $('.js-fav').on('click', function (e) {
        e.preventDefault();

        $(this).find('.fa').toggleClass('fa-heart-o').toggleClass('fa-heart')

        $.ajax({
            url: $(this).data('url'),
            method: 'POST'
        })
    });

});