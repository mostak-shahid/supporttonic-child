jQuery(document).ready(function($){    
    $(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.mos-sticky-header').addClass('tiny');
		} else {
			$('.mos-sticky-header').removeClass('tiny');
		}
	});   
    $('.counter').counterUp();
    $(".beer-slider").each(function (index, el) {
        $(el).BeerSlider({
            start: $(el).data("start")
        })
    });
    
    $(".mos-select-menu").submit(function (e) {
        e.preventDefault();
        var fields = $(this).serializeArray();
        if(fields[0].value) {
            location.replace(fields[0].value);
        }
        /*$.each(fields, function (i, field) {
            console.log(field.value + " ");
        });*/
        
    });
    
});