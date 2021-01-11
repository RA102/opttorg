<?php

class ps_bill extends shopPaymentSystem{

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

        ob_start();

        $currency_kurs  = $this->config['currency'][$currency];
        $this->summ     = round($this->order['summ']/$currency_kurs, 2);

        include('form.php');

        return ob_get_clean();

    }

/* ========================================================================== */
/* ========================================================================== */

    public function processPayment($model) {

        $inCore = cmsCore::getInstance();

        // Помещаем заказ в обработку
        $model->setOrderStatus($this->order['id'], $this->order['secret_key'], 1);
        $this->order['status'] = 1;
        $model->sendOrder($this->order, 'accept', $inCore->loadComponentConfig('shop'));

        $inCore->redirect('/shop/order-accept.html');

        return true;

    }

/* ========================================================================== */
/* ========================================================================== */

}

?>