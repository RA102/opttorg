<?php

class p_shop_orders extends cmsPlugin {

// ==================================================================== //

    public function __construct(){
        
        parent::__construct();

        // Информация о плагине

        $this->info['plugin']           = 'p_shop_orders';
        $this->info['title']            = 'InstantShop - Мои заказы';
        $this->info['description']      = 'Добавляет вкладку "Мои заказы" в профили всех пользователей';
        $this->info['author']           = 'InstantSoft';
        $this->info['version']          = '1.0';

        $this->info['tab']              = 'Мои заказы'; //-- Заголовок закладки в профиле

        // Настройки по-умолчанию
//        $this->config[''] = 10;

        // События, которые будут отлавливаться плагином

        $this->events[]                 = 'USER_PROFILE';

    }

// ==================================================================== //

    /**
     * Процедура установки плагина
     * @return bool
     */
    public function install(){

        return parent::install();

    }

// ==================================================================== //

    /**
     * Процедура обновления плагина
     * @return bool
     */
    public function upgrade(){

        return parent::upgrade();

    }

// ==================================================================== //

    /**
     * Обработка событий
     * @param string $event
     * @param array $user
     * @return html
     */
    public function execute($event, $user){

        parent::execute();

        $inCore = cmsCore::getInstance();
        $inUser = cmsUser::getInstance();

        if ($inUser->id != $user['id'] && !$inUser->is_admin) { return false; }
        
        $inCore->loadModel('shop');
        $model = new cms_model_shop();
        
        $cfg = $model->getConfig();

        $model->where('user_id='.$user['id']);        
        $model->orderBy('date_created', 'desc');
        $model->limitIs(0, 5);

        $orders = $model->getOrders();

        ob_start();

        $status = array('1'=>'Не оплачен', '2'=>'Оплачен, в обработке', '3'=>'Закрыт');

        $smarty= cmsPage::initTemplate('plugins', 'p_shop_orders.tpl');
        $smarty->assign('cfg', $cfg);
        $smarty->assign('orders', $orders);
        $smarty->assign('status', $status);
        $smarty->display('p_shop_orders.tpl');

        $html = ob_get_clean();

        return $html;

    }

// ==================================================================== //

}
