<?php

class ps_rbk extends shopPaymentSystem{

    public function __construct($order, $config){

        parent::__construct($order);

        $this->order    = $order;
        $this->config   = $config;

    }

    public function getHtmlForm($order, $currency){

        global $_LANG;
        $inCore = cmsCore::getInstance();		

        ob_start();

        include('form.php');

        return ob_get_clean();

    }

    public function processPayment($model) {
			
        $inCore = cmsCore::getInstance();

        $cfg = $model->getConfig();

		$recipientAmount = $inCore->request('recipientAmount', 'str', '');
		$recipientCurrency = $inCore->request('recipientCurrency', 'str', '');
		$paymentStatus = $inCore->request('paymentStatus', 'str', '');
		$hash = $inCore->request('hash', 'str', '');		

		$crc = $inCore->request('eshopId', 'str', '') . "::" .
			   $inCore->request('orderId', 'str', '') . "::" .
			   $inCore->request('serviceName', 'str', '') . "::" .
			   $inCore->request('eshopAccount', 'str', '') . "::" .
			   $recipientAmount . "::" .
			   $recipientCurrency . "::" .
			   $paymentStatus . "::" .
			   $inCore->request('userName', 'str', '') . "::" .
			   $inCore->request('userEmail', 'str', '') . "::" .
			   $inCore->request('paymentData', 'str', '') . "::" .
			   $this->config['RBK_SECRET_KEY']['value'];

		if ($paymentStatus != 5) return "ERR: НЕВЕРНЫЙ СТАТУС ОПЛАТЫ";

		if ($recipientCurrency != 'RUR') return "ERR: НЕВЕРНЫЙ ТИП ВАЛЮТЫ";
		
		if ($recipientAmount != number_format($this->order['summ'], 2, '.', '')) return "ERR: НЕВЕРНАЯ СУММА ЗАКАЗА";

		if ($hash != md5($crc))  return 'ERR: КОНТРОЛЬНЫЕ СУММЫ НЕ СОВПАЛИ';
		
        $model->setOrderStatus($this->order['id'], $this->order['secret_key'], 2);
        $this->order['status'] = 2;
        $model->sendOrder($this->order, 'success', $cfg);

        $model->clearCart(session_id());

        return true;

    }

}
