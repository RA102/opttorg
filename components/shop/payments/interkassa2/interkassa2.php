<?php

class ps_interkassa2 extends shopPaymentSystem{

/* ========================================================================== */
/* ========================================================================== */

    public function __construct($order, $config){

        parent::__construct($order);

        $this->order    = $order;
        $this->config   = $config;

    }

	public function log($str){
//        $filename = $_SERVER['DOCUMENT_ROOT'] . '/upload/log.txt';
//        $f = fopen($filename, 'a');
//        $str = date('[H:i] ') . $str . "\n";
//        fputs($f, $str);
//        fclose($f);
	}

/* ========================================================================== */
/* ========================================================================== */

    /**
     * Генерирует и возвращает код формы для отправки в платежную систему
     */
    public function getHtmlForm($order, $currency){

        global $_LANG;

        $currency_kurs  = $this->config['currency'][$currency];
        $this->order['summ']  = round($this->order['summ']/$currency_kurs, 2);

        $this->order['secret_key'] = md5($order['id'].time().rand(0,9999));

        ob_start();

        include('form.php');

        return ob_get_clean();

    }

/* ========================================================================== */
/* ========================================================================== */

    private function preRequest($model) {

        $inCore         = cmsCore::getInstance();

        $out_co_id      = $inCore->request('ik_co_id', 'str');
        $out_am         = $inCore->request('ik_am', 'str');
        $out_pm_no      = $inCore->request('ik_pm_no', 'int');
        $out_sign       = $inCore->request('ik_sign', 'str');
        $out_inv_st     = $inCore->request('ik_inv_st', 'str', '');

		$this->log("ik_co_id: {$out_co_id}");
		$this->log("ik_am: {$out_am}");
		$this->log("ik_pm_no: {$out_pm_no}");
		$this->log("ik_sign: {$out_sign}");
		$this->log("ik_inv_st: {$out_inv_st}");

        if ($out_inv_st != 'process' && $out_inv_st != 'success') {
			$this->log("ERR0: ПЛАТЕЖ НЕ ВЫПОЛНЕН: {$out_inv_st}");
			return 'ERR: ПЛАТЕЖ НЕ ВЫПОЛНЕН';
		}

        // Проверяем, не произошла ли подмена суммы
        $currency_kurs    = $this->config['currency']['RUR'];
        $currency_price   = ($currency_kurs > 1 ? round($this->order['summ']/$currency_kurs, 2) : round($this->order['summ']*$currency_kurs, 2));

        // Проверяем магазин
        if ($this->config['ik_co_id']['value'] != $out_co_id) {
            $this->log("ERR0: НЕВЕРНЫЙ ИДЕНТИФИКАТОР МАГАЗИНА");
			return "ERR0: НЕВЕРНЫЙ ИДЕНТИФИКАТОР МАГАЗИНА";
		}

        // Проверяем сумму заказа
        if ($currency_price != $out_am) {
            $this->log("ERR1: НЕВЕРНАЯ СУММА ЗАКАЗА");
			return "ERR1: НЕВЕРНАЯ СУММА ЗАКАЗА";
		}

        // Проверяем, не произошла ли подмена номера заказа
        if ($this->order['id'] != $out_pm_no) {
            $this->log("ERR2: НЕВЕРНЫЙ НОМЕР ЗАКАЗА");
			return "ERR2: НЕВЕРНЫЙ НОМЕР ЗАКАЗА";
		}

        $dataSet = array();

        foreach($_REQUEST as $key=>$val){
            if (mb_strpos($key, 'ik_')===0){
                $dataSet[$key] = $val;
            }
        }

		unset($dataSet['ik_sign']);

        ksort($dataSet, SORT_STRING);
        array_push($dataSet, trim($this->config['ik_secret_key']['value']));

		foreach($dataSet as $key=>$val){
			$this->log("dataSet[$key] = $val");
		}

        $signString = implode(':', $dataSet);
        $sign = base64_encode(md5($signString, true));

        // Проверяем сигнатуру
        if($sign != $out_sign){

            $log =  "ERR3: КОНТРОЛЬНЫЕ СУММЫ НЕ СОВПАЛИ" . "\n" .
                        "SIG: {$sign}" . "\n" .
                        "IK SIG: {$out_sign}" ;
            $this->log($log);
			return "ERR3: КОНТРОЛЬНЫЕ СУММЫ НЕ СОВПАЛИ";

		}

        $log =  "SIG: {$sign}" . "\n" .
                "IK SIG: {$out_sign}" ;

        $this->log($log);

        // Фиксируем оплату заказа
        $model->setOrderStatus($this->order['id'], $this->order['secret_key'], 2);

        return;

    }

/* ========================================================================== */
/* ========================================================================== */

    public function processPayment($model) {

 		$this->preRequest($model);

    }

/* ========================================================================== */
/* ========================================================================== */

}