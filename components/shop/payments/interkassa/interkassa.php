<?php

class ps_interkassa extends shopPaymentSystem{

/* ========================================================================== */
/* ========================================================================== */

    /**
     * Получает всю информацию о заказе в массиве $order
     * и сохраняет внутри класса
     * @param array $order
     */
    public function __construct($order, $config){

        parent::__construct($order);

        $this->order    = $order;
        $this->config   = $config;

    }

/* ========================================================================== */
/* ========================================================================== */

    /**
     * Генерирует и возвращает код формы для отправки в платежную систему
     */
    public function getHtmlForm($order, $currency){

        global $_LANG;

        $currency_kurs  = $this->config['currency'][$currency];
        $this->summ  = round($this->order['summ']/$currency_kurs, 2);

        $this->order['secret_key'] = md5($order['id'].time().rand(0,9999));

        ob_start();

        include('form.php');

        return ob_get_clean();

    }

/* ========================================================================== */
/* ========================================================================== */

    private function preRequest($model) {

        $inCore         = cmsCore::getInstance();

        $out_shop_id    = $inCore->request('ik_shop_id', 'str');
        $out_summ       = $inCore->request('ik_payment_amount', 'str');
        $out_id         = $inCore->request('ik_payment_id', 'int');
        $out_signature  = $inCore->request('ik_sign_hash', 'str');
        $out_psys_alias = $inCore->request('ik_paysystem_alias', 'str', '');
        $out_baggage    = $inCore->request('ik_baggage_fields', 'str', '');
        $out_status     = $inCore->request('ik_payment_state', 'str', 'fail');
        $out_trans_id   = $inCore->request('ik_trans_id', 'str', '');
        $out_curr_exch  = $inCore->request('ik_currency_exch', 'str', '');
        $out_fees_payer = $inCore->request('ik_fees_payer', 'str', '0');

        if ($out_status != 'success') { return 'ERR: ПЛАТЕЖ НЕ ВЫПОЛНЕН';  }

        // Проверяем, не произошла ли подмена суммы
        $currency_kurs    = $this->config['currency']['RUR'];
        $currency_price   = ($currency_kurs > 1 ? round($this->order['summ']/$currency_kurs, 2) : round($this->order['summ']*$currency_kurs, 2));

        // Проверяем магазин
        if ($this->config['ik_shop_id']['value'] != $out_shop_id) {
			return "ERR0: НЕВЕРНЫЙ ИДЕНТИФИКАТОР МАГАЗИНА";
		}

        // Проверяем сумму заказа
        if ($currency_price != $out_summ) {
			return "ERR1: НЕВЕРНАЯ СУММА ЗАКАЗА";
		}

        // Проверяем, не произошла ли подмена номера заказа
        if ($this->order['id'] != $out_id) {
			return "ERR2: НЕВЕРНЫЙ НОМЕР ЗАКАЗА";
		}

        // Проверяем сигнатуру
        $signature = $out_shop_id.':'.
                     $out_summ.':'.
                     $out_id.':'.
                     $out_psys_alias.':'.
                     $out_baggage.':'.
                     $out_status.':'.
                     $out_trans_id.':'.
                     $out_curr_exch.':'.
                     $out_fees_payer.':'.
                     trim($this->config['ik_secret_key']['value']);

        $signature_md5 = strtoupper(md5($signature));

        if($signature_md5 != $out_signature){

			return "ERR3: КОНТРОЛЬНЫЕ СУММЫ НЕ СОВПАЛИ";

		}

        // Фиксируем оплату заказа
        $model->setOrderStatus($this->order['id'], $this->order['secret_key'], 2);

        $model->clearCart(session_id());

        return;

    }

/* ========================================================================== */
/* ========================================================================== */

    public function processPayment($model) {

        return iconv('cp1251', 'utf-8', $this->preRequest($model));

    }

/* ========================================================================== */
/* ========================================================================== */

}
