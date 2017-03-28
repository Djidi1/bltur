<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'loclist']">
		<xsl:if test="//page/@isAjax != 1">
			<style type="">
	tr.selected {background-color: #EDEDED;}
	</style>
			<div id="cpanel">
				<table class="adminform" width="100%">
					<tbody>
						<tr>
							<td valign="top">
								<h2>Список районов отправления</h2>
								<div style="float: right;">
									<input class="button" type="button" onclick="printBlock('#printlist');" value="Печать"/>
									<br/>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<span class="btn btn-success" onclick="open_dialog('http://tur_control.loc/tc/locNew-1/tur_id-/','Добавить район отправления',320,350); return false;">Добавить</span>
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
				<table cellpadding="3" cellspacing="1" border="0" width="100%" class="table table-striped  table-condensed table-hover">
					<thead>
						<tr bgcolor="#B0C4DE">
							<th>id</th>
							<th>Название (туристов)</th>
							<th>Цвет</th>
							<th>Актуальность</th>
							<th></th>
							<th></th>
						</tr>
					</thead>					
					<tbody>
						<xsl:for-each select="items/item">
							<tr>
								<td>
									<xsl:value-of select="id"/>
								</td>
								<td>
									<xsl:value-of select="name"/>
									[<xsl:value-of select="turs"/>]
								</td>
								<td style="background-color:{color}">
									<xsl:value-of select="color"/>
								</td>
								<td>
									<xsl:value-of select="actual"/>
								</td>
								<td>
									<span class="btn btn-info btn-xs" onclick="open_dialog('http://tur_control.loc/tc/locEdit-1/id-{id}/','Редактировать район отправления',320,350); return false;">Редактировать</span>
								</td>
								<td>
									<xsl:if test="turs = 0">
										<a href="http://{//page/@host}/tc/locDel-{id}/" class="btn btn-danger btn-xs" title="удалить"><xsl:attribute name="onClick"><xsl:call-template name="confirmMsg"><xsl:with-param name="message">Вы действительно хотите удалить район?</xsl:with-param></xsl:call-template></xsl:attribute>Удалить</a>
									</xsl:if>
								</td>
							</tr>
						</xsl:for-each>
					</tbody>
				</table>
			</form>
		</div>
	</xsl:template>
</xsl:stylesheet>
