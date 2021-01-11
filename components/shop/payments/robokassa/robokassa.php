<?php

class ps_robokassa extends shopPaymentSystem{

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

//        $currency_kurs  = $this->config['currency'][$currency];
//        $this->order['summ']  = round($this->order['summ']/$currency_kurs, 2);
//
//        $signature = $this->config['sMerchantLogin']['value'] . ':' .
//                     $this->order['summ'] . ':' .
//                     $this->order['id'] . ':' .
//                     $this->config['sMerchantPass1']['value'];
//
//        $this->order['secret_key'] = md5($signature);

        $mrh_login = "Sanmarket.kz";
        $mrh_pass1 = "DBOVf2w1XwBBGsxSF680";
        $inv_id = $order['id'];
        $inv_desc = $order['description'];
        $out_summ = $order['summ'];
        $IsTest = 1;
        $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");

        ob_start();

        include('form.php');

        return ob_get_clean();

    }

/* ========================================================================== */
/* ========================================================================== */

    private function preRequest($model) {

        $inCore         = cmsCore::getInstance();

        $out_summ       = $inCore->request('OutSum', 'str');
        $out_id         = $inCore->request('InvId', 'int');
        $out_signature  = $inCore->request('SignatureValue', 'str');

        // Проверяем, не произошла ли подмена суммы
        $currency_kurs    = $this->config['currency']['RUR'];
        $currency_price   = ($currency_kurs > 1 ? round($this->order['summ']/$currency_kurs, 2) : round($this->order['summ']*$currency_kurs, 2));

        if ($currency_price != $out_summ) { return "ERR1: НЕВЕРНАЯ СУММА ЗАКАЗА"; }

        // Проверяем, не произошла ли подмена номера заказа
        if ($this->order['id'] != $out_id) { return "ERR2: НЕВЕРНЫЙ НОМЕР ЗАКАЗА"; }

        // Проверяем сигнатуру
        $signature = $out_summ . ':' .
                     $this->order['id'] . ':' .
                     $this->config['sMerchantPass2']['value'];

        if(strtoupper(md5($signature)) != $out_signature){ return "ERR3: КОНТРОЛЬНЫЕ СУММЫ НЕ СОВПАЛИ"; }

        // Фиксируем оплату заказа
        $model->setOrderStatus($this->order['id'], $this->order['secret_key'], 2);

        // Очищаем корзину
        $model->clearCart($client_sess_id);

        return "OK{$out_id}";

    }

/* ========================================================================== */
/* ========================================================================== */

    public function processPayment($model) {
               
        return iconv('cp1251', 'utf-8', $this->preRequest($model));

    }

/* ========================================================================== */
/* ========================================================================== */

}
