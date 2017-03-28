<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns="http://www.w3.org/TR/xhtml1/strict">
	<xsl:output method="html" encoding="utf-8" indent="yes" />
		<xsl:include href="head.turs.page.xsl"/>
		<xsl:include href="head.page.xsl"/>
	<xsl:template match="/">
		<xsl:variable name="content">
			<xsl:value-of select="//page/body/@contentContainer"/>
		</xsl:variable>
		<xsl:text disable-output-escaping='yes'>&lt;!DOCTYPE html></xsl:text>
		<html xmlns="http://www.w3.org/1999/xhtml">
			<xsl:call-template name="head"/>
			<body>
				<xsl:attribute name="id"><xsl:value-of select="//page/@name"/></xsl:attribute>
				<div id="loadingDiv"><div class="dumbBoxOverlay"></div><div class="vertical-offset"><div class="dumbBox"/></div></div>
				<div class="body-top">
					<div class="main" style="width:90%;">
						<xsl:choose>
						  <xsl:when test="//page/body/module/container/@module = 'agentlist'">
								<xsl:call-template name="turs_headWrap"/>
						  </xsl:when>
						  <xsl:otherwise>
								<xsl:call-template name="headWrap"/>
						  </xsl:otherwise>
						</xsl:choose>
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
											<a href="#">О компании</a>
										</li>
										<li class="item-471">
											<a href="#">Условия</a>
										</li>
										<li class="item-472">
											<a href="#">Отзывы</a>
										</li>
										<li class="item-470">
											<a href="#">Контакты</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="space">
								<div class="wrapper">
									<div class="footerText">
										<div class="footer1">Copyright © 2013-<xsl:value-of select="//@year"/> БАЛТИК ЛАЙНС ТУР. Все права защищены.</div>
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
