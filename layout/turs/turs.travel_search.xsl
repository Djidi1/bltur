<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'travellist']">
		<xsl:if test="//page/@isAjax != 1">
			<div id="cpanel">
				<table class="adminform" width="100%">
					<tbody>
						<tr>
							<td valign="top">
								<h2>Поиск по номеру заказа</h2>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<p id="loading" class="load_hide"/>
			<form id="langFilter" name="langFilter" method="post">
				<table>
					<tbody>
						<tr>
							<td class="form-group has-success has-feedback">
								<input id="order_number" class="form-control" type="text" name="order_number" onchange="" size="15" placeholder="Номер заказа"/>
							</td>
							<td><label class="control-label" for="order_number">. </label>
								<span class="btn  btn-primary" onclick="sendFilter('http://{//page/@host}/{//page/@name}/search_order-1/', 'langFilter', 'viewListlang');">Найти</span>
							</td>
							<td>
								<input id="ajax" name="ajax" type="hidden" value="1"/>											
							</td>
						</tr>
					</tbody>
				</table>
				<span class="help-block" style="color: #999;font-style: italic;">Поиск осуществляется по уникальному номеру заказа туриста. <br/>
				К найденому добавляются все туристы с единым номером бронирования.</span>
			</form>
			<div id="viewListlang">
				<xsl:if test="count(travel/item)>0">
					<xsl:call-template name="viewTable"/>
				</xsl:if>
			</div>
		</xsl:if>
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
							<th>№ п/п</th>
							<th>с нами</th>
							<th>ФИО</th>
							<th>Место посадки</th>
							<th>Тур</th>
							<th>Коментарий</th>
							<xsl:if test="count(//page/@xls)=0">
								<th colspan="3" align="center">*</th>
							</xsl:if>
						</tr>
						</thead>
						<tbody>
						<xsl:for-each select="travel/item">
							<tr>
								<td>
									<xsl:if test="new_site = 1"><xsl:attribute name="class">new_site</xsl:attribute></xsl:if>
									<xsl:value-of select="position()"/>
								</td>
								<td>
									<xsl:if test="payed &lt; ../../turs/item[id=../../travel/@id_tur]/cost"><xsl:attribute name="class">low_pay</xsl:attribute></xsl:if>
									<xsl:if test="payed = ../../turs/item[id=../../travel/@id_tur]/cost"><xsl:attribute name="class">ok_pay</xsl:attribute></xsl:if>
									<xsl:if test="payed = 0"><xsl:attribute name="class">not_pay</xsl:attribute></xsl:if>
									<xsl:value-of select="c_tours"/>
								</td>
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
									<xsl:value-of select="comment"/>
								</td>
								<td width="40px" align="center">
									<xsl:if test="payed = 0 and bank_payed = 0">
										<a href="#" title="Оплата за одного" class="btn btn-warning btn-sm" onclick="open_dialog('http://{//page/@host}/turs/pay_order-{id}/','Оплата заказа',720,550); return false;">Оплатить</a>
									</xsl:if>
									<xsl:if test="payed > 0 or bank_payed > 0">
										<b class="text-success">Оплачено</b>
									</xsl:if>
								</td>
							</tr>
						</xsl:for-each>
					</tbody>
				</table>
				<xsl:if test="count(travel/item)>1">
					<div style="text-align:center"><a href="#" title="Оплатить все бронирования" class="btn btn-success" onclick="open_dialog('http://{//page/@host}/turs/pay_order-{travel/item/id}/forall-1/','Оплата заказа',720,550); return false;">Оплатить за всех</a></div>
				</xsl:if>
			</form>
	</xsl:template>
</xsl:stylesheet>