// кнопка авторизации
$(document).ready(function () {
	$('#submit-btn-login').on('click', function (event) {
		event.preventDefault();

		$('#error-auth').text('');
		$('.error-login').text('');
		$('.error-password').text('');

		$('.login_form #login_field').focus()
		if($('#login_field').val() == '') {
			$('.error-login').text('Заполните поле логина');
		} else if ($('#pass_field').val() == '') {
			$('.error-password').text('Заполните поле пароля');
		} else {
			let form = $('#login-form');
			let formData = form.serialize();

			$.ajax({
				url: '/registration/login',
				type: 'POST',
				data: formData,
				success: function (data) {
					if (data.error) {
						$('#error-auth').text(data.error);
						$('#pass_field').val('');
					} else {
						$('#exampleModal').modal('hide');
						window.location.href = data.data;
					}
				}
			});
		}
	});

	$('#registration').on('click', function (event) {
		event.preventDefault();
		$.ajax({
			url: '/registration',
			success: function (data) {
				$('#modal-body-authorization').html(data.html);
			}

		})
	});
})





function checkLogin() {
	userlogin = $("#logininput").val();
    $("#logincheck").load("/core/ajax/registration.php", { opt: "checklogin", data:userlogin });
}

function checkPasswords() {
	var pass1 = $("#pass1input").val();
	var pass2 = $("#pass2input").val();
	if (pass1 != pass2) {
		$('#passcheck').html('<span style="color:red">'+LANG_WRONG_PASS+'</span>');
	}
}
