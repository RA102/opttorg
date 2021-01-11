function addToCart(id){

    $('#add_to_cart_'+id+' .add').hide();
    $('#add_to_cart_'+id+' .qty').show();
    $('#add_to_cart_'+id+' .qty .amount').focus().select();

}

function recountSumm(){

    var items_count = $('.cart_table .trr').length;
    var count = 0;
    var price = 0;
    var total = 0;
    var old_total = 0;

    var old_summ = Number($('.total_summ_price .value').html());
    var summ = 0;

    for(r=0; r<items_count; r++){

        if ($('.cart_table .trr').eq(r).find('input').length){
            count = Number($('.cart_table .trr').eq(r).find('input').val());
        } else {
            count = Number($('.cart_table .trr').eq(r).find('select').val());
        }

        if (count<1 || !Number(count)) {
            count = 1;
            $('.cart_table .trr').eq(r).find('input').val(count);
            $('.cart_table .trr').eq(r).find('select').val(count);
        }

        old_total   = Number($('.cart_table .trr').eq(r).find('.totalprice .value').html());
        price       = Number($('.cart_table .trr').eq(r).find('.price .value').html());

        if (price){
            total = price * count;
        
            if (old_total != total){
                $('.cart_table .trr').eq(r).find('.totalprice .value').html(total);
                $('.cart_table .trr').eq(r).find('.totalprice .value').fadeOut().fadeIn();
            }
        } else {
            price = total;
        }

        summ += total;

    }

    if (summ != old_summ){
        calculateDiscount(summ);
    }

}