 $( document ).ready(function() {
    $('.js-tab-trigger').on('click', function() {
        console.log(3);
        var id = $(this).attr('data-tab'),
            content = $('.js-tab-content[data-tab="'+ id +'"]');
        
        $('.js-tab-trigger.active').removeClass('active'); // 1
        $(this).addClass('active'); // 2
        
        $('.js-tab-content.active').removeClass('active'); // 3
        content.addClass('active'); // 4
     });

     var $modal = $('.modal'),
    $overlay = $('.overlay'),
    $showModal = $('.show-modal'),
    $close = $('.close');
        
    /*show modal and set dimensions based on window */
    $showModal.on('click', function(e){
        e.preventDefault();

        
        $overlay.show();
        $modal.css({
            'display' : 'block'
        });
    });
    /*close on click of 'x' */
    $close.on('click', function(){
        $overlay.hide();
        $modal.hide();
    });
    /* close on click outside of modal */
    $overlay.on('click', function(e) {
    if (e.target !== this) return;
    $overlay.hide();
    $modal.hide();

    });

    $(".questions-block table tr").on("mouseover", function() {
        $('.hover-block').remove();
        $(this).append($(`<table class="hover-block">${$(this).html()}</table>`));
        
    });
});
