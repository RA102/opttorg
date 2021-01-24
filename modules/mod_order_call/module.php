<?php

function mod_order_call($module_id, $cfg)
{

    cmsPage::initTemplate('modules', 'mod_order_call')->
        display('mod_order_call.tpl');

    return true;
}