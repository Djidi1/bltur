<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'travellist']">

			<div class="alert alert-success">
				<b>Проверьте правильность вашего заказа</b>
			</div>
		<xsl:if test="//page/@isAjax = 1">
				<xsl:if test="count(travel/item)=0">
					<span class="text-danger">Заказ в системе не обнаружен.</span>
				</xsl:if>
			<xsl:if test="count(travel/item)>0">
					<xsl:call-template name="viewTable"/>
				</xsl:if>
		</xsl:if>
	</xsl:template>
	<xsl:template name="viewTable">
			<form name="app_form" style="margin:0px" method="post" action="" id="printlist">
				<table cellpadding="3" cellspacing="1" border="0" width="100%" class="table table-striped  table-condensed table-hover">
					<thead>
						<tr bgcolor="#B0C4DE">
							<th>ФИО</th>
							<th>Место посадки</th>
							<th>Тур</th>
							<th>Стоимость</th>
						</tr>
						</thead>
						<tbody>
						<xsl:for-each select="travel/item">
							<tr>
								<td>
									<xsl:value-of select="name_f"/><xsl:text> </xsl:text>
									<xsl:value-of select="name_i"/><xsl:text> </xsl:text>
									<xsl:value-of select="name_o"/>
								</td>
								<td>
									<xsl:value-of select="name"/>
								</td>
								<td>
									<xsl:value-of select="tur_name"/>
								</td>
								<td>
									<xsl:value-of select="cost"/>
								</td>
							</tr>
						</xsl:for-each>
						<tr>
							<td colspan="3"><b>Итого:</b></td>
							<td><xsl:value-of select="sum(travel/item/cost)"/></td>
						</tr>
					</tbody>
				</table>
			</form>
			<form action="https://test.wpay.uniteller.ru/pay/" method="POST" style="text-align:center;"> 
				 <input type="hidden" name="Shop_IDP" value="{travel/form_data/Shop_IDP}"/> 
				 <input type="hidden" name="Order_IDP" value="{travel/form_data/Order_ID}"/> 
				 <input type="hidden" name="Subtotal_P" value="{travel/form_data/Subtotal_P}"/> 
				 <input type="hidden" name="Lifetime" value="{travel/form_data/Lifetime}"/> 
				 <input type="hidden" name="Customer_IDP" value="{travel/form_data/Customer_IDP}"/> 
				 <input type="hidden" name="Signature" value="{travel/form_data/Signature}"/> 
				 <input type="submit" name="Submit" value="Оплатить" class="btn btn-success"/> 
				 <input type="hidden" name="URL_RETURN_OK" value="{travel/form_data/URL_RETURN_OK}"/> 
				 <input type="hidden" name="URL_RETURN_NO" value="{travel/form_data/URL_RETURN_NO}"/> 
			</form> 

	</xsl:template>
</xsl:stylesheet>