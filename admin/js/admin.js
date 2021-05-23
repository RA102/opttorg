$(document).ready(function(){
	$('#hmenu ul li').hover(
		function() {
			$(this).find('ul:first').show();
			$(this).addClass("hilite");
		},
		function() {            
			$(this).find('ul:first').hide();
			$(this).removeClass("hilite");						
		}
	);    
	//$('#hmenu li:has(ul)').find('a:first').append(' &raquo;');
	$('#hmenu ul li ul li').find('ul:first').addClass("fleft");
	
	$('.jclock').jclock();
	
	$('input[type=button]').addClass('button');
	$('input[type=submit]').addClass('button');

    $('input[name=published][type=checkbox]').click(function(){

        var checked = $(this).prop('checked');

        if (checked){
            $('label[for=published] strong').css('color', 'green');
        } else {
            $('label[for=published] strong').css('color', 'red');
        }

    });

    var checked = $('input[name=published][type=checkbox]').prop('checked');

    if (checked){
        $('label[for=published] strong').css('color', 'green');
    } else {
        $('label[for=published] strong').css('color', 'red');
    }

    $(".add_mod").on('click', function (e) {
        console.log('ok');
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    });

    $('#btnCheckAvailableInStock').on('click', function(event) {
      event.stopPropagation();
      let artNumberItem = $('#add_art_no').val();
      let idComponent = $('input[name=id]').val();
      $.ajax({
        url: 'index.php?view=components&do=config&id=' + idComponent + '&opt=check-available-in-stock&art_no='+artNumberItem,
        success: function (data) {
          console.log(data.data);
          if (data.data.qty > 1){
            $('#hintInStock').text('Есть в наличии: ' + data.data.qty);
          } else if (data.data.qty_from_vendor > 2) {
            $('#hintInStock').text('На заказ: ' + data.data.qty_from_vendor);
          } else {
            $('#hintInStock').text('Нет в наличии');
          }
        },
        error: function (error) {
          console.log(error);
        },
      })
    });

    $('input[name="sellToOrder"]').on('change', function(event) {
        if($(this).val() == 0) {
            $('.time-delivery-wrapper').toggle('hidden');
        } else if ($(this).val() == 1) {
            $('.time-delivery-wrapper').toggle('hidden');
        }
    });

});