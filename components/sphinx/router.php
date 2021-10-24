<?php

function routes_sphinx(){

    $routes[] = array(
        '_uri'  => '/^sphinx\/tag\/(.+)\/page([0-9]+).html$/i',
        'do'    => 'tag',
        1       => 'query',
        2       => 'page'
    );

    $routes[] = array(
        '_uri'  => '/^sphinx\/tag\/(.+)$/i',
        'do'    => 'tag',
        1       => 'query'
    );

    $routes[] = array(
        '_uri' => '/^sphinx\/words\/(.+)$/i',
        'do' => 'words',
        1 => 'value'
    );

    return $routes;

}


