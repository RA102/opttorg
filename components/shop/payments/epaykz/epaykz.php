<?php

use cmsTemplate;

class ps_epaykz extends shopPaymentSystem {

	private $invert = 1;
	private $ecode = 0;
	private $estatus;
	private $private_key;

/* ========================================================================== */
/* ========================================================================== */

	/**
	 * Получает всю информацию о заказе в массиве $order
	 * и сохраняет внутри класса
	 * @param array $order 
	 */
	public function __construct($order, $config) {

		parent::__construct($order);
		$this->order    = $order;
		$this->config   = $config;

	}

/* ========================================================================== */
/* ========================================================================== */

	/**
	 * Генерирует и возвращает код формы для отправки в платежную систему
	 */
	public function getHtmlForm($order, $currency) {
		global $_LANG;
		ob_start();
		include('form.php');
		return ob_get_clean();
	}

/* ========================================================================== */
/* ========================================================================== */

	public function processPayment($model) {
		// cmsTemplate::getInstance()->setLayout('admin');
		ob_start();
		echo "<pre>";
		var_dump($model);
		echo "</pre>";
		return ob_get_clean();
		// exit();

		// // $inCore = cmsCore::getInstance();

		// // // Помещаем заказ в обработку
		// // $model->setOrderStatus($this->order['id'], $this->order['secret_key'], 1);
		// // $this->order['status'] = 1;
		// // $model->sendOrder($this->order, 'accept', $inCore->loadComponentConfig('shop'));

		// // $inCore->redirect('/shop/order-accept.html');

		// return true;

	}

/* ========================================================================== */
/* ========================================================================== */

	public function processRequest($b64=true) {
		$config = array(
			'MERCHANT_CERTIFICATE_ID'   => $this->config['MERCHANT_CERTIFICATE_ID']['value'],
			'MERCHANT_NAME'             => $this->config['MERCHANT_NAME']['value'],
			'PRIVATE_KEY_FN'            => $this->config['PRIVATE_KEY_FN']['value'],
			'PRIVATE_KEY_PASS'          => $this->config['PRIVATE_KEY_PASS']['value'],
			'XML_TEMPLATE_FN'           => 'template.xml',
			'XML_COMMAND_TEMPLATE_FN'   => 'command_template.xml',
			'PUBLIC_KEY_FN'             => 'kkbca.pem',
			'MERCHANT_ID'               => $this->config['MERCHANT_ID']['value']
		);

		// целое: номер заказа - перекодируется в 6 значный формат с ведущими нулями
		$order_id = $this->order['id'];

		// строка: заданные шифры валют 840-USD, 398-Tenge
		$currency_code = $this->config['MERCHANT_CURRENCY_ID']['value'];

		// целое: общая сумма платежа
		$amount = $this->order['summ'];

		if (strlen($order_id) > 0) {
			if (is_numeric($order_id)) {
				if ($order_id > 0) {
					$order_id = sprintf("%06d", $order_id);
				}
				else { return "Null Order ID"; }
			}
			else { return "Order ID must be number"; }
		}
		else { return "Empty Order ID"; }

		if (strlen($currency_code) == 0) { return "Empty Currency code"; }
		if ($amount == 0) { return "Nothing to charge"; }
		if (strlen($config['PRIVATE_KEY_FN']) == 0) { return "Path for Private key not found"; }
		if (strlen($config['XML_TEMPLATE_FN']) == 0) { return "Path for Private key not found"; }

		$request = array(
			'MERCHANT_CERTIFICATE_ID' => $config['MERCHANT_CERTIFICATE_ID'],
			'MERCHANT_NAME' => $config['MERCHANT_NAME'],
			'ORDER_ID' => $order_id,
			'CURRENCY' => $currency_code,
			'MERCHANT_ID' => $config['MERCHANT_ID'],
			'AMOUNT' => $amount
		);

		if (!$this->loadPrivateKey($config['PRIVATE_KEY_FN'], $config['PRIVATE_KEY_PASS'])) {
			if ($this->ecode > 0) return $this->estatus;
		}

		$result = $this->processXML($config['XML_TEMPLATE_FN'], $request);
		if (strpos($result, "[RERROR]") > 0) {
			return "Error reading XML template.";
		}

		$xml = ''
			.'<document>'
				.$result
				.'<merchant_sign type="RSA">'
					.$this->sign64($result)
				.'</merchant_sign>'
			.'</document>'
		.'';

		if ($b64) {
			return base64_encode($xml);
		}
		return $xml;
	}

/* ========================================================================== */
/* ========================================================================== */

	private function loadPrivateKey($filename, $password = NULL) {
		$filename = $this->relativePath($filename);
		$this->ecode = 0;
		if (!is_file($filename)) {
			$this->ecode = 4;
			$this->estatus = "[KEY_FILE_NOT_FOUND]";
			return false;
		}
		$c = file_get_contents($filename);
		if (strlen(trim($password)) > 0) {
			$prvkey = openssl_get_privatekey($c, $password);
			$this->parseErrors(openssl_error_string());
		}
		else {
			$prvkey = openssl_get_privatekey($c);
			$this->parseErrors(openssl_error_string());
		}
		if(is_resource($prvkey)) {
			$this->private_key = $prvkey;
			return $c;
		}
		return false;
	}

/* ========================================================================== */
/* ========================================================================== */

	private function parseErrors($error) {
		/*
		error:0906D06C - Error reading Certificate. Verify Cert type.
		error:06065064 - Bad decrypt. Verify your Cert password or Cert type.
		error:0906A068 - Bad password read. Maybe empty password.
		*/
		if (strlen($error) >0 ) {
			if (strpos($error,"error:0906D06C") > 0) { $this->ecode = 1; $this->estatus = "Error reading Certificate. Verify Cert type."; }
			if (strpos($error,"error:06065064") > 0) { $this->ecode = 2; $this->estatus = "Bad decrypt. Verify your Cert password or Cert type."; }
			if (strpos($error,"error:0906A068") > 0) { $this->ecode = 3; $this->estatus = "Bad password read. Maybe empty password."; }
			if ($this->ecode = 0) { $this->ecode = 255; $this->estatus = $error; }
		}
	}

/* ========================================================================== */
/* ========================================================================== */

	private function processXML($filename, $reparray) {
		$filename = $this->relativePath($filename);
		if (is_file($filename)) {
			$content = file_get_contents($filename);
			foreach ($reparray as $key => $value) {
				$content = str_replace('['.$key.']', $value, $content);
			}
			return $content;
		}
		return "[ERROR]";
	}

/* ========================================================================== */
/* ========================================================================== */

	private function sign64($str) {
		return base64_encode($this->sign($str));
	}

/* ========================================================================== */
/* ========================================================================== */

	private function sign($str) {
		if ($this->private_key) {
			openssl_sign($str, $out, $this->private_key);
			if ($this->invert == 1) {
				$out = $this->reverse($out);
			}
			//openssl_free_key($this->private_key);
			return $out;
		}
	}

/* ========================================================================== */
/* ========================================================================== */

	private function reverse($str) {
		return strrev($str);
	}

/* ========================================================================== */
/* ========================================================================== */

	private function relativePath($filename) {
		return dirname(__FILE__) . DIRECTORY_SEPARATOR . $filename;
	}

/* ========================================================================== */
/* ========================================================================== */

}

