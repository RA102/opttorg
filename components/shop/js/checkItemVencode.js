function checkVencode () {
    itemVencode = $('#ven_code').val();
    $.ajax({
        type: "POST",
        url: '/core/ajax/vencode.php',
        data: { opt: "check_ven_code", data: itemVencode },
        success: function (data) {
            $('#error_ven_code').html(data);
            if($('#span-error').hasClass('red-text')) {
                $('#add_mod').prop('disabled', true);
            } else {
                $('#add_mod').prop('disabled', false);
            }
        }
    })
}

