<?php

function routes_shop()
{

    $routes[] = array('_uri' => '/^shop\/addtocart$/i', 'do' => 'add_to_cart');

    $routes[] = array('_uri' => '/^shop\/download\/([0-9]+)\/([0-9]+)$/i', 'do' => 'download_char', 1 => 'item_id', 2 => 'char_id');

    $routes[] = array('_uri' => '/^shop\/get\-payment\/(.+)$/i', 'do' => 'process_payment', 1 => 'psys_id');

    $routes[] = array('_uri' => '/^shop\/order\-success.html$/i', 'do' => 'order_success');

    $routes[] = array('_uri' => '/^shop\/order\-fail.html$/i', 'do' => 'order_fail');

    $routes[] = array('_uri' => '/^shop\/order\-accept.html$/i', 'do' => 'order_accept');

    $routes[] = array('_uri' => '/^shop\/rate$/i', 'do' => 'rate_item');

    $routes[] = array('_uri' => '/^shop\/compare.html$/i', 'do' => 'compare');

    $routes[] = array('_uri' => '/^shop\/compare\/remove\/([0-9]+)$/i', 'do' => 'compare_remove', 1 => 'item_id');

    $routes[] = array('_uri' => '/^shop\/compare\/([0-9]+)$/i', 'do' => 'compare', 1 => 'item_id');

    $routes[] = array('_uri' => '/^shop\/export\/market\.yml$/i', 'do' => 'export_yml');

    $routes[] = array('_uri' => '/^shop\/vendors.html$/i', 'do' => 'vendors');

    $routes[] = array('_uri' => '/^shop\/list\-cities$/i', 'do' => 'list_cities');

    $routes[] = array('_uri' => '/^shop\/vendors\/([0-9]+)$/i', 'do' => 'view_vendor', 1 => 'vendor_id');

    $routes[] = array('_uri' => '/^shop\/vendors\/([0-9]+)\/page\-([0-9]+)$/i', 'do' => 'view_vendor', 1 => 'vendor_id', 2 => 'page');

    $routes[] = array('_uri' => '/^shop\/cart.html$/i', 'do' => 'view_cart');

    $routes[] = array('_uri' => '/^shop\/order.html$/i', 'do' => 'view_order');

    $routes[] = array('_uri' => '/^shop\/customer\-form.html$/i', 'do' => 'customer_data');

    $routes[] = array('_uri' => '/^shop\/([0-9]+)\/order.html$/i', 'do' => 'view_order', 1 => 'order_id');

    $routes[] = array('_uri' => '/^shop\/payment.html$/i', 'do' => 'payment');

    $routes[] = array('_uri' => '/^shop\/payment\/sberbank.html$/i', 'do' => 'sberbank');

    $routes[] = array('_uri' => '/^shop\/payment\/bill.html$/i', 'do' => 'beznal');

    $routes[] = array('_uri' => '/^shop\/payment\/balance\/([0-9]+)$/i', 'do' => 'balance', 1 => 'order_id');

    $routes[] = ['_uri' => '/^shop\/payment\-success$/i', 'do' => 'payment-success'];

    $routes[] = array('_uri' => '/^shop\/deletefromcart$/i', 'do' => 'delete_from_cart');

    $routes[] = array('_uri' => '/^shop\/deletefromcart\/([0-9]+)$/i', 'do' => 'delete_from_cart', 1 => 'delete_from_cart_item_id');

    $routes[] = array('_uri' => '/^shop\/get\/([a-zA-Z0-9]+)$/i', 'do' => 'download', 1 => 'link_key');

    $routes[] = array('_uri' => '/^shop\/sort\/(price|id|title|ordering)\/(asc|desc)$/i', 'do' => 'set_sort', 1 => 'orderby', 2 => 'orderto');

    $routes[] = array('_uri' => '/^shop\/(.+).html$/i', 'do' => 'item', 1 => 'seolink');

    $routes[] = array('_uri' => '/^shop\/(.+)\/page\-([0-9]+)$/i', 'do' => 'view', 1 => 'seolink', 2 => 'page');

    $routes[] = array('_uri' => '/^shop\/(.+)\/page\-([0-9]+)\/(.*)$/i', 'do' => 'view', 1 => 'seolink', 2 => 'page', 3 => 'filter_str');

    $routes[] = array('_uri' => '/^shop\/(.+)\/all$/i', 'do' => 'view', 1 => 'seolink', 'all' => 1);

    $routes[] = array('_uri' => '/^shop\/(.+)$/i', 'do' => 'view', 1 => 'seolink');

    return $routes;

}

