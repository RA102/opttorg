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
    /*
     * �������� ������� $inCore $inUser $inPage($this) $inConf $inDB
     */
    // �������� ���������� ������� �� ������ �������
    $mod_count['top']     = $this->countModules('top');
    $mod_count['topmenu'] = $this->countModules('topmenu');
    $mod_count['sidebar'] = $this->countModules('sidebar');	
    $mod_count['sidebar-1'] = $this->countModules('sidebar-1');	
	$mod_count['accordeon'] = $this->countModules('accordeon');	
    // ���������� jQuery � js ���� � ����� ������
    $this->prependHeadJS('core/js/common.js');
    $this->prependHeadJS('includes/jquery/jquery.js');
    // ���������� ����� �������
    $this->addHeadCSS('templates/'.TEMPLATE.'/css/all.css');
	//$this->addHeadCSS('templates/'.TEMPLATE.'/css/font-awesome.min.css');
    //$this->addHeadCSS('templates/'.TEMPLATE.'/css/responsive.css');	
    //$this->addHeadCSS('templates/'.TEMPLATE.'/css/styles.css');	
    //$this->addHeadCSS('templates/'.TEMPLATE.'/css/template.css');		
	
    // ���������� colorbox (�������� ����)
    $this->addHeadJS('includes/jquery/colorbox/jquery.colorbox.js');
    $this->addHeadCSS('includes/jquery/colorbox/colorbox.css');
    $this->addHeadJS('includes/jquery/colorbox/init_colorbox.js');
    // LANG ����� ��� colorbox
    $this->addHeadJsLang(array('CBOX_IMAGE','CBOX_FROM','CBOX_PREVIOUS','CBOX_NEXT','CBOX_CLOSE','CBOX_XHR_ERROR','CBOX_IMG_ERROR', 'CBOX_SLIDESHOWSTOP', 'CBOX_SLIDESHOWSTART'));
	/*
	if (isset($_POST['my_city'])) {
		$_SESSION['my_city'] = $_POST['my_city'];
	}
	if (isset($_SESSION['my_city'])) {
		$gorod = $_SESSION['my_city']; 
	} else {
		$ip = $_SERVER['REMOTE_ADDR']; 
		$quer = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip.'?lang=ru'));
		if($quer && $quer['status'] == 'success') {
			$gorod = $quer['city'];
		} else {
			$gorod = '�� ��������';
		}	
	} 
	*/
?>
<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#">
    <head>
		<?php $LastModified_unix = strtotime(date("D, d M Y H:i:s", filectime($_SERVER['SCRIPT_FILENAME']))); $LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix); $IfModifiedSince = false; if (isset($_ENV['HTTP_IF_MODIFIED_SINCE'])) $IfModifiedSince = strtotime(substr ($_ENV['HTTP_IF_MODIFIED_SINCE'], 5)); if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) $IfModifiedSince = strtotime(substr ($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5)); if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) { header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified'); exit; } header('Last-Modified: '. $LastModified); header('Vary: User-Agent'); ?>	
        <meta charset="utf-8">
		<meta name="yandex-verification" content="312a4cd886e70dca" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-W6J7LVK');</script>
		<!-- End Google Tag Manager -->	
		<meta property="og:locale" content="ru_KZ" />
		<?php $this->printHead(); ?>
		<?php if(!$this->page_body){ ?>
		<link rel="canonical" href="https://sanmarket.kz" />
		<meta property="og:title" content="�������� ������� ���������� � ���������� � ������, ���-������ (������), ��������� | SanMarket.kz" />
		<meta property="og:description" content="������ ������ ����������? ������� ������� ���������� SanMarket.kz? ? ������ ���� ? ��� ��� ������. ? ������� �����������. ������� ������ � ��������! ? �������� > ������, ���-������ (������), ���������, �������, ��������, �� ����������." />
		<meta property="og:url" content="https://sanmarket.kz" />
		<meta property="og:image" content="https://sanmarket.kz/templates/<?php echo TEMPLATE; ?>/img/logo.png" />
		<?php } ?>
		<?php if($inUser->is_admin){ ?>
			<script src="/admin/js/modconfig.js" type="text/javascript"></script>
			<link href="/templates/<?php echo TEMPLATE; ?>/css/modconfig.css" rel="stylesheet" type="text/css" />
		<?php } ?>		
        <!--[if lt IE 9]>
            <script src="/templates/<?php echo TEMPLATE; ?>/js/html5shiv.js"></script>
            <script src="/templates/<?php echo TEMPLATE; ?>/js/respond.min.js"></script>
            <script src="/templates/<?php echo TEMPLATE; ?>/js/css3-mediaqueries.js"></script>
            <link rel="stylesheet" href="/templates/<?php echo TEMPLATE; ?>/css/ie.css" type="text/css" media="all" />
        <![endif]-->
		<link rel="icon" type="image/png" href="/templates/<?php echo TEMPLATE; ?>/images/favicon.png" />
		<script src="/templates/<?php echo TEMPLATE; ?>/js/fixedsticky.js"></script>
		<script src="/templates/<?php echo TEMPLATE; ?>/js/seohide.js"></script>
		
<script type="text/javascript">
$(function(){
    
//����� �����
$('.who').bind("change keyup input click", function() {
    if(this.value.length >= 2){
        $.ajax({
            type: 'post',
            url: "/432gsdt55gs34hhj.php", //���� � �����������
            data: {'referal':this.value},
            response: 'text',
            success: function(data){
                $(".search_result").html(data).fadeIn(); //������� ��������� ������ � ������
           }
       })
    }
})
    
$(".search_result").hover(function(){
    $(".who").blur(); //������� ����� � input
})
    
//��� ������ ���������� ������, ������ ������ � ������� ��������� ��������� � input
$(".search_result").on("click", "li", function(){
    s_user = $(this).text();
    //$(".who").val(s_user).attr('disabled', 'disabled'); //������������ input, ���� �����
    $(".search_result").fadeOut();
})

})
</script>		
    </head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W6J7LVK"
height="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->	
<?php $messages = cmsCore::getSessionMessages(); ?>
<?php if ($messages) { ?>
	<?php foreach($messages as $message){ ?>
		<script> alert ('<?php echo $message; ?>'); </script>
	<?php } ?>
<?php } ?>
	<a name="top"></a>
	<div class="top-line">
		<div class="container">
			<span class="pull-left">
				<span class="hidden-md hidden-sm hidden-xs">��������-������� ����������</span>
				<a class="hidden-lg" href="/shop/cart.html"><?php $this->printModules('b-cart'); ?></a>
				<a class="hidden-lg" href="#" data-toggle="modal" data-target="#search_modal"><span class="glyphicon glyphicon-search"></span></a>
				<a class="hidden-lg" href="#" data-toggle="modal" data-target="#city_modal"><span class="glyphicon glyphicon-map-marker"></span></a>
				<a class="hidden-lg" href="tel:+77775409927"><span class="glyphicon glyphicon-phone"></span></a>
			</span>
			<span class="pull-right">
				<?php $userlogs = $inUser->login; $usgro = $inUser->group_id; ?>
				<?php if ($userlogs) { ?>				
					<a href="/users/<?php echo $userlogs; ?>">@<?php echo $userlogs; ?> <span class="glyphicon glyphicon-log-in"></span></a>
				<?php } else { ?>
					<span class="hlink" data-href="<?php echo base64_encode('/login'); ?>">���� <span class="glyphicon glyphicon-log-in"></span></span>
				<?php } ?>	
			</span>
		</div>
	</div>
	<header class="site-header">
		<div class="nav-bar">
		<div class="container">			
			<div class="top-table">
				<div class="top-1-cell">
					<a href="/" rel="home" title="��������-������� ���������� SanMarket"><img src="/templates/<?php echo TEMPLATE; ?>/img/logo.png" class="img-responsive" alt="SanMarket � ��������-������� ���������� � ����������" /></a>
				</div>
				<div class="top-2-cell">
					<!--��� �����<br />
					<a href="#" data-toggle="modal" data-target="#city_modal"><?php echo $gorod; ?> <span class="caret"></span></a>-->
				</div>	
				<div class="top-3-cell">
					<a href="tel:+77212503272"><i class="fa fa-fw fa-phone"></i> +7 7212 50 32 72</a><br />
					<a href="https://wa.me/77775409927"><i class="fa fa-fw fa-whatsapp"></i> +7 777 540 99 27</a>
				</div>			
				<div class="top-4-cell">
					<a href="#" data-toggle="modal" data-target="#search_modal"><img src="/templates/<?php echo TEMPLATE; ?>/img/search.png" class="img-icon" /> ����� <div class="top-gray">�������</div></a>
				</div>		
				<div class="top-5-cell">
					<span class="hlink" data-href="<?php echo base64_encode('/shop/cart.html'); ?>"><?php $this->printModules('b-cart'); ?></span>
				</div>				
			</div>

  <nav class="navbar">
    <div class="navbar-header">
    	<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
			<span><span class="glyphicon glyphicon-th"></span> ����</span>
		</button>
		<a class="navbar-brand hidden-lg" href="/"><img src="/templates/<?php echo TEMPLATE; ?>/img/logo.png" height="20" /></a>
	</div>	
	<div class="collapse navbar-collapse js-navbar-collapse">
		<?php $this->printModules('top'); ?>
	</div>
  </nav>
		</div>
</div>		
	</header>
<div class="main-body">
<?php if($this->page_body){ ?>
	<main class="main">
		<div class="component">
			<div class="container">
			<?php $this->printPathway('&rarr;'); ?> 
			<?php $this->printBody(); ?>
			</div>
		</div>	
	</main>
<?php } else { ?>	
	<section class="main-banner">
		<div id="carousel-1" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<img src="/templates/<?php echo TEMPLATE; ?>/img/ban2.jpg" alt="�����-������������" class="img-resp" />
				</div>
				<?php if ($gorod=='���������') { ?>
				<div class="item">
					<img src="/templates/<?php echo TEMPLATE; ?>/img/ban1.jpg" alt="������ ����������� 10%" class="img-resp" />
				</div>
				<?php } ?>
				<!--<div class="item">
					<img src="/templates/<?php echo TEMPLATE; ?>/img/ban3.jpg" class="img-resp" />
				</div>			-->	
			</div>
			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel-1" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>			
		</div>	
	</section>
	<main class="main">
		<div class="container">
			<?php $this->printModules('mainbottom'); ?>
		</div>
		<div class="clearfix"></div>
		<div class="side-bottom">
			<div class="container">
				<?php $this->printModules('maintop'); ?>
			</div>
		</div>
	</main>
<?php } ?>	
	<footer class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 foo-right col-sm-push-4">
					<div class="h4">����� ������ ����� ��������</div>
					<div class="reviews">
						<?php $this->printModules('reviews'); ?>
					</div>
				</div>			
				<div class="col-sm-4 col-sm-pull-8">
					<?php $this->printModules('footer'); ?>
					<br />
					<img src="/templates/<?php echo TEMPLATE; ?>/img/btm-logo.png" class="img-responsive" /><br />
					<p>www.sanmarket.kz &copy; 2016-<?php echo date('Y'); ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="socials">
						<div class="h4">�� � ��������</div>
						<a href="https://www.instagram.com/santehopttorg/" rel="nofollow" target="_blank"><img src="/templates/<?php echo TEMPLATE; ?>/img/ig.png" /></a>
						<a href="https://vk.com/santehopttorgkz" rel="nofollow" target="_blank"><img src="/templates/<?php echo TEMPLATE; ?>/img/vk.png" /></a>
						<a href="https://ok.ru/santehopttorg" rel="nofollow" target="_blank"><img src="/templates/<?php echo TEMPLATE; ?>/img/wa.png" /></a>
						<a href="https://web.facebook.com/santehopttorg/" rel="nofollow" target="_blank"><img src="/templates/<?php echo TEMPLATE; ?>/img/fb.png" /></a>
					</div>					
				</div>
				<div class="col-sm-6">
					<div class="socials">
						<div class="h4">���������� ����� ������ � ��������!</div>
						<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
						<script src="//yastatic.net/share2/share.js"></script>
						<div class="ya-share2 yashasha" data-services="vkontakte,facebook,odnoklassniki,moimir,whatsapp,skype,telegram" data-counter=""></div>
					</div>					
				</div>	
				<div class="col-sm-2">
					<div class="socials">
						<div class="h4">���� ����������</div>
						<span class="hlink" data-href="<?php echo base64_encode('http://umgonline.kz'); ?>">� �������� Universal <br />Marketing Group</span>
					</div>					
				</div>				
			</div>
		</div>
	</footer>
</div>
	<div id="back-top" class="hidden-md hidden-sm hidden-xs"><a href="#top"><img src="/templates/<?php echo TEMPLATE; ?>/img/totop.png" /></a></div>

<script src="/templates/<?php echo TEMPLATE; ?>/js/bootstrap.min.js"></script>
<script src="/templates/<?php echo TEMPLATE; ?>/js/ie10-viewport-bug-workaround.js"></script>
<script src="/templates/<?php echo TEMPLATE; ?>/js/truncatelines.js"></script>

<script>
$(window).scroll(function(){
    if ($(window).scrollTop() > 32) {
        $('.nav-bar').addClass('fix-top');
		$('.main-body').addClass('mrg-top');
    }
    else {
        $('.nav-bar').removeClass('fix-top');
		$('.main-body').removeClass('mrg-top');
    }
});
</script>
<script>
jQuery('ul.nav > li').hover(function() { jQuery(this).find('.dropdown-menu').stop(true, true).delay(10).fadeIn(); }, function() { jQuery(this).find('.dropdown-menu').stop(true, true).delay(10).fadeOut(); })
</script>
<script type="text/javascript">

$(document).ready(function(){

    $(function (){
		$("#back-top").hide();

		$(window).scroll(function (){
			if ($(this).scrollTop() > 300){
				$("#back-top").fadeIn();
			} else{
				$("#back-top").fadeOut();
			}
		});

		$("#back-top a").click(function (){
			$("body,html").animate({
				scrollTop:0
			}, 800);
			return false;
		});
	});
});
</script>
<script>
jQuery.colorbox.settings.maxWidth  = '95%';
jQuery.colorbox.settings.maxHeight = '95%';
var resizeTimer;
function resizeColorBox()
{
  if (resizeTimer) clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {
            if (jQuery('#cboxOverlay').is(':visible')) {
                      jQuery.colorbox.load(true);
            }
  }, 300);
}
jQuery(window).resize(resizeColorBox);
window.addEventListener("orientationchange", resizeColorBox, false);
</script>

<noindex>
<!--
<div class="modal fade" id="city_modal" tabindex="-1" role="dialog" aria-labelledby="cityModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form action="" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cityModalLabel">��� ����� <?php echo $gorod; ?>. ������� ������?</h4>
      </div>
      <div class="modal-body">
        <div class="row">
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="������" /> ������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="������" /> ������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="���������" /> ���������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="������" /> ������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="��������" /> ��������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="��������" /> ��������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="�������������" /> �������������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="��������" /> ��������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="������" /> ������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="�����" /> �����</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="�����������" /> �����������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="�������" /> �������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="���������" /> ���������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="�����" /> �����</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="������" /> ������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="������" /> ������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="���������" /> ���������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="���������" /> ���������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="�����" /> �����</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="�������" /> �������</label></div>
			<div class="col-md-3 col-sm-4 col-xs-6"><label><input type="radio" name="my_city" value="����-�����������" /> ����-�����������</label></div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">�������</button>
        <button type="submit" class="btn btn-primary">�������</button>
      </div>
	</form>
    </div>
  </div>
</div>
-->
<div class="modal fade" id="fil_modal" tabindex="-1" role="dialog" aria-labelledby="filModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<?php $this->printModules('filter'); ?>
    </div>
  </div>
</div>
<div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cityModalLabel">������� ����� �������</h4>
      </div>
      <div class="modal-body">	
		<input type="text" name="referal" placeholder="�����" value="" class="who form-control" autocomplete="off" />
		<ul class="search_result"></ul>	
	  </div>
	  <div class="modal-footer">
		�� �����? ���������� <a href="/search">�������������� �����</a>!
	  </div>
    </div>
  </div>
</div>
<!-- Begin Verbox {literal} -->
<script type='text/javascript'>
	(function(d, w, m) {
		window.supportAPIMethod = m;
		var s = d.createElement('script');
		s.type ='text/javascript'; s.id = 'supportScript'; s.charset = 'utf-8';
		s.async = true;
		var id = '74a9a7ea51b25fad462ecf6f83545718';
		s.src = '//admin.verbox.ru/support/support.js?h='+id;
		var sc = d.getElementsByTagName('script')[0];
		w[m] = w[m] || function() { (w[m].q = w[m].q || []).push(arguments); };
		if (sc) sc.parentNode.insertBefore(s, sc); 
		else d.documentElement.firstChild.appendChild(s);
	})(document, window, 'Verbox');
</script>
<!-- {/literal} End Verbox -->

</noindex>
<script>
    $(".ex-click").click(function () {
      $(this).siblings(".ex-slide").slideToggle("slow");
    });
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter46894398 = new Ya.Metrika({
                    id:46894398,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/46894398" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Yandex.Metrika counter --> 
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter51363598 = new Ya.Metrika2({
                    id:51363598,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/51363598" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<script type="application/ld+json">
{
 "@context" : "http://schema.org",
 "@type" : "Organization",
 "name" : "��������-������� SanMarket.kz",
 "url" : "https://sanmarket.kz/",
 "logo": "https://sanmarket.kz/templates/basic_free/img/logo.png",
 "sameAs" : [
   "https://www.instagram.com/santehopttorg/",
   "https://vk.com/santehopttorgkz",
   "https://ok.ru/santehopttorg",
   "https://www.facebook.com/santehopttorg/"
 ]
}
</script>
</body>
</html>