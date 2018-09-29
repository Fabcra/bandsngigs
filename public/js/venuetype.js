$("document").ready(function () {

    if($(".js-venuetype").val()==='1'){
        $(".js-sub-venue").show()
        $(".js-unsub-venue").hide()
    }else{
        $(".js-sub-venue").hide()
        $(".js-unsub-venue").show()
    }

    $(".js-venuetype").change(function () {

        if ($(this).val() === '1') {
            $(".js-sub-venue").show()
            $(".js-unsub-venue").hide()
            $(".js-unsub-venue input").val('')
            $(".js-unsub-venue select").prop('selectedIndex',0)

        } else if ($(this).val() === '2'){
            $(".js-unsub-venue").show()
            $(".js-sub-venue").hide()
            $(".js-sub-venue select").prop('selectedIndex',0)
        }

    })
})