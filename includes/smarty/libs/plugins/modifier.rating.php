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
function smarty_modifier_rating($rating){
	if ($rating==0) {
		$html = '<span style="color:gray;">0</span>';
	} elseif ($rating>0){
		$html = '<span style="color:green">+'.$rating.'</span>';
	} else {
		$html = '<span style="color:red">'.$rating.'</span>';
	}
	return $html;
}