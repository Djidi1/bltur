<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'locations']">
			<table class="viewList table" cellpadding="2" cellspacing="1" width="100%">
				<tr>
					<th colspan="{count(locs/item)}">Выберите район отправления</th>
				</tr>
				<tr>
				<xsl:for-each select="locs/item">
					<td style="width: {838 div count(../../locs/item)}px;">
						<!--<a href="/turs/viewTur-{../../type/item/id}/loc-{id}/" class="btn btn-info btn-large" style="background-color:{color};" onmouseover="$( this ).fadeTo( 'fast', 0.5 );" onmouseout="$( this ).fadeTo( 'fast',1 );"> -->
						<a href="/turs/viewTur-{../../type/item/id}/loc-{id}/" class="btn btn-info btn-large" style="background-color:{color};">
							<img alt="" src="/images/loc.png" style="width: 100px;" onmouseover="return false;"/><br/><br/>
							<b><xsl:value-of select="name"/></b>
						</a>
					</td>
				</xsl:for-each>
				</tr>
			</table>
			<table class="viewList table" cellpadding="2" cellspacing="1" width="100%">
				<tr>
					<th>Карта остановок:</th>
				</tr>
				<tr>
					<td><div align="center">
						<script type="text/javascript" charset="utf-8"><xsl:attribute name="src"><![CDATA[http://api-maps.yandex.ru/services/constructor/1.0/js/?sid=B0Dr7cEu0jP74LMNFMcFtZibrREZaVVn&width=838&height=400]]></xsl:attribute></script>
						</div>
					</td>
				</tr>
			</table>
			<!--<xsl:call-template name="type_tur"/>-->
	</xsl:template>
</xsl:stylesheet>
