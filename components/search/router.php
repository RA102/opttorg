<?php
/******************************************************************************/
//                                                                            //
//                           InstantCMS v1.10.6                               //
//                        http://www.instantcms.ru/                           //
//                                                                            //
//                   written by InstantCMS Team, 2007-2015                    //
//                produced by InstantSoft, (www.instantsoft.ru)               //
//                                                                            //
//                        LICENSED BY GNU/GPL v2                              //
//                                                                            //
/******************************************************************************/

    function routes_search(){

        $routes[] = array(
                            '_uri'  => '/^search\/tag\/(.+)\/page([0-9]+).html$/i',
                            'do'    => 'tag',
                            1       => 'query',
                            2       => 'page'
                         );

        $routes[] = array(
                            '_uri'  => '/^search\/tag\/(.+)$/i',
                            'do'    => 'tag',
                            1       => 'query'
                         );

        $routes[] = array(
            '_uri' => '/^search\/words\/(.+)$/i',
            'do' => 'words',
            1 => 'value'
        );

        $routes[] = array(
            '_uri' => '/^search\/words2\/(.+)$/i',
            'do' => 'words2',
            1 => 'value'
        );

        return $routes;

    }
