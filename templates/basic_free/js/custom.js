$(document).ready(function () {
    if ($('section').is('.main-banner')) {
        // $('.menu-left').css('display', 'flex');
        $('.menu-left').removeClass('d-none');
    }
    if (window.location.pathname != '/') {
        $('#title-menu-left').click(function (e) {
            e.preventDefault();
            $('.menu-left').toggleClass('d-none');
        });
    }

    let ajaxSuccess = 0;

    $('.search-all').bind("input", function (e) {
        let search = this.value;
        if (this.value.length >= 3) {
            $.ajax({
                type: 'post',
                url: "/432gsdt55gs34hhj.php", //Путь к обработчику
                // url: "/new-search.php", //Путь к обработчику
                data: {
                    'referal': search,
                },

                success: function (data) {
                    let arr = JSON.parse(data);
                    $(".search_result").empty();

                    if (arr['categories'].length == 0 && arr['vendors'].length == 0 && arr['ven_code'].length == 0 && arr['prod'].length == 0) {
                        $(".search_result").append('<li class="search_result_item"><p class="">Ничего не найдено</p></li>')
                    }

                    if (arr['categories'].length) {
                        $(".search_result").append('<h5 class="text-bold">Категории</h5>');
                        $(".category").remove();
                        arr['categories'].forEach(function (item, i) {
                            $(".search_result").append(`<a href="/shop/${item.seolink}"><li class="category search_result_item">${item?.title}</li></a>`);
                        });
                    }
                    // else {
                    //     $(".search_result").append('<h5 class="text-bold">Категории</h5>');
                    //     $(".search_result").append(`<li class="category search_result_item">Ничего не найдено</li>`);
                    // }

                    if (arr['vendors'].length) {
                        $(".search_result").append('<h5 class="text-bold">Производители</h5>');
                        arr['vendors'].forEach(function (item, i) {
                            $(".search_result").append(`<a href="/shop/vendors/${item.id}"><li class="vendor search_result_item">${item?.title}</li></a>`);
                        });
                    }

                    if (arr['ven_code'].length) {
                        $(".search_result").append('<h5 class="text-bold">Артикул</h5>');
                        arr['ven_code'].forEach(function (item, i) {
                            $(".search_result").append(`<a href="/shop/${item.seolink}.html"><li class="art_no search_result_item"><span style="color: #000000;">Арт:</span> ${item?.ven_code} <br> <span style="color: #000000;">Код товара:</span>${item?.art_no} <br><span style="color: #000000;">Название: </span> ${item?.title}</li></a>`);
                        });
                    }

                    if (arr['prod'].length) {
                        $(".search_result").append('<h5 class="text-bold">Товары</h5>');
                        $(".prod").remove();
                        arr['prod'].forEach(function (item, i) {
                            $(".search_result").append(`<a href="/shop/${item.seolink}.html"><li class="prod search_result_item">${item?.title}</li></a>`);
                        });
                    }

                    ajaxSuccess = 1;

                    $(".search_result").fadeIn();

                }
            });
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

    $("input[name='referal']").keyup(function (e) {
        if (e.which == 8 && this.length < 3) {
            $('.search_result').empty();
        }
    });


    $("input[name='referal']").keypress(function (e) {
        if (e.which == 13 && ajaxSuccess == 1) {
            window.location.href = $(".search_result").first().children('a').attr('href');
        }
    });


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

    // $('#login').on('click', function() {
    //     $.ajax({
    //         url: '/login',
    //         success: function(data) {
    //             $('#modal-body').html(data.html);
    //             $('#modal-login').modal('show');
    //         }
    //     })
    // });

    // $('.carousel').carousel({
    //     interval: 0
    // });

})
