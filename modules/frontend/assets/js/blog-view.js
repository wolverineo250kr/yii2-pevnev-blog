 
$(document).ready(function(){ 
    adjustLeft();
    
    var images = $('.content-power').find('img');
    
    images.each(function () {
          var src = $(this).attr('src');
          var width = $(this).width();
          
          $(this).css('width', '100%');
          $(this).css('height', 'auto');
                    $(this).css('max-width', width);
 
    });
 

});

$(window).on('resize', function(){
          adjustLeft();
    if ($(window).width() < 768) {
        $('body').find('.news-box').height('');
    }
});
 

function adjustLeft(){

       if ($(window).width() > 768) {

	   if(  $('.left-menu').height() < $('.right-menu').height()){
	         $('.left-menu').height($('.right-menu').height());
         $('.left-menu').css('min-height',   $('.left-menu > .row').height() - 50);
	   }else{
	           $('.left-menu').height('');
                         $('.left-menu').css('min-height');
		   }

       }else{	  
               $('.left-menu').height('');
                         $('.left-menu').css('min-height');
       }
}
