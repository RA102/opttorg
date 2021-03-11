$(document).ready(function(event) {
    $('tr[name*="addPartItem"]').on('click', function(event) {
        const rowTable = '<tr>' +
            '<td><input name="partId[]" type="hidden" value="">' +
            '<input name="titlePart[]" type="text" value= ""/>' +
            '</td>' +
            '<td>' +
            '<input name="widthItem[]" type="number" value=""/>' +
            '</td>' +
            '<td>' +
            '<input name="heightItem[]" type="number" value=""/>' +
            '</td>' +
            '<td>' +
            '<input name="depthItem[]" type="number" value=""/>' +
            '</td>' +
            '<td>' +
            '<input name="weightItem[]" type="number" value=""/>' +
            '</td>' +
            '<td>' +
            '<img class="buttonRemovePart img-fluid" src="images/actions/delete.gif" alt="remove" data-id="">' +
            '</td>' +
            '</tr>';

        $(this).before(rowTable);

    });

    // TODO создание строки в таблице по кнопку +

    // document.addEventListener('keydown', function(event) {
    //     console.log($('.params-item > tr:last'));
    // });

    $('.buttonRemovePart').on('click', function (event) {

        let eraseParam = confirm('Удалить');
        let paramId = $(this).data('id');
        let parentTd = $(this).parent();
        let tr = $(parentTd).parent();

        console.log(paramId);

        if (eraseParam) {
            if (paramId !== '') {
                $.ajax({
                    url: 'http://sanmarket.loc/admin/index.php?view=components&do=config&id=28&opt=remove_param' + '&param_id=' + paramId,
                    type: 'POST',
                    success: function(data, textStatus, jqXHR) {
                        if (textStatus == 'success') {
                            $(tr).remove();
                        }
                    },

                })
            }
        }

    })

})

