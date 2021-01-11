<?php
/*********************************************************************************************/
//																							 //
//                              InstantCMS v1.6   (c) 2010 FREEWARE                          //
//	 					  http://www.instantcms.ru/, info@instantcms.ru                      //
//                                                                                           //
// 						    written by Vladimir E. Obukhov, 2007-2010                        //
//                                                                                           //
/*********************************************************************************************/

if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
	
function search_shop($query, $look){ //query sends here already prepared and secured!

        $inCore = cmsCore::getInstance();
        $inDB = cmsDatabase::getInstance();

        global $_LANG;

		//BUILD SQL QUERY
		$sql = "SELECT DISTINCT con.*, 
                       cat.title cat_title,
                       cat.seolink as cat_seolink
				FROM cms_shop_items con, cms_shop_cats cat
				WHERE MATCH(con.title, con.shortdesc, con.description) AGAINST ('$query' IN BOOLEAN MODE) AND con.category_id = cat.id AND con.published=1";

		//QUERY TO GET TOTAL RESULTS COUNT
		$result = $inDB->query($sql);
		$found= $inDB->num_rows($result);
		
		if ($found){
			while($item = $inDB->fetch_assoc($result)){
				//build params
                $inCore->loadLanguage('components/shop');
				$link       = "/shop/".$item['seolink'].".html";
				$place      = $_LANG['SHOP'];
				$placelink  = "/shop/".$item['cat_seolink'];
                $item['cat_title'] = mysqli_real_escape_string($item['cat_title']);
				//include item to search results
				//if (!dbRowsCount('cms_search', "session_id='".session_id()."' AND link='$link'")){				
					$sql = "INSERT INTO cms_search (`id`, `session_id`, `title`, `link`, `place`, `placelink`)
							VALUES ('', '".session_id()."', '".$item['title']."', '$link', '$place', '$placelink')";
					$inDB->query($sql);
			//	}
			}
		}

        $query = str_replace('+', '', $query);
        $query = str_replace(' ', '', $query);
        $query = str_replace('*', '%', $query);

		//BUILD SQL QUERY
		$sql = "SELECT cat.title cat_title,
                       cat.seolink as cat_seolink
				FROM cms_shop_cats cat
				WHERE cat.title LIKE '%{$query}%'";

		//QUERY TO GET TOTAL RESULTS COUNT
		$result = $inDB->query($sql);
		$found  = $inDB->num_rows($result);

		if ($found){
			while($item = $inDB->fetch_assoc($result)){
				//build params
                $inCore->loadLanguage('components/shop');
				$link       = "/shop/".$item['cat_seolink'];
				$place      = $_LANG['SHOP'];
				$placelink  = "/shop/".$item['cat_seolink'];
                $item['cat_title'] = mysqli_real_escape_string($item['cat_title']);
				//include item to search results
                $sql = "INSERT INTO cms_search (`id`, `session_id`, `title`, `link`, `place`, `placelink`)
                        VALUES ('', '".session_id()."', '".$item['cat_title']."', '$link', '$place', '$placelink')";
                $inDB->query($sql);
			}
		}
		
		return;
}


?>