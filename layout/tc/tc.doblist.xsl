<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'doblist']">
		<xsl:if test="//page/@isAjax != 1">
			<style type="">
	tr.selected {background-color: #EDEDED;}
	</style>
			<div id="cpanel">
				<table class="adminform" width="100%">
					<tbody>
						<tr>
							<td valign="top">
								<h2>Список ближайших дней рождений туристов</h2>
								<div style="float: right;">
									<input class="button" type="button" onclick="printBlock('#printlist');" value="Печать"/>
									<br/>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="viewListlang">
				<xsl:call-template name="viewTable"/>
			</div>
		</xsl:if>
		<xsl:if test="//page/@isAjax = 1">
			<xsl:call-template name="viewTable"/>
		</xsl:if>
	</xsl:template>
	<xsl:template name="viewTable">
		<div>
			<form name="app_form" style="margin:0px" method="post" action="" id="printlist">
				<table cellpadding="3" cellspacing="1" border="0" width="100%" class="table">
					<tbody>
						<tr bgcolor="#B0C4DE">
							<th>№ п/п</th>
							<th>с нами</th>
							<th>Ф.И.О.</th>
							<th>Телефон</th>
							<th>Дата рождения</th>
							<th>Комментарий</th>
							<!--<th>ДК</th>-->
						</tr>
						<xsl:for-each select="items/item">
							<tr onmouseout="this.className = 'darck';" onmouseover="this.className = 'selected';" class="darck">
								<xsl:attribute name="bgcolor"><xsl:if test="position() mod 2 =1">#EDF7FE</xsl:if><xsl:if test="position() mod 2 =0">#E4F2FD</xsl:if></xsl:attribute>
								<td>
									<xsl:value-of select="position()"/>
								</td>
								<td>
									<xsl:value-of select="c_tours"/>
								</td>
								<td>
									<xsl:value-of select="name_f"/>
									<xsl:text> </xsl:text>
									<xsl:value-of select="name_i"/>
									<xsl:text> </xsl:text>
									<xsl:value-of select="name_o"/>
								</td>
								<td>
									<xsl:value-of select="phone"/>
								</td>
								<td>
									<xsl:value-of select="dob"/>
								</td>
								<td>
									<xsl:value-of select="comment"/>
								</td>
								<!--<td>
									<xsl:value-of select="dk"/>
								</td>-->
							</tr>
						</xsl:for-each>
					</tbody>
				</table>
			</form>
		</div>
	</xsl:template>
</xsl:stylesheet>
