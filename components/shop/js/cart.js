function addToCart(id){

    $('#add_to_cart_'+id+' .add').hide();
    $('#add_to_cart_'+id+' .qty').show();
    $('#add_to_cart_'+id+' .qty .amount').focus().select();

}

function recountSumm(){

    let itemsCount = $('.cart_table .media').length;
    let count = 0;
    let price = 0;
    let discount = 0;
    let amountWithDiscount = 0;
    let amountWithoutDiscount = 0;

    for(let i=0; i<itemsCount; i++) {
        let specificCountProduct = 0;
        let oldPrice = 0;

        if ($('.cart_table .media').eq(i).find('input').length) {
            specificCountProduct = Number($('.cart_table .media').eq(i).find('input').val());
        } else {
            specificCountProduct = Number($('.cart_table .media').eq(i).find('select').val());
        }

        //specificCountProduct = Number($('.cart_table .media').eq(i).find('input').val());


        if (specificCountProduct < 1 || !Number(specificCountProduct)) {
            specificCountProduct = 1;
            $('.cart_table .media').eq(i).find('input').val(specificCountProduct);
            $('.cart_table .media').eq(i).find('select').val(specificCountProduct);
        }

        price = Number($('.cart_table .trr').eq(i).find('.price .new-price').html());


        oldPrice = Number($('.cart_table .trr').eq(i).find('.cart-old--price').html()) ? Number($('.cart_table .trr').eq(i).find('.cart-old--price').html()) : 0;




        if (oldPrice) {
            amountWithoutDiscount += oldPrice * specificCountProduct;
            amountWithDiscount += price * specificCountProduct;
        } else {
            amountWithoutDiscount += price * specificCountProduct;
            amountWithDiscount += price * specificCountProduct;
        }




        //$('.cart_table .trr').eq(i).find('.totalprice .value').html(total);
        //$('.cart_table .trr').eq(i).find('.totalprice .value').fadeOut().fadeIn();



        count += specificCountProduct;

    }

    discount += amountWithoutDiscount - amountWithDiscount;

    $('.amountWithoutDiscount').html(amountWithoutDiscount);
    $('.amountWithoutDiscount').fadeOut().fadeIn();

    $('.discount').html(discount);
    $('.discount').fadeOut().fadeIn();

    $('.total_summ_price .value').html(amountWithDiscount);
    $('.total_summ_price .value').fadeOut().fadeIn();

    $('#countItems').text(count);
    $('#countItems').fadeOut().fadeIn();


}