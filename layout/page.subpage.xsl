<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/TR/xhtml1/strict">
	<xsl:output method="html" encoding="utf-8" indent="yes" />
	<xsl:include href="head.turs.page.xsl"/>
	<xsl:template match="/">
		<xsl:variable name="content">
			<xsl:value-of select="//page/body/@contentContainer"/>
		</xsl:variable>
		<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
		<html>
			<xsl:call-template name="turs_head"/>
			<body>
				<xsl:attribute name="id"><xsl:value-of select="//page/@name"/></xsl:attribute>
				<div class="body-top">
				<div style="position: fixed;left:-70px;bottom: 100px;"><input type="button" id="viewform2" class="btn btn-info btn-xs rotate" style="opacity: 1;" value="Подписаться на рассылку">
					<xsl:attribute name="onclick"><![CDATA[var data = $('#newsletter-signup').parent().html(); bootbox.dialog({ message: data, title: 'Подписаться'});]]></xsl:attribute>
				</input>
				</div>
				<div class="row" style="display:none;">
<form id="newsletter-signup" action="/turs/signup-1/" method="post" class="form-inline alert alert-info" role="form">
    <fieldset>
        <label>Подпишитесь на рассылку по e-mail новостей, предложений и событий!</label><br/>
        <p id="signup-response" class="text-primary"></p>
        <div class="row">
			<div class="col-xs-6 col-md-4">
				<input type="text" name="signup-name" placeholder="Ваше имя" />
			</div>
			<div class="col-xs-6 col-md-4">
				<input type="text" name="signup-email" id="signup-email" placeholder="Email" />
			</div>
			<div class="col-xs-6 col-md-4">
				<input type="submit" id="signup-button" value="Подписаться"  class="btn btn-success btn-sm"/>
			</div>
		</div>
    </fieldset>
</form>
</div>
					<div class="main" style="width:90%;">
						<xsl:call-template name="turs_headWrap"/>
						<div id="content">
							<div class="wrapper2">
							<xsl:choose>
										<xsl:when test="//page/body[@hasErrors = 0]">
											<xsl:apply-templates select="//page/body/module[@name = 'menu' and @name != '$content']"/>
											<xsl:apply-templates select="//page/body/module[@name = $content]"/>
										</xsl:when>
										<xsl:when test="//page/body[@hasErrors = 1]">
											<div id="errors">
												<h2>Ошибка</h2>
												<xsl:apply-templates select="//page/body/module[@name = 'error']"/>
												<xsl:apply-templates select="//page/body/module[@name = $content]/container[@module = 'errors']"/>
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
						<div class="clear"/>
						<div id="foot">
							<p id="back-top" style="display: none;">
								<a href="#top">
									<span/>
								</a>
							</p>
							<div class="wrapper">
								<div class="moduletable">
									<ul class="menu">
										<li class="item-207">
											<a href="/pages/view-28/">О компании</a>
										</li>
										<li class="item-471">
											<a href="/pages/view-49/">Акции</a>
										</li>
										<li class="item-472">
											<a href="#">Туристу</a>
										</li>
										<li class="item-470">
											<a href="/pages/view-29/">Контакты</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="space">
								<div class="wrapper">
									<div class="footerText">
										<div class="footer1">Copyright © 2013-<xsl:value-of select="//@year"/> БАЛТИК ЛАЙНС ТУР. Все права защищены.</div>
									</div>
									<div style="float: right;margin-top: 17px;">
									<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=25076081&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/25076081/3_0_FFFFFFFF_FFFFFFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)">
<xsl:attribute name="onclick"><![CDATA[try{Ya.Metrika.informer({i:this,id:25076081,lang:'ru'});return false}catch(e){}]]></xsl:attribute>
</img></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter25076081 = new Ya.Metrika({id:25076081,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/25076081" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</div>									
								</div>
							</div>
						</div>
					</div>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
