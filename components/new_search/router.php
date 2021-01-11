<?php

function routes_new_search(){

    $routes[] = array(
        '_uri'      => '/^new-search',
        'do'        => 'search',
//        1           => 'city_id'
    );

    return $routes;
}
