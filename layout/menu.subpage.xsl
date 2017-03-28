<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/TR/xhtml1/strict">
	<xsl:output method="html" omit-xml-declaration="yes" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" indent="yes"/>
	<xsl:template match="/">
		<xsl:variable name="content">
			<xsl:value-of select="//page/body/@contentContainer"/>
		</xsl:variable>
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>1</title>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
				<link href="css/screen2.css" type="text/css" rel="stylesheet"/>
				<meta name="description" content=""/>
				<meta name="keywords" content=""/>
				<script language="JavaScript" type="text/JavaScript">
<![CDATA[
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
]]>
</script>
			</head>
			<body>
<xsl:attribute name="id"><xsl:value-of select="//page/@name"/></xsl:attribute>
				<div class="wrap">
					<div class="headerWrap-resize">
						<div class="headerWrap">
							<div class="nav">
								<div id="home">
									<ul>
										<li>
											<a href="/">
												<img alt="Item1" src="images/menu_home.gif"/>
											</a>
										</li>
										<li>
											<a href="#">
												<img alt="Item2" src="images/menu_map.gif"/>
											</a>
										</li>
										<li>
											<a href="#">
												<img alt="Item3" src="images/menu_mail.gif"/>
											</a>
										</li>
									</ul>
								</div>
								<div id="top-menu"><!--
							<ul>
								<li><a href="/products/"><img alt="Item1" src="images/menu_product.gif"/></a></li>
								<li><a href="/services/"><img alt="Item2" src="images/menu_service.gif"/></a></li>
								<li><a href="#"><img alt="Item3" src="images/menu_klient.gif"/></a></li>
								<li><a href="#"><img alt="Item4" src="images/menu_support.gif"/></a></li>
								<li><a href="/pages/page-about/"><img alt="Item5" src="images/menu_about.gif"/></a></li>
							</ul>-->
						
						<table cellpadding="0" cellspacing="0" border="0">
<tr>
<!--<td bgcolor="#3172d5" width="14"><img height="14" width="14" src="images/menu_space.gif"/></td>-->
<td bgcolor="#225bb1" width="89"><a onmouseover="MM_swapImage('product','','images/menu_product_hover.gif',1)" onmouseout="MM_swapImgRestore()" href="/products/"><img height="46" border="0" width="89" name="product" alt="Продукты" src="http://rivc-pulkovo.ru/images/menu_product.gif"/></a></td>
<td bgcolor="#225bb1" width="68"><a onmouseover="MM_swapImage('service','','images/menu_service_hover.gif',1)" onmouseout="MM_swapImgRestore()" href="/services/"><img height="46" border="0" width="68" name="service" alt="Услуги" src="images/menu_service.gif"/></a></td>
<td bgcolor="#225bb1" width="78"><a onmouseover="MM_swapImage('klient','','images/menu_klient_hover.gif',1)" onmouseout="MM_swapImgRestore()" href="/pages/view-clients/"><img height="46" border="0" width="78" name="klient" alt="Клиенты" src="images/menu_klient.gif"/></a></td>
<td bgcolor="#225bb1" width="92"><a onmouseover="MM_swapImage('support','','images/menu_support_hover.gif',1)" onmouseout="MM_swapImgRestore()" href="/pages/view-support/"><img height="46" border="0" width="92" name="support" alt="Поддержка" src="images/menu_support.gif"/></a></td>
<td bgcolor="#225bb1" width="99"><a onmouseover="MM_swapImage('about','','images/menu_about_hover.gif',1)" onmouseout="MM_swapImgRestore()" href="/about/view-about/mi-12/"><img height="46" border="0" width="99" name="about" alt="О компании" src="images/menu_about.gif"/></a></td>
</tr>
</table></div>
					</div>
						</div>
						<!-- headerWrap -->
					</div>
					<!-- head-resize -->
					<div class="contentWrap">
						<div class="content-pad">
							<div id="content">
								<!--<div id="content-right">-->
								<div class="content-center">
									<xsl:choose>
										<xsl:when test="//page/body[@hasErrors = 0]">
											<xsl:apply-templates select="//page/body/module[@name = $content]"/>
										</xsl:when>
										<xsl:when test="//page/body[@hasErrors = 1]">
											<div id="errors">
												<h2>Ошибка</h2>
												<xsl:apply-templates select="//page/body/module[@name = 'error']"/>
												<xsl:apply-templates select="//page/body/module[@name = $content]/container[@module = 'errors']"/>
												<xsl:apply-templates select="//page/body/module[@name = $content]/container[@module = 'login']"/>
												<p>
													<a href="/" title="На главную">На главную</a>
												</p>
											</div>
										</xsl:when>
										<xsl:when test="//page/body[@hasErrors = 2]">
											<xsl:apply-templates select="//page/body/module[@name = $content]"/>
										</xsl:when>
									</xsl:choose>
								</div>
							</div>
							<!-- content -->
						</div>
						<!-- content-pad -->
					</div>
					<!-- contentWrap -->
					<div class="infoBlock">
						<div id="clientsLine">
							<p>Наши основные клиенты</p>
							<div class="flash1">
								<div class="flash2">
									<div class="flash3">
										<div id="logoLine">
											<img alt='ГТК "Россия"' src="images/logo_rossiya.gif"/>
											<img alt='Аэропорт "Пулково"' src="images/k_logo_pulkovo.gif"/>
											<img alt="Уральские авиалинии" src="images/alogo_ural.jpg"/>
											<img alt="Аэрофлот-Норд" src="images/alogo_nord.jpg"/>
											<img alt="Аэрофлот-Дон" src="images/alogo_don.jpg"/>
											<img alt="Авиакон Цитотранс" src="images/aviacon.gif"/>
											<img alt='ФГУП "Оренбургские авиалинии"' src="images/orenburgavia-logo.gif"/>
											<img alt="Сахалинские авиатрассы" src="images/sat.gif"/>
											<img alt="Пулково-Экспресс" src="images/alogo_pe.jpg"/>
											<img alt="ЗАО «Архангельское ЦАВС»" src="images/arhcavs-logo.gif"/>
											<img alt="ЦАВС Иркутска" src="images/alogo_cavsi.jpg"/>
											<img alt="ЛАВС" src="images/alogo_lavs.jpg"/>
											<img alt="" src=""/>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- FLASH -->
						<div class="info-block">
							<div class="info-block-pad">
								<div class="news-bottom">
									<xsl:apply-templates select="//page/body/module[@name = 'newsFooter']"/>
								</div>
								<div class="tech-bottom">
									<h3>Техническая поддержка</h3>
									<b>РИВЦ-Пулково</b> осуществляет круглосуточную техническую поддержку
                    		 своих клиентов по всем эксплуатируемым системам.<br/>
                             Вы всегда можете получить быструю и квалифицированную помощь по всем интересующим Вас вопросам.
                             <br/>
									<p class="BotHead">тел: (812) 704-5530</p>
								</div>
								<div class="partners-bottom">
									<h3>Партнеры</h3>
									<p>
										<img alt="Партнер 1" src="images/part_1.jpg"/>
									</p>
									<p>
										<img alt="Партнер 2" src="images/part_1.jpg"/>
									</p>
								</div>
							</div>
							<!-- info-block-pad -->
						</div>
						<!-- info-block -->
					</div>
					<!-- infoBlock -->
					<div class="footerWrap">
					<div class="footerWrap2">
					<div class="footerWrap3">
						<div class="footer-menu">
							<a class="BotMenuD" href="index.php">главная</a>::<a class="BotMenuD" href="?id=1">продукты</a>::<a class="BotMenuD" href="?id=2">услуги</a>::<a class="BotMenuD" href="?id=3">клиенты</a>::<a class="BotMenuD" href="?id=4">поддержка</a>::<a class="BotMenuD" href="?id=5">о компании</a>
						</div>
						<div class="counter">
							<a href="http://www.easycounter.com/ru/">
								<img alt="скрипт статистика посещения" src="images/counter.jpg"/>
							</a>
						</div>
						</div>
						</div>
					</div>
				</div>
				<!-- wrap -->
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
