function addToCart(id){

    $('#add_to_cart_'+id+' .add').hide();
    $('#add_to_cart_'+id+' .qty').show();
    $('#add_to_cart_'+id+' .qty .amount').focus().select();

}

function recountSumm(){

    let items_count = $('.cart_table .trr').length;
    let count = 0;
    let price = 0;
    let total = 0;
    let old_total = 0;

    let old_summ = Number($('.total_summ_price .value').html());
    let summ = 0;

    for(let i=0; i<items_count; i++) {
        let tmpCountItem = 0;

        // if ($('.cart_table .media').eq(i).find('input').length) {
        //     count = Number($('.cart_table .media').eq(i).find('input').val());
        // } else {
        //     count = Number($('.cart_table .media').eq(i).find('select').val());
        // }

        tmpCountItem = $('.cart_table .input-item--cart---quantity').eq(i).find('input').val();


        if (count<1 || !Number(count)) {
            count = 1;
            $('.cart_table .input-item--cart---quantity').eq(i).find('input').val(count);
            $('.cart_table .input-item--cart---quantity').eq(i).find('select').val(count);
        }


        old_total   = Number($('.cart_table .trr').eq(i).find('.totalprice .value').html());
        price       = Number($('.cart_table .trr').eq(i).find('.price .new-price').html());

        if (price){
            total = price * count;
        
            if (old_total != total) {
                $('.cart_table .trr').eq(i).find('.totalprice .value').html(total);
                $('.cart_table .trr').eq(i).find('.totalprice .value').fadeOut().fadeIn();
            }
        } else {
            price = total;
        }

        summ += total;

        count += tmpCountItem;
    }

    $('.cart-right--div .countItems').text(tmpCountItem);



    if (summ != old_summ){
        calculateDiscount(summ);
    }

}