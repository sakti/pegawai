$(function(){
    function updatePesan(pesan){
        isiPesan.html(pesan).addClass('cahaya');
        setTimeout(function() {
            isiPesan.removeClass('cahaya', 1500);
        }, 500);
        pnlPesan.css('top',$(document).scrollTop());
        pnlPesan.fadeIn('slow');
    }

});

