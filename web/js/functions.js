/**
 * Created by victor on 8/05/17.
 */

$(window).scroll(function(){
    //header
    var wScroll=$(this).scrollTop();
    $('.logo').css({
        'transform':'translate(0px, '+ wScroll /6 +'%)'
    });
    $('.fore-hiker').css({
        'transform':'translate(0px, -'+ wScroll /40 +'%)'
    });

    //items
    if (wScroll > $('.product-blocks').offset().top -
        $(window).height()){
        var offset = Math.min(0, wScroll-$('.product-blocks').offset().top +
            $(window).height()-400);

        $('.block-1').css({'transform':'translate('+ offset+'px,'
        + Math.abs(offset)+'px)' });
        $('.block-3').css({'transform':'translate('+ Math.abs(offset)+'px,'
        + Math.abs(offset)+'px)' });
    };

});

$('a#calendario').click(function(e){

    $("a#calendario").children().show();
});




