$(document).ready(function() {
    $('#city').on('input', function() {
        $.ajax({
            url: 'https://api.exline.systems/public/v1/regions/destination?title=' + $('#city').val(),
            type: 'GET',
            success: function(data) {
                $('#list-city').empty();
                console.log(data);
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
        $('#city').val(inputValue);
        $('#city').attr('data-id', dataId);
        $('#list-city').addClass('d-none');
    })

})
