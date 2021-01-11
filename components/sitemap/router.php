<?php
function routes_sitemap(){
    $routes[] = array(
        '_uri'	=> '/^sitemap$/i',
        'do'	=> 'index'
    );
    return $routes;
}
?>
