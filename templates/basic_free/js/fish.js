$(document).ready(function (){
    const arrCatch = ['circle-stock', 'shoe', 'fish'];
    const item = [];

    $('#btn-start').on('click', function () {
        let it = item.pop();
        if (it != '') {
            $(`#${it}`).remove();

        }

        $('#rod').css('top', '-30px');

        setTimeout(function () {
            item.push(arrCatch.pop());
            $('#rod').css('top', '-170px');
            $(`#${item[0]}`).css({'transition': 'bottom 2s linear', 'bottom': '220px'});

            if (item[0] == 'fish') {
                $('#text').text('Попробуйте еще раз');
            } else if (item[0] == 'shoe') {
                $('#text').text('Последняя попытка');
            } else if(item[0] == 'circle-stock') {
                $('#text').text('Вам открыт доступ к специальному разделу со скидками');
            }
        }, 2000);



    });
})

