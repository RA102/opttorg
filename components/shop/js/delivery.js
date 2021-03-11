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
