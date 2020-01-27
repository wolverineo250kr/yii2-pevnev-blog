// Set of params and blocks
var loaded = false;
var triggerButton = $('#moreGiveMemore');
var leftMenu = $('body').find('.left-menu');
var rightMenu = $('body').find('.right-menu');
var mysteryBlock = $('.bolshoy-i-tolstiy');
var contentBlock = $('body').find('.content');
var newsBoxClassName = '.news-box';
var route = triggerButton.attr('data-route').toString();

$(document).ready(function () {
    loadNews();
    separatorHeightReduction();
    adjustLeft();
});

$(window).on('resize', function () {
    adjustLeft();
    if ($(window).width() < 768) {
        $('body').find(newsBoxClassName).height('');
    }
});

$('body').on('click', '.group-block:not(.active)', function () {
    plaingWithMobileMenu();
    triggerButton.attr('href', '/' + route + '?page=1&per-page=12');
    triggerButton.attr('data-fact', 1).attr('data-page-size', 12);
    mysteryBlock.addClass('hidden');
    $('.group-block').removeClass('active');
    $(this).addClass('active');
    rightMenu.find('.separator').remove();
    rightMenu.prepend("<div class='row separator'></div>");
    triggerButton.trigger('click');
});

$('body').on('click', 'a.buttonShowMobileMenu', function (e) {
    plaingWithMobileMenu();
    e.preventDefault();
});

$('body').on('click', '.right-menu', function (e) {
    if ($('.group-line.left-menu').hasClass('opened')) {
        e.preventDefault();
        return false;
    }
});

$('body').on('click', '#moreGiveMemore', function (e) {
    e.preventDefault();
    var button = $(this);
    button.button('loading');
    var url = button.attr('href');
    var pagesCount = parseInt(button.attr('data-all'));
    var pageSize = parseInt(button.attr('data-page-size'));

    $.ajax({
        url: url,
        cache: false,
        dataType: 'HTML',
        type: 'POST',
        data: {
            "yii.getCsrfParam()": yii.getCsrfToken(),
            "groupActive": parseInt($('.group-block.active').attr('data-group-id'))
        },
        success: function (data) {
            button.button('success');
            button.attr('href', '/' + route + '?page=' + (parseInt(button.attr('data-fact')) + 1) + '&per-page=' + pageSize);
            button.attr('data-fact', parseInt(button.attr('data-fact')) + 1);
            contentBlock.find('.separator').last().after(data);
            contentBlock.find('.separator').fadeIn();
            var bolnoUmniye = parseInt(contentBlock.find('.separator').last().find('.dobro').text());

            button.attr('data-all', bolnoUmniye);
            button.attr('data-left', bolnoUmniye);
            button.attr('data-left', bolnoUmniye - parseInt(contentBlock.find(newsBoxClassName).length));

            if (parseInt(button.attr('data-left')) <= 0) {
                mysteryBlock.addClass('hidden');
            } else {
                mysteryBlock.removeClass('hidden');
            }

            separatorHeightReduction();
        },
        beforeSend: function () {
            if (loaded) {
                return false;
            } else {
                contentBlock.find('#error').hide();
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
            contentBlock.find('#error').show();
            button.button('error');
        }
    });
});

function adjustLeft() {
    if ($(window).width() > 768) {
        leftMenu.height(rightMenu.height());
        leftMenu.css('min-height', $('.left-menu > .row').height() - 50);
    } else {
        leftMenu.height('');
        leftMenu.css('min-height', '');
    }
}

function loadNews() {
    var active = parseInt($('.group-block.active').attr('data-group-id'));
    triggerButton.trigger('click');
}

function separatorHeightReduction() {
    $.each(rightMenu.find('.separator'), function (key, value) {
        var separatorHeight = $(value).height();

        if ($(window).width() < 991) {
            $('body').find(newsBoxClassName).height('');
        } else {
            $(value).find(newsBoxClassName).height(separatorHeight);
        }
    });
}

function plaingWithMobileMenu() {
    var blogMenu = $('.group-line.left-menu');
    var timer;
    clearInterval(timer);
    if ($(window).width() < 768) {
        if (blogMenu.hasClass('opened')) {
            blogMenu.css('right', '').removeClass('opened');
            rightMenu.find('.buttonShowMobileMenu.right').removeClass('hidden');
            rightMenu.find('.buttonShowMobileMenu.left').addClass('hidden');
            rightMenu.css('opacity', '');

            timer = setTimeout(function () {
                rightMenu.css('opacity', '');
            }, 0);
        } else {
            blogMenu.css('right', '0%').addClass('opened');
            rightMenu.find('.buttonShowMobileMenu.right').addClass('hidden');
            rightMenu.find('.buttonShowMobileMenu.left').removeClass('hidden');

            timer = setTimeout(function () {
                rightMenu.css('opacity', '0');
            }, 0);
        }
    }
}
