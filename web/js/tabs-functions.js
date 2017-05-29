$(function(){
    $('.listaContactos').hide();
    $('.contactadded').click(function(){
        $(this).children().removeClass('glyphicon-plus-sign').addClass('glyphicon-ok-sign');
    });

    $('#mostrarcontactos' ).click(function() {
        $('.listaContactos').slideToggle();
    });

    $('#buscarform input').submit(function(e)
    {
        if( !$(this).val() ) {
            e.preventDefault();
            $(this).parents('p').addClass('warning');
        }
    });
});

