<?php

class ps_webmoney extends shopPaymentSystem{

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

        if ($currency == 'WMZ'){
            $this->config['LMI_PAYEE_PURSE']['value'] = $this->config['LMI_PAYEE_PURSE_Z']['value'];
        }
        if ($currency == 'WMR'){
            $this->config['LMI_PAYEE_PURSE']['value'] = $this->config['LMI_PAYEE_PURSE_R']['value'];
        }
        if ($currency == 'WME'){
            $this->config['LMI_PAYEE_PURSE']['value'] = $this->config['LMI_PAYEE_PURSE_E']['value'];
        }
        if ($currency == 'WMU'){
            $this->config['LMI_PAYEE_PURSE']['value'] = $this->config['LMI_PAYEE_PURSE_U']['value'];
        }

        $currency_kurs  = $this->config['currency'][$currency];
        $this->summ     = round($this->order['summ']/$currency_kurs, 2);

        ob_start();

        include('form.php');

        return ob_get_clean();

    }

/* ========================================================================== */
/* ========================================================================== */

    private function preRequest($model) {

        $inCore = cmsCore::getInstance();

        // Проверяем, не произошла ли подмена валюты

        $currency = $inCore->request('currency', 'str', '');
        if (!isset($this->config['currency'][$currency])) { return "ERR: НЕВЕРНЫЙ ТИП ВАЛЮТЫ"; }

        // Проверяем, не произошла ли подмена суммы

        $currency_kurs    = $this->config['currency'][$currency];
        $currency_price   = round($this->order['summ']/$currency_kurs, 2);

        if ($currency_price != $_POST['LMI_PAYMENT_AMOUNT']) { return "ERR: НЕВЕРНАЯ СУММА ЗАКАЗА"; }

        // Проверяем, не произошла ли подмена кошелька

        if ($currency == 'WMZ'){ $this->config['LMI_PAYEE_PURSE']['value'] = $this->config['LMI_PAYEE_PURSE_Z']['value']; }
        if ($currency == 'WMR'){ $this->config['LMI_PAYEE_PURSE']['value'] = $this->config['LMI_PAYEE_PURSE_R']['value']; }
        if ($currency == 'WME'){ $this->config['LMI_PAYEE_PURSE']['value'] = $this->config['LMI_PAYEE_PURSE_E']['value']; }
        if ($currency == 'WMU'){ $this->config['LMI_PAYEE_PURSE']['value'] = $this->config['LMI_PAYEE_PURSE_U']['value']; }

        if(trim($_POST['LMI_PAYEE_PURSE']) != trim($this->config['LMI_PAYEE_PURSE']['value'])) {
            return "ERR: НЕВЕРНЫЙ КОШЕЛЕК ПОЛУЧАТЕЛЯ ".$_POST['LMI_PAYEE_PURSE'];
        }

        return "YES";

    }

/* ========================================================================== */
/* ========================================================================== */

    private function makePayment($model){

        $inCore = cmsCore::getInstance();

        $secret_key = $this->config['SECRET_KEY']['value'];

        $client_sess_id = $inCore->request('client_sess_id', 'str', '');

        // Склеиваем строку параметров
        $common_string = $_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].
                         $_POST['LMI_MODE'].$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].
                         $_POST['LMI_SYS_TRANS_DATE'].$secret_key.$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM'];

        // Шифруем полученную строку в sha и переводим ее в верхний регистр
        $hash = strtoupper(hash('sha256', $common_string));

        // Прерываем работу скрипта, если контрольные суммы не совпадают
        if($hash!=$_POST['LMI_HASH']) return 'ERR: Контрольные суммы не совпали';

        // Фиксируем оплату заказа
        $model->setOrderStatus($this->order['id'], $this->order['secret_key'], 2);

        // Очищаем корзину
        $model->clearCart($client_sess_id);

        return;

    }

/* ========================================================================== */
/* ========================================================================== */

    public function processPayment($model) {
               
        IF($_POST['LMI_PREREQUEST']==1) {

            // ПРЕДВАРИТЕЛЬНЫЙ ЗАПРОС
            return $this->preRequest($model);

        } ELSE {

            // ОПОВЕЩЕНИЕ О ПЛАТЕЖЕ
            return $this->makePayment($model);

        }

        return true;

    }

/* ========================================================================== */
/* ========================================================================== */

}

?>