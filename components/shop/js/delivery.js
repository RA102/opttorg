$(document).ready(function() {
    $('#destination_id').on('input', function() {
        $.ajax({
            url: 'https://api.exline.systems/public/v1/regions/destination?title=' + $('#destination_id').val(),
            type: 'GET',
            success: function(data) {
                $('#list-city').empty();
                // let country = 'Казахстан';
                // $("#myList li").filter(function() {
                //     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                // });
                data.regions.forEach(function(item) {
                    $('#list-city').append('<option value="' + item.id + '"' + '>' + item.title + '(' + item.cached_path +')'+ '</option>');
                    $('#list-city').removeClass('d-none');
                });

            }
        })
    });

    $('#list-city').on('click', function(event) {
        let inputValue = $('#list-city option:selected').text();
        let dataId = $('#list-city option:selected').val();
        $('#destination_id').val(inputValue);
        $('#destination_id').attr('data-id', dataId);
        $('#list-city').addClass('d-none');
    });

    $('#btn-calculate-delivery').on('click', function(event) {
        let origin_id = $('.origin_id').val();
        let destination_id = $('#destination_id').data('id');
        let methodDelivery = $('#methodDelivery').val();
        let sumDelivery = 0;
        let sum = 0;

        let itemsParams = $('div#params').children('input');//$("input[name~='itemParam']"))

        itemsParams.each(function(index, item) {
            let width = $(item).data('width');
            let height = $(item).data('height');
            let depth = $(item).data('depth');
            let weight = $(item).data('weight');


            $.ajax({
                url: 'https://api.exline.systems/public/v1/calculate?' +
                    'origin_id=27' +
                    '&destination_id=' + destination_id +
                    '&wight=' + width +
                    '&height=' + height +
                    '&depth=' + depth +
                    '&weight=' + weight +
                    '&service=' + methodDelivery,
                type: 'GET',
                success: function(data, textStatus, jqXHR) {
                    console.log(data);
                    sum = +(data.calculation.price) + +(data.calculation.declared_value_fee) + +(data.calculation.fuel_surplus);
                    // if (textStatus == 'success') {
                    //     $('#costDelivery').append($('<li>', {text: sum}));
                    // }

                    sumDelivery += sum;
                    $('#sumDelivery').text(sumDelivery);
                    console.log(sum, sumDelivery);
                },
            })
            console.log(sumDelivery);

        })
        $('.close').trigger('click');


    })

})
