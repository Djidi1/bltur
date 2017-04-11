<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template name="turs_head">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<base href="."/>
			<title>Балтик Лайнс Тур | Туры: СПб, Россия, Финляндия, Прибалтика</title>
			<meta name="description" content="Балтик Лайнс Тур | Туры: СПб, Россия, Финляндия, Прибалтика"/>
			<link href="./images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
			<link rel="stylesheet" href="./css/facebox.css"/>
			<link rel="stylesheet" href="./css/camera.css"/>
			<link rel="stylesheet" href="./css/jquery-ui.css"/>
			<link rel="stylesheet" href="./css/style.css?v3"/>
			<link rel="stylesheet" href="./css/custom.css"/>
			<link rel="stylesheet" href="./css/camera.css"/>
			<link rel="stylesheet" href="./css/stylesheet.css"/>
			<link rel="stylesheet" href="./css/system.css"/>
			<link rel="stylesheet" href="./css/position.css" media="screen,projection"/>
			<link rel="stylesheet" href="./css/layout.css" media="screen,projection"/>
			<link rel="stylesheet" href="./css/print.css" media="Print"/>
			<link rel="stylesheet" href="./css/virtuemart.css?v2"/>
			<link rel="stylesheet" href="./css/products.css"/>
			<link rel="stylesheet" href="./css/personal.css"/>
			<link rel="stylesheet" href="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css"/>
			<link rel="stylesheet" href="./css/bootstrap.min.css"/>
			<link rel="stylesheet" href="/css/bootstrap-slider.css"/>
			<script src="/js/jquery.min.js" />
			<script src="/js/jquery-ui.min.js" />
			<script src="/js/bootstrap.min.js" />
			<script src="/js/bootbox.min.js" />
			<script src="/js/jquery.multiselect.min.js?v1" />
			<script src="/js/jquery.maskinput.min.js" />
			<script src="/js/camera.min.js" />
			<script src="/js/ready.js?v1"/>
			<script src="/js/script.js?v1"/>
			<script src="/callme/js/callme.js"/>
			<script src="/js/bootstrap-slider.js"/>
			<script language="javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"/>
			<script language="javascript" src="//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js"/>
			<script src="/ckeditor/ckeditor.js?v1"/>
			<script> 
				var roxyFileman = '/fileman/index.html'; 
				$(function(){
					if ($('#edit_content').length){CKEDITOR.replace( 'edit_content',{filebrowserBrowseUrl:roxyFileman,filebrowserUploadUrl:roxyFileman,filebrowserImageBrowseUrl:roxyFileman+'?type=image',filebrowserImageUploadUrl:roxyFileman+'?type=image'});}
				});
			</script>
			<!--[if IE 8]>
	<link href="./css/ie8only.css" rel="stylesheet" />
<![endif]-->
			<!--[if lt IE 8]>
    <div style=' clear: both; text-align:center; position: relative; z-index:9999;'>
        <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0"  alt="" /></a>
    </div>
<![endif]-->
			<!--[if lt IE 9]>
<script  src="./js/html5.js"></script>
<![endif]-->
		</head>
	</xsl:template>
	<xsl:template name="turs_headWrap">
		<div id="header">
			<div class="row-head">
				<div class="relative">
					<div id="topmenu">
						<div class="moduletable-nav">
							<nav class="navbar navbar-default">
								<div class="container-fluid">
									<!-- Collect the nav links, forms, and other content for toggling -->
									<div class="collapse navbar-collapse" id="navbar-collapse">
										<ul class="nav navbar-nav">
											<li>
												<a href="/">Главная</a>
											</li>
											<li class="item-207">
												<a href="/pages/view-28/">О нас</a>
											</li>
											<li>
												<a href="/pages/view-49/">
												<xsl:if test="//page/@new_page = 1"><xsl:attribute name="class">new_site</xsl:attribute></xsl:if>Акции</a>
											</li>
											<li>
												<a href="/pages/view-52/">Услуги</a>
											</li>
											<li>
												<a href="/info/">
													<span class="glyphicon glyphicon-info-sign" aria-hidden="true" style="color:rgb(91,192,222);"/> Туристу</a>
											</li>
											<li>
													<a href="http://school.bltur.ru/" style="font-weight:bold;">Школьная страница</a>
											</li>
											<li>
												<a href="/pages/view-30/">Агентам</a>
											</li>
											<li>
												<a href="http://balticlines.ru/">Заказ автобусов</a>
											</li>
											<li>
												<a href="/pages/view-29/">Контакты</a>
											</li>
										</ul>
										<script>
											var now_path = window.location.pathname;
											$('ul li a[href="'+now_path+'"]').parent().addClass('active');
										</script>
										<div class="moduletable_LoginForm navbar-form navbar-right">
											<xsl:apply-templates select="//page/body/module[@name = 'CurentUser']/container[@module = 'login']"/>
											<!--				<div xmlns="" class="form"><div class="poping_links"><a href="/admin/" style="padding-right: 0px;">Менеджерам</a></div></div>-->
										</div>
										<!--<form id="search_order" class="navbar-form navbar-right" name="search_order" method="post" action="/turs/search_order-1/">
											<div class="row">
												<div class="col-xs-8 col-md-8">
													<input id="order_number" class="form-control" type="text" name="order_number" onchange="" size="15" placeholder="Номер заказа"/>
												</div>
												<div class="col-xs-4 col-md-4">
													<input class="btn  btn-primary" type="submit" value="Найти"/>
												</div>
											</div>
										</form>-->
									</div>
									<!-- /.navbar-collapse -->
								</div>
								<!-- /.container-fluid -->
							</nav>
						</div>
					</div>
				</div>
			</div>
			<div class="phoneheader">
				<span class="phone" style="">
					<ins/>8 812 715-06-11</span>
				<span class="phone" style="">
					<ins/>8 812 383-77-73</span>
				<span class="address" style="">
					<ins/>
					Санкт-Петербург, <nobr>ул. Хрустальная д.27, офис 4</nobr>
				</span>
			</div>
			<div class="logoheader">
				<h5 id="logo">
					<a href="/">
						<img src="./images/logo.png" alt="Logo"/>
					</a>
					<span class="header1">БАЛТИК ЛАЙНС ТУР </span>
				</h5>
			</div>
		</div>
		<div id="loading2" style="display:none;">
			<div class="loading-block">
				<p class="title" style="text-align:center;">Пожалуйста, подождите...<br/>
					<img src="/images/anim_load.gif"/>
				</p>
			</div>
		</div>
		<div class="ya-site-form ya-site-form_inited_no">
			<xsl:attribute name="onclick">return {'action':'http://<xsl:value-of select="/page/@host"/>/search/','arrow':false,'bg':'transparent','fontsize':16,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по bltur.ru','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2297074,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'Поиск по сайту','input_placeholderColor':'#999','input_borderColor':'#7f9db9'}</xsl:attribute>
			<form action="https://yandex.ru/search/site/" method="get" target="_self" accept-charset="utf-8"><input type="hidden" name="searchid" value="2297074"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input class="form-control" type="search" name="text" value=""/><input type="submit" value="Найти"/></form>
		</div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
	</xsl:template>
</xsl:stylesheet>
