<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'agentlist']">
		<xsl:if test="//page/@isAjax != 1">
			<div id="cpanel">
				<table class="adminform" width="100%">
					<tbody>
						<tr>
							<td valign="top">
								<h2>Агентское бронирование</h2>
								<!-- <a class="btn btn-success btn-sm" onclick="var tur_id = $('#id_tur').val();open_dialog('http://{//page/@host}/tc/travelEdit-0/tur_id-'+tur_id+'/','Добавить туриста в список',520,550); return false;" style="float:left;">
									<span>Добавить туриста</span>
								</a>
								<div style="float: right;">
									<div class="btn-group">
										<input class="btn btn-default btn-sm" type="button" onclick="printBlock('#printlist');" value="Печать"/>
										<input class="btn btn-default btn-sm" type="button" onclick="buttonSetFilter('langFilter', '1', 'ajax','input', 'http://{//page/@host}/{//page/@name}/viewTurList-1/xls-1/', true)" value=" Excel "/>
									</div>
								</div> -->
							</td>
						</tr>
					</tbody>
				</table>
			</div>
<!--
			<form id="langFilter" name="langFilter" method="post" action="">
				<table>
					<tbody>
						<tr>
							<td>
								<b>Выберите тур:</b>
							</td>
							<td>
								<select id="id_tur" name="id_tur" onchange="sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');">
										<xsl:for-each select="turs/item">
											<option value="{id}">
												<xsl:if test=" id = ../../travel/@id_tur">
													<xsl:attribute name="selected">selected</xsl:attribute>
												</xsl:if>
												<xsl:value-of select="date"/> - <xsl:value-of select="name"/>
											</option>
										</xsl:for-each>
								</select>
							</td>
							<td>
								<input id="ajax" name="ajax" type="hidden" value="1"/>
									<div class="btn-group">											
									<input class="btn btn-info btn-sm" type="button" onclick="buttonSetFilter('langFilter', '1', 'ajax','input', 'http://{//page/@host}/{//page/@name}/PrintList-1/xls-1/', true)" value="Гиду"/>
									<input class="btn btn-info btn-sm" type="button" onclick="buttonSetFilter('langFilter', '1', 'ajax','input', 'http://{//page/@host}/{//page/@name}/PrintList-2/xls-1/', true)" value="Граница"/>
									<input class="btn btn-info btn-sm" type="button" onclick="buttonSetFilter('langFilter', '1', 'ajax','input', 'http://{//page/@host}/{//page/@name}/PrintList-3/xls-1/', true)" value="Размещение"/>
									</div>
							</td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="mode" value="langfilt"/>
				<input type='hidden' name='srt'/>
			</form>
-->
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
				<table class="table table-striped  table-condensed table-hover" style="font-size: 12px;">
					<thead>
						<tr>
							<th>№</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='tl.book_num'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">бр.<xsl:if test="travel/@order='tl.book_num'">^</xsl:if></th>
							<th>с нами</th>
							<th>Заказ</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value=''; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">ФИО<xsl:if test="travel/@order=''">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='tt.phone'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Телефон<xsl:if test="travel/@order='tt.phone'">^</xsl:if> </th>
							<th>ДР</th>
							<th>Паспорт</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='mp.name'; sendFilter('http://{//page/@host}/{//page/@name}/viewTurList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Место посадки <xsl:if test="travel/@order='mp.name'">^</xsl:if>
							</th>
							<th>Дата-время добавления</th>
							<!-- <th>Отель / Каюта</th> -->
							<th>Коментарий</th>
							<!-- <th> Оплата</th>
							<xsl:if test="count(//page/@xls)=0">
								<th colspan="3" align="center">*</th>
							</xsl:if> -->
						</tr>
						</thead>
						<tbody>
						<xsl:for-each select="travel/item">
							<tr>
								<xsl:if test="refused = 1"><xsl:attribute name="class">refused</xsl:attribute></xsl:if>
								<td>
								<xsl:if test="new_site = 1"><xsl:attribute name="class">new_site</xsl:attribute></xsl:if>
									<xsl:value-of select="(count(../../travel/item)-position()+1)"/>
								</td>
								<td>
									<xsl:value-of select="book_num"/>
								</td>
								<td>
									<xsl:if test="payed &lt; ../../turs/item[id=../../travel/@id_tur]/cost"><xsl:attribute name="class">ok_pay</xsl:attribute></xsl:if>
									<xsl:if test="payed = ../../turs/item[id=../../travel/@id_tur]/cost"><xsl:attribute name="class">low_pay</xsl:attribute></xsl:if>
									<xsl:if test="payed = 0"><xsl:attribute name="class">not_pay</xsl:attribute></xsl:if>
									<xsl:value-of select="c_tours"/>
								</td>
								<td>
									<xsl:value-of select="id"/>
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
									<i><xsl:value-of select="dob"/></i>
								</td>
								<td>
									<i><xsl:value-of select="passport"/></i>
								</td>
								<td>
									<xsl:value-of select="name"/>
								</td>
								<td><xsl:value-of select="book_date"/></td>
								<!-- <td><xsl:value-of select="number"/> / <xsl:value-of select="cabin"/></td> -->
								<td>
									<xsl:value-of select="comment"/>
								</td>
								<!-- <td>
									<xsl:if test="Status != 'NULL'">
										<span>
<xsl:choose>
  <xsl:when test="Status = 'authorized'"><xsl:attribute name="class">label label-success</xsl:attribute>ОПЛАЧЕН</xsl:when>
  <xsl:when test="Status = 'not authorized'"><xsl:attribute name="class">label label-danger</xsl:attribute>ОШИБКА</xsl:when>
  <xsl:when test="Status = 'paid'"><xsl:attribute name="class">label label-success</xsl:attribute>ОПЛАЧЕН</xsl:when>
  <xsl:when test="Status = 'canceled'"><xsl:attribute name="class">label label-danger</xsl:attribute>ОТМЕНЕН</xsl:when>
  <xsl:when test="Status = 'waiting'"><xsl:attribute name="class">label label-warning</xsl:attribute>ОЖИДАЕТСЯ</xsl:when>
  <xsl:otherwise><xsl:attribute name="class">label label-info</xsl:attribute><xsl:value-of select="Status"/></xsl:otherwise>
</xsl:choose>
										[<xsl:value-of select="dk"/>]</span>
									</xsl:if>
									<xsl:if test="Status = 'NULL'">
										<span class="btn btn-warning btn-sm" onclick="bank_res('/tc/BankReq-{id}');" title="Проверка оплаты">$</span>
									</xsl:if>
								</td>
								<xsl:if test="count(//page/@xls)=0">
								
									<td width="40px" align="center">
										<a href="http://{//page/@host}/tc/getDogovor-{id}/" title="Сформировать договор" target="_blank" class="btn btn-sm btn-primary">
											<span class="glyphicon glyphicon-file"></span>
										</a>
									</td>
									
									<td width="40px" align="center">
										<a href="#" title="редактировать профиль" onclick="open_dialog('http://{//page/@host}/tc/userEdit-{id_tourist}/tur_id-{../@id_tur}/','Редактировать профиль',520,550); return false;" class="btn btn-sm btn-info">
											<span class="glyphicon glyphicon-user"></span>
										</a>
									</td>
									
									<td width="40px" align="center">
										<a href="#" title="редактировать туриста" 
										onclick="open_dialog('http://{//page/@host}/tc/travelEdit-{id}/turist_id-{id_tourist}/','Редактировать участника тура',520,550); return false;" class="btn btn-sm btn-success">
											<span class="glyphicon glyphicon-road"></span>
										</a>
									</td>
									
									<td width="40px" align="center">
										<a href="http://{//page/@host}/tc/travelBan-{id}/tur_id-{../@id_tur}/" title="удалить" class="btn btn-sm btn-danger">
											<xsl:attribute name="onClick"><xsl:call-template name="confirmMsg"><xsl:with-param name="message">Вы действительно хотите исключить из поездки туриста <xsl:value-of select="concat(name_f,' ',name_i,' ',name_o)"/>?</xsl:with-param></xsl:call-template></xsl:attribute>
											<span class="glyphicon glyphicon-remove"></span>
										</a>
									</td>
								</xsl:if> -->
							</tr>
						</xsl:for-each>
					</tbody>
				</table>
			</form>
		</div>
	</xsl:template>
</xsl:stylesheet>