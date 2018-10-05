jQuery(document).ready(function () {
    $('.js-remove-image-gallery').on('click', function (e) {
        e.preventDefault();

        var $el = $(this).closest('.js-gallery-item');

        $(this).find('.fa-close')
            .removeClass('fa-close')

        $.ajax({
            url: $(this).data('url'),
            method: 'DELETE'
        }).done(function () {
            $el.fadeOut();
        })
    });

});