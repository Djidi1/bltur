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
			<table class="viewList" cellpadding="2" cellspacing="1" width="100%">
				<tr>
					<td align="left" width="40" height="40">
						<p id="loading" class="load_hide"/>
					</td>
					<td>
						<form id="langFilter" name="langFilter" method="post">
							<table>
								<tbody>
									<tr>
										<td class="form-group has-success has-feedback"><label class="control-label" for="order_number">Номер заказа: </label>
											<input id="order_number" class="form-control" type="text" name="order_number" onchange="" size="15"/>
										</td>
										<td>
											<span class="btn  btn-primary" onclick="sendFilter('http://{//page/@host}/{//page/@name}/search_order-1/', 'langFilter', 'viewListlang');">Найти</span>
										</td>
										<td>
											<input id="ajax" name="ajax" type="hidden" value="1"/>											
										</td>
									</tr>
								</tbody>
							</table>
							<span class="help-block" style="color: #999;font-style: italic;">Поиск осуществляется по уникальному номеру заказа туриста. <br/>
							И к найденому добавляются все туристы с такимже номером бронирования в туре.</span>
						</form>
					</td>
				</tr>
			</table>
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
		<div><a href="/tc/viewTurList-1/id_tur-{travel/item[1]/id_tur}/" class="btn  btn-primary">Перейти к туру </a>
			<form name="app_form" style="margin:0px" method="post" action="" id="printlist">
				<table cellpadding="3" cellspacing="1" border="0" width="100%" class="table table-striped  table-condensed table-hover">
					<thead>
						<tr bgcolor="#B0C4DE">
							<th>№ п/п</th>
							<th>с нами</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='tl.book_num'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">№<xsl:if test="travel/@order='tl.book_num'">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value=''; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">ФИО<xsl:if test="travel/@order=''">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='tt.phone'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Телефон<xsl:if test="travel/@order='tt.phone'">^</xsl:if>
</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='tt.passport'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Паспорт<xsl:if test="travel/@order='tt.passport'">^</xsl:if>							
</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='tt.dob'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Дата рождения <xsl:if test="travel/@order='tt.dob'">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='mp.name'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Место посадки <xsl:if test="travel/@order='mp.name'">^</xsl:if>
							</th>
							<th>Отель/Каюта</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='tl.comment'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Коментарий <xsl:if test="travel/@order='tl.comment'">^</xsl:if>
							</th>
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
									<xsl:value-of select="(count(../../travel/item)-position()+1)"/>
								</td>
								<td>
									<xsl:if test="payed &lt; ../../turs/item[id=../../travel/@id_tur]/cost"><xsl:attribute name="class">low_pay</xsl:attribute></xsl:if>
									<xsl:if test="payed = ../../turs/item[id=../../travel/@id_tur]/cost"><xsl:attribute name="class">ok_pay</xsl:attribute></xsl:if>
									<xsl:if test="payed = 0"><xsl:attribute name="class">not_pay</xsl:attribute></xsl:if>
									<xsl:value-of select="c_tours"/>
								</td>
								<td>
									<xsl:value-of select="book_num"/>
								</td>
								<td>
									<xsl:value-of select="name_f"/><xsl:text> </xsl:text>
									<xsl:value-of select="name_i"/><xsl:text> </xsl:text>
									<xsl:value-of select="name_o"/>
								</td>
								<td>
									<xsl:value-of select="phone"/>
								</td>
<td>
									<xsl:value-of select="passport"/>
								</td>
								<td>
									<xsl:value-of select="dob"/>
								</td>
								<td>
									<xsl:value-of select="name"/>
								</td>
								<td>
									<xsl:value-of select="number"/> / <xsl:value-of select="cabin"/>
								</td>
								<td>
									<xsl:value-of select="comment"/>
								</td>
								<xsl:if test="count(//page/@xls)=0">
									
									<td width="40px" align="center">
										<a href="#" title="редактировать профиль" onclick="open_dialog('http://{//page/@host}/tc/userEdit-{id_tourist}/','Редактировать профиль',520,550); return false;">
											<img alt="редактировать профиль" src="/images/edit_p.png" border="0"/>
										</a>
									</td>
									
									<td width="40px" align="center">
										<a href="#" title="редактировать туриста" 
										onclick="open_dialog('http://{//page/@host}/tc/travelEdit-{id}/turist_id-{id_tourist}/','Редактировать участника тура',520,550); return false;">
											<img alt="редактировать туриста" src="/images/edit_b.png" border="0"/>
										</a>
									</td>
									
									<td width="40px" align="center">
										<a href="http://{//page/@host}/tc/travelBan-{id}/tur_id-{../@id_tur}/" title="удалить">
											<xsl:attribute name="onClick">if (confirm('Вы действительно хотите исключить из поездки туриста <xsl:value-of select="concat(name_f,' ',name_i,' ',name_o)"/>?')) return true; else return false;</xsl:attribute>
											<img alt="удалить" src="/images/del.png" border="0"/>
										</a>
									</td>
								</xsl:if>
							</tr>
						</xsl:for-each>
					</tbody>
				</table>
			</form>
		</div>
	</xsl:template>
</xsl:stylesheet>