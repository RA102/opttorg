<?
	if(isset($_GET['rewrite-strtolower-url'])) {
	    $url = $_GET['rewrite-strtolower-url'];
	    unset($_GET['rewrite-strtolower-url']);        
	    $params = strtolower(http_build_query($_GET));
	    if(strlen($params)) {
	        $params = '?' . $params;
	    }
	    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/' . strtolower($url) . $params, true, 301);
	    exit;
	}
	header("HTTP/1.0 404 Not Found");
	die('Unable to convert the URL to lowercase. You must supply a URL to work upon.');
?>