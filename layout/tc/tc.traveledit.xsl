<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'traveledit']">

<div id="cpanel">
			<table class="adminform" align="center" width="100%">
				<tbody>
				<tr>
					<th>Редактировать участника тура:</th>
				</tr>
					<tr>
						<td valign="top">
			<form action="http://{//page/@host}/tc/travelUpdate-{travel/id}/" method="post" name="main_form">
			<div>
				<input type="hidden" name="travel_id" value="{travel/id}"/>
				<input type="hidden" name="tur_id" value="{travel/id_tur}"/>
				<table>
					<tbody>
						<tr><th>Номер брони:</th><td><input class="" type="text" name="book_num" value="{travel/book_num}" size="30" style="width: 100%;"/></td></tr>	
						<tr>
							<th>Участник тура:</th>
							<td>
								<xsl:value-of select="select" disable-output-escaping="yes"/>
							</td>
						</tr>
						<tr>
							<th>Место посадки:</th>
							<td id="mp_result">
								<select id="id_mp_new" class="multi2" name="id_mp" style="width: 263px;">
									<xsl:for-each select="mp/item">
										<option value="{id}">
											<xsl:if test="id = //travel/id_mp">
												<xsl:attribute name="selected">selected</xsl:attribute>
											</xsl:if>
											<xsl:value-of select="name"/>
										</option>
									</xsl:for-each>
								</select>
							</td>
						</tr>
						<tr><th>Каюта:</th><td><input class="" type="text" name="cabin" value="{travel/cabin}" size="30" style="width: 100%;"/></td></tr>	
						<tr><th>Отель:</th><td><input class="" type="text" name="number" value="{travel/number}" size="30" style="width: 100%;"/></td></tr>	
						<tr><th>Оплачено:</th><td>
							<input type="checkbox" onclick="if (this.checked) $('#payed').val('1'); else $('#payed').val('0');">
								<xsl:if test="travel/payed = 1"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input>
							<input id="payed" class="" type="hidden" name="payed" value="{travel/payed}"/></td></tr>	
						<tr><th>Не ездил:</th><td>
							<input type="checkbox" onclick="if (this.checked) $('#refused').val('1'); else $('#refused').val('0');">
								<xsl:if test="travel/refused = 1"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input>
							<input id="refused" class="" type="hidden" name="refused" value="{travel/refused}"/></td></tr>	
						<tr><th>Проверено:</th><td>
							<input type="checkbox" onclick="if (this.checked) $('#new_site').val('0'); else $('#new_site').val('1');">
								<xsl:if test="travel/new_site = 0"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input>
							<input id="new_site" class="" type="hidden" name="new_site" value="{travel/new_site}"/></td></tr>	
						<tr><th>Дата брони:</th><td><xsl:value-of select="travel/book_date"/></td></tr>	
						<tr><th>Комментарии:</th><td><textarea rows="4" cols="40"  name="comment"><xsl:value-of select="travel/comment"/></textarea></td></tr>
						<tr>
							<td colspan="2">
								<input class="button" type="submit" value="сохранить" name="submit"/>
							</td>
						</tr>
						
					</tbody>
				</table>
				<font color="red">Все поля обязательны для заполнения.</font>
			</div>
		</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>	
	
		
	</xsl:template>
</xsl:stylesheet>
