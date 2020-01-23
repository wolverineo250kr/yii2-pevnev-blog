var loaded = false;

$(document).ready(function(){
    loadNews();
    separatorHeightReduction();
    adjustLeft();
});

$(window).on('resize', function(){
          adjustLeft();
    if ($(window).width() < 768) {
        $('body').find('.news-box').height('');
    }
});

$('body').on('click', '.group-block:not(.active)', function(){
      plaingWithMobileMenu();
    $('#moreGiveMemore').attr('href', '/blog?page=1&per-page=12');
    $('#moreGiveMemore').attr('data-fact', 1).attr('data-page-size', 12);
    $('.bolshoy-i-tolstiy').addClass('hidden');
    $('.group-block').removeClass('active');
    $(this).addClass('active');

$('.right-menu').find('.separator').remove();
    $('.right-menu').prepend("<div class='row separator'></div>");

    $('#moreGiveMemore').trigger('click');
});

function loadNews(){
    var active = parseInt($('.group-block.active').attr('data-group-id'));

    $('#moreGiveMemore').trigger('click');
}

$('body').on('click', 'a.buttonShowMobileMenu', function(e){
      plaingWithMobileMenu();
      
      e.preventDefault(); 
});

function plaingWithMobileMenu(){
      var blogMenu = $('.group-line.left-menu');
      if($(window).width() < 768){
            if(blogMenu.hasClass('opened')){
                  blogMenu.css('right',''); // hide menu 
                    blogMenu.removeClass('opened'); // remove is opened detector class
            $('body').find('.left-menu').find('.buttonShowMobileMenu.right').removeClass('hidden');
                   $('body').find('.left-menu').find('.buttonShowMobileMenu.left').addClass('hidden');
                   $('.right-menu').css('opacity', '');
                                     var timer;
                clearInterval(timer); // удаляем предыдущий таймер 
                timer = setTimeout(function(){
                $('.right-menu').css('opacity', '');
                }, 0); // устанавливаем новый таймер и запоминае его
                
            }else{ 
                   blogMenu.css('right','0%'); // show menu
                          blogMenu.addClass('opened'); // add is opened detector class
          $('body').find('.left-menu').find('.buttonShowMobileMenu.right').addClass('hidden');
             $('body').find('.left-menu').find('.buttonShowMobileMenu.left').removeClass('hidden');
                          var timer;
                clearInterval(timer); // удаляем предыдущий таймер 
                timer = setTimeout(function(){
                $('.right-menu').css('opacity', '0');
                }, 0); // устанавливаем новый таймер и запоминае его
            }
      }    
}

$('body').on('click', '.right-menu', function(e){
if($('.group-line.left-menu').hasClass('opened')){
        e.preventDefault(); 
      return false;
}
});

function separatorHeightReduction(){
  var separatistovOtryad = $('.right-menu').find('.separator');
    $.each( separatistovOtryad, function( key, value ) {
        var separatorHeight = $(value).height();

    if ($(window).width() < 991) {
        $('body').find('.news-box').height('');
    }else{
             $(value).find('.news-box').height(separatorHeight);
    }
    });
}

$('body').on('click', '#moreGiveMemore', function(e){
    e.preventDefault();
    var button = $(this);
    button.button('loading');
var url = button.attr('href');
    var pagesCount = parseInt(button.attr('data-all'));
var pageSize =  parseInt(button.attr('data-page-size'));

    $.ajax({
        url: url,
        cache: false,
        dataType: 'HTML',
        type: 'POST',
        data:{
		           "_csrf":yii.getCsrfToken(),
            "_csrf-frontend":yii.getCsrfToken(), //  Yii2 2.0.2+
            "groupActive": parseInt($('.group-block.active').attr('data-group-id'))
        },
        success: function (data) {
             
            button.button('success');
            button.attr('href', '/blog?page='+(parseInt(button.attr('data-fact'))+1)+'&per-page='+pageSize);
            button.attr('data-fact',parseInt(button.attr('data-fact'))+1);

  $('body').find('.content').find('.separator').last().after(data);
  
                $('body').find('.content').find('.separator').fadeIn();

            var bolnoUmniye = parseInt($('body').find('.content').find('.separator').last().find('.dobro').text());

            button.attr('data-all', bolnoUmniye);
            button.attr('data-left', bolnoUmniye);
            button.attr('data-left', bolnoUmniye - parseInt($('body').find('.content').find('.news-box').length));

            if(parseInt(button.attr('data-left')) <= 0){
                 $('.bolshoy-i-tolstiy').addClass('hidden');
           }else{
                $('.bolshoy-i-tolstiy').removeClass('hidden');
            }

            separatorHeightReduction();
        },
        beforeSend: function () {
            if (loaded) {
                return false;
            } else {
                   $('body').find('.content').find('#error').hide();
                  $('#spin-day').show();
                loaded = true;
            }
        },
        complete: function () {
                    $('#spin-day').hide();
            loaded = false;
                      adjustLeft();
        },
        timeout: 30000,
        error: function (data) {
              $('body').find('.content').find('#error').show();
            button.button('error');
        }
    });


});
  
function adjustLeft(){
       if ($(window).width() > 768) {
      $('.left-menu').height($('.right-menu').height());
          $('.left-menu').css('min-height',   $('.left-menu > .row').height() - 50);
       }else{
               $('.left-menu').height('');
                         $('.left-menu').css('min-height', '');
       }
}
