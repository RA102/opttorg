<?php
if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
/************************************************************************/
//																		//
//						   Карта Сайта v2.0								//
//					Demo - http://dagstudent.ru/sitemap					//
//					 Разработчик DagStudent (DS-SOFT)					//
//		Разработка Компонентов, Плагинов и Модулей для Instant CMS:		//
//				e-mail: dagstudent@ya.ru skype: dagstudent				//
//																		//
/************************************************************************/

function generate_map_torg($config){
	$inCore	= cmsCore::getInstance();
	$inDB	= cmsDatabase::getInstance();
	$inCore->loadModel("sitemap");
	$model	= new cms_model_sitemap();
	
	$map = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	$html = '<h1>Торговая площадка:</h1>';
	$cats = $this->getCategoryTree("cms_torg_cats", $model->host."/torg", TRUE);
	foreach ($cats as $num=>$cat){
		if ($cat['id']==1000){
			$cat['title']	= "Главная страница Торговой площадки";
			$cat['seolink']	= $model->host."/torg";
		}
		$map .= '<url><loc>'.$cat['seolink'].'</loc><lastmod>'.date('Y-m-d').'</lastmod><changefreq>daily</changefreq><priority>0.9</priority></url>';
		$html .= "<div style=\"padding-left:";
		$html .= ($cat['NSLevel']-1)*20;
		$html .= "px\" class=\"cat_link\"><div><a href=\"".$cat['seolink']."\" ";
		$html .= "style=\"font-weight:bold\">".$cat['title']."</a></div></div>";
		$sql = "SELECT id, pubdate, title, seolink FROM cms_torg_items WHERE category_id = '{$cat['id']}' AND published = 1";
		$result = $inDB->query($sql);
		$html .= '<ul style="list-style-type: none;">';
		while ($item = $inDB->fetch_assoc($result)){
			$map .= '<url><loc>'.$model->host.'/torg/item'.$item['id'].'.html</loc>';
			$item['pubdate'] = strtotime($item['pubdate']);
			$map .= '<lastmod>'.date("Y-m-d", $item['pubdate']).'</lastmod>';
			if($item['pubdate'] >= strtotime("-1 week")) {
				$map .= '<changefreq>daily</changefreq><priority>0.9</priority>';
			} else {
				$map .= '<changefreq>weekly</changefreq><priority>0.8</priority>';
			}
			$map .= '</url>';
			$html .= '<li><a href="'.$model->host.'/torg/item'.$item['id'].'.html">'.$item['title'].'</a></li>';
		}
		$html .= '</ul>';
	}
	$map .= '</urlset>';
	$map = iconv("cp1251","utf-8",$map);
	file_put_contents(PATH.'/sitemaps/torg.xml', $map);
	return $html;
}

?>