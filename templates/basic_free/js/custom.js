$(document).ready( function () {
    if ($('section').is('.main-banner')) {
        // $('.menu-left').css('display', 'flex');
        $('.menu-left').removeClass('d-none');
    }
    if (window.location.pathname != '/') {
        $('#title-menu-left').click(function (e) {
            e.preventDefault();
            $('.menu-left').toggleClass('d-none');
        });
    } else {
        $('.menu-left').removeClass('d-none');
    }
    
    $('.mega-dropdown').hover(
        function (e) {
            $(this).find('.sub-menu').removeAttr('style');
            // $(this).find('.sub-menu').css({'display': 'flex'});
        },
        function (e) {
            $(this).find('.sub-menu').css({'display': 'none'});
        }
    );
    
    let ajaxSuccess = 0;
    
    //  поиск по сайту xl
    $('#main-search').bind("input", function (e) {
        if (this.value.length >= 3) {
            search(this.value);
        }
    });

    $('#main-search2').bind("input", function (e) {
        if (this.value.length >= 3) {
            search(this.value);
        }
    });

    $('#icon-search').on('click', function(event) {
        console.log($('.input-search').val().length);
        if ($('.input-search').val().length >= 3) {
            search($('.input-search').val());
        }
    })
    
    // поиск по сайту мобильный
    $('.search-mobile-input').bind("input", function (e) {
        if (this.value.length >= 3) {
            search2(this.value);
        }
    });
    
    
    $(".mega-dropdown").hover(function () {
        $('body').append('<div class="overlay-1qk5q intered"></div>');
        $('.site-header').css({'z-index': '1000', 'position': 'relative'});
    }, function () {
        $('.overlay-1qk5q').remove();
    });
    
    
    $(".search_result").on('focus', function () {
        alert("ok");
    });
    
    $(document).mouseup(function (e) { // событие клика по веб-документу
        let ul = $(".search_result"); // тут указываем ID элемента
        if (!ul.is(e.target) // если клик был не по нашему блоку
            && ul.has(e.target).length === 0) { // и не по его дочерним элементам
            $(".search_result").fadeOut(); // скрываем его
        }
    });
    
    //При выборе результата поиска, прячем список и заносим выбранный результат в input
    $(".search_result").on("click", "li", function () {
        s_user = $(this).text();
        //$(".who").val(s_user).attr('disabled', 'disabled'); //деактивируем input, если нужно
        $(".search_result").fadeOut();
    });
    
    $("#main-search").keyup(function (e) {
        if (e.which == 8 && this.length < 3) {
            $('.search_result').empty();
        }
    });
    
    
    $("input[name='referal']").keypress(function (e) {
        if (e.which == 13 && ajaxSuccess == 1) {
            window.location.href = $(".search_result").first().children('a').attr('href');
        }
    });
    
    $("#icon-search").keypress(function (e) {
        
        if ($(".search_result")) {
        
        }
        window.location.href = $(".search_result").first().children('a').attr('href')
    })
    
    
    $('#btn-cookies').on('click', function (e) {
        
        $.cookie('approval_cookies', 1, {
            expires: 90,
            path: '/'
        });
        $('.cookies-notification').addClass('d-none');
    });
    
    if (!$.cookie('approval_cookies')) {
        $('.cookies-notification').removeClass('d-none');
    }
    
    // button order one click
    
    $('.btn-oneclick').on('click', function (event) {
        let $this = $(this);
        let linkItem = $this[0].dataset.seolink;
        let titleItem = $this[0].dataset.title;
        let imgItem = $this[0].dataset.img;
        let artNoItem = $this[0].dataset.artNo;
        let priceItem = $this[0].dataset.price;
        
        $('#oneclickerLabel').text(titleItem);
        $('#oneClickImg').attr('src', imgItem);
        $('#oneClickImg').attr('alt', titleItem);
        $('#results1').text(priceItem);
        $('input[name=price1]').attr('value', priceItem);
        $('input[name=seolink]').attr('value', linkItem);
        $('input[name=ttl]').attr('value', titleItem);
        $('input[name=arts]').attr('value', artNoItem);
        
    });
    
    $('#form-order-oneclick').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: '/',
            type: 'post',
            data: $('#form-order-oneclick').serialize(),
            success: function (response) {
                $("#oneclicker").removeClass("fade").modal("hide");
                $('.toast-body').text('Завка принята');
                $('#toast-wrap').removeClass('d-none');
                $('.toast').toast('show');
            },
            error: function (response) {
                $('.toast-body').text('Ошибка что то пошло не так');
                $('.toast').toast();
            },
            
        })
    });
    
    $('.toast').on('hidden.bs.toast', function () {
        $('#toast-wrap').addClass('d-none');
    })
    
    // Кнопки input в корзине
    $('.inputTN__bottom').on('click', function (event) {
        let input = $(this).prev().prev();
        let oldCount = parseInt($(input).val());
        if (oldCount == 1) {
            return false;
        }
        let newCount = --oldCount;
        input.val(newCount);
        recountSumm();
    });
    
    
    $('.inputTN__top').on('click', function (event) {
        
        let input = $(this).prev();
        let oldCount = parseInt($(input).val());
        let newCount = ++oldCount;
        input.val(newCount);
        recountSumm();
    });
    
    // Кнопки input +- на карточке товара
    $('.inputItemCount__bottom').on('click', function (event) {
        let input = $(this).prev().prev();
        let oldCount = parseInt($(input).val());
        if (oldCount == 1) {
            return false;
        }
        let newCount = --oldCount;
        input.val(newCount);
        recountSumm();
    });
    
    
    $('.inputItemCount__top').on('click', function (event) {
        
        let input = $(this).prev();
        let oldCount = parseInt($(input).val());
        let newCount = ++oldCount;
        input.val(newCount);
        recountSumm();
    });
    
    $('#btnFilterItems').on('click', function (event) {
        $('#divFilterItems').toggleClass('d-none');
    })
    
    
})

function search2(value) {
    let url =  "/search?do=words&value="; //"/432gsdt55gs34hhj.php";
    $.ajax({
        type: 'post',
        url: url + value, //Путь к обработчику

        data: {
            'value': value,
        },
        success: function (data) {
            console.log(data);
            let arr = data;//JSON.parse(data);
            let titleListSearch = $('<div class="col title-list-search"></div>');
            let itemListSearch = $('a', {
                'class': 'item-list-search',
                'href': ''
            });

            
            $(".search_result").empty();

            ajaxSuccess = 1;

            $(".search_result").fadeIn();
            
        }
    });
}

function search2(value) {
    let url =  "/search?do=words2&value="; //"/432gsdt55gs34hhj.php";
    $.ajax({
        type: 'post',
        url: url + value, //Путь к обработчику

        data: {
            'referal': value,
        },
        success: function (data) {
            console.log(data);
        }
    });
}




