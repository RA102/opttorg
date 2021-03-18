$(document).ready(function(event) {
    $('#destination_id').on('input', function() {
        $.ajax({
            url: 'https://api.exline.systems/public/v1/regions/destination?title=' + $('#destination_id').val(),
            type: 'GET',
            success: function(data) {
                $('#listCity').removeClass('d-none');
                $('#listCity').empty();
                // let country = 'Казахстан';
                // $("#myList li").filter(function() {
                //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                // });
                data.regions.forEach(function(item) {
                    $('#listCity').append($('<li>').addClass('select-city').append($('<div>', {
                        'text': item.title,
                        'data-id': item.id
                    }).addClass('select-city-div').append($('<span>').text(item.cached_path).addClass('text-muted ml-1'))));

                });

            }
        })
    });

    $('#listCity').on('click', function(event) {
        event.stopPropagation();

        let target = $(event.target);

        if (target.is('span')) {
            let div = $(target).parent('div');
            let id = $(div).data('id');
            let text = $(div).justtext();

            $('#destination_id').attr('data-city-id', id).val(text);
            $('#listCity').addClass('d-none');

        } else if (target.is('div')) {
            let id = $(event.target).data('id');
            let text = $(event.target).justtext();

            $('#destination_id').attr('data-city-id', id).val(text);
            $('#listCity').addClass('d-none');

        }

    })

    $('#btn-calculate-delivery').on('click', function(event) {
        let origin_id = $('.origin_id').val();
        let destination_id = $('#destination_id').attr('data-city-id');
        let deliveryMethod = $('#deliveryMethod').val();
        let sumDelivery = 0;
        let sum = 0;
        let deliveryCostUpTo5 = 1580;

        let itemsParams = $('div#params').children('input');


        itemsParams.each(function(index, item) {
            let width = $(item).data('width');
            let height = $(item).data('height');
            let depth = $(item).data('depth');
            let weight = $(item).data('weight');

            if (weight < 5) {

                sumDelivery += deliveryCostUpTo5;

            } else {
                $.ajax({
                    url: 'https://api.exline.systems/public/v1/calculate?' +
                        'origin_id=27' +
                        '&destination_id=' + destination_id +
                        '&wight=' + width +
                        '&height=' + height +
                        '&depth=' + depth +
                        '&weight=' + weight +
                        '&service=' + deliveryMethod,
                    type: 'GET',
                    async: false,
                    success: function(data, textStatus, jqXHR) {
                        console.log(data);
                        sum = +(data.calculation.price) + +(data.calculation.declared_value_fee) + +(data.calculation.fuel_surplus);
                        // if (textStatus == 'success') {
                        //     $('#costDelivery').append($('<li>', {text: sum}));
                        // }

                        sumDelivery += sum;
                        $('#sumDelivery').text(sumDelivery);

                    },
                })
            }
        })
        $('.close').trigger('click');
        $('#mainFormDelivery').append($('<input/>').attr({'type': 'text', 'name': 'price_delivery', 'value': sumDelivery, 'hidden': true}));
    })

    $('#destination_id').on('keydown',function(event) {
        switch (event.keyCode) {
            case 40:
                navigate('up');
                break;
            case 38:
                navigate('down');
                break;
            case 13:
                getAttributDiv(event);
                break;
        }
    })

    $('#cost_delivery').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: '/shop/list-cities',
            type: 'POST',
            success: function(data) {
                $('.selectpicker').empty();
                data.data.forEach(function(value, index) {
                    $('.selectpicker').append(`<option data-tokens="${value}" style="width: 100%; overflow: hidden;">${value}</option>`);
                })
                $('.selectpicker').selectpicker('render');
                $('.selectpicker').selectpicker('refresh');
            }
        })
    });

    // $("#formDelivery").submit(function(event) {
    //     event.preventDefault();
        // $.ajax({
        //     type: "POST",
        //     url: "https://jet7777.ru/cabinet/api/calc_transport",
        //     contentType: 'application/json',
        //     data: {
        //         "access_token": "$2y$10$cSD56j/K4OmGe5stmop2.u2ddfKGwixPXaRqOJ3.qff0.aiLW0Dvy",
        //         "cityfrom": "Караганды",
        //         "cityto": "Нур-Султан",
        //         "ves": 5,
        //         "obm3": 3,
        //         "dlina": 120,
        //         "mest": 1,
        //         "cost": 15000,
        //         "naimenovanie": "САНТЕХНИКА",
        //         "dops": { "D_HARDPACK": 1, "D_EP": 0, "D_PB": 0, "D_VPP": 0, "D_SP": 0, "D_SDOC": 0, "D_EK": 0}
        //     },
        //     success: function(data) {
        //         console.log(data);
        //     }
        // })
        // let settings = {
        //     "url": "https://jet7777.ru/cabinet/api/calc_transport",
        //     "method": "POST",
        //     "timeout": 0,
        //     "headers": {
        //         "contentType": "application/json",
        //     },
        //     "data": JSON.stringify({"access_token":"$2y$10$cSD56j/K4OmGe5stmop2.u2ddfKGwixPXaRqOJ3.qff0.aiLW0Dvy","cityfrom":"Караганды","cityto":"Нур-Султан","ves":5,"obm3":3,"dlina":120,"mest":1,"cost":15000,"naimenovanie":"САНТЕХНИКА","dops":{"D_HARDPACK":1,"D_EP":0,"D_PB":0,"D_VPP":0,"D_SP":0,"D_SDOC":0,"D_EK":0}}),
        // };

    //     $.ajax(settings).done(function (response) {
    //         console.log(response);
    //     });
    //
    // })
})

$.fn.justtext = function() {
    return $(this)
    .clone()
    .children()
    .remove()
    .end()
    .text();
};

/**
 * @param {string} direction The string
 */

function navigate(direction) {
    let currentSelection = 0;
    if ($('#listCity').size() == 0) {
        currentSelection = -1;
    }
    if(direction == 'up' && currentSelection != -1) {
        if (currentSelection != 0) {
            currentSelection--;
        }
    } else if (direction == 'down') {
        if (currentSelection != $('#listCity').size() - 1 ) {
            currentSelection++;
        }
    }
    setSelected(currentSelection);
}

function setSelected(menuItem) {
    $('#listCity li').removeClass(":hover");
    $("#listCity li").eq(menuItem).addClass(':hover').addClass('itemhover');

}

function getAttributDiv(event) {
    let target = $(event.target);

    if (target.is('span')) {
        let div = $(target).parent('div');
        let id = $(div).data('id');
        let text = $(div).justtext();

        $('#destination_id').attr('data-city-id', id).val(text);
        $('#listCity').addClass('d-none');

    } else if (target.is('div')) {
        let id = $(event.target).data('id');
        let text = $(event.target).justtext();

        $('#destination_id').attr('data-city-id', id).val(text);
        $('#listCity').addClass('d-none');

    }

}
