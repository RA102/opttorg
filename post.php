<?php

header('Content-Type: text/html; charset= utf-8');
		if ((isset($_POST['name'])) && (isset($_POST['phone']))) {

		$user = $_POST['name'];
		$user = htmlspecialchars($user);
		$user = urldecode($user);
		$user = trim($user);

		$phone = $_POST['phone'];
		$phone = htmlspecialchars($phone);
		$phone = urldecode($phone);
		$phone = trim($phone);

			$subject = 'Запрос с сайта';
			$message = '
			<p>От: '.$user.'</p>
			<p>Перезвонить: '.$phone.'</p>';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'To: <umg_content@mail.ru>' . "\r\n";
			$headers .= 'From: <admin@umgonline.kz>' . "\r\n";

        if(mail('umg_content@mail.ru', $subject, $message, $headers))
        {
            echo'<script>alert ("Спасибо, '.$user.'! Мы скоро свяжемся с Вами!");</script>';
            echo '<script type="text/javascript">
  location.replace("http://dietologyakovleva.kz");
</script>
';
        }
        else
        {
          echo'<script>alert ("Извините, произошла ошибка:()");</script>';
          echo '<script type="text/javascript">
location.replace("http://dietologyakovleva.kz");
</script>';
        }

    }
?>
<script type="text/javascript">
    function changeurl(){
        eval(self.location="http://kprb.umgroup.kz");
    }

    window.setTimeout("changeurl1();",3000);
</script>
