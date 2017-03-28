<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'turlist']">
		<xsl:if test="//page/@isAjax != 1">
			<div id="cpanel">
				<table class="adminform" width="100%">
					<tbody>
						<tr>
							<td valign="top">
								<h2>Список туров</h2>
										<a href="http://{//page/@host}/tc/turEdit-0/" class="btn btn-success" style="float: left;">
											<span>Добавить тур</span>
										</a>
								<div style="float: right;">
									<input class="button" type="button" onclick="printBlock('#printlist');" value="Печать"/>
									<br/>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<table class="viewList table table-striped  table-condensed table-hover" cellpadding="2" cellspacing="1" width="100%">
				<!-- <tr>
					<th colspan="11">Поиск по полям</th>
				</tr> -->
				<tr>
					<td>
						<form id="langFilter" name="langFilter" method="post" action="">
							<table>
								<tbody>
									<tr>
										<td>
											<b>Тип тура:</b>
										</td>
										<td>
											<select name="type" onchange="sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');" style="width:100px">
													<option value="">Все</option>
													<xsl:for-each select="types/item">
														<option value="{id}">
															<xsl:if test=" id = ../../users/@type">
																<xsl:attribute name="selected">selected</xsl:attribute>
															</xsl:if>
															<xsl:value-of select="name_type"/>
														</option>
													</xsl:for-each>
											</select>
										</td>
										<td style="width: 30%;">
											<input id="name" type="text" name="name" placeholder="Название" onchange="" size="15" onkeyup="sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');"/>
										</td>
										<td>
											<div class="input-daterange input-group" id="datepicker">
												<input type="text" class="input-sm form-control" id="start_date" name="start_date" value="{@start_date}" />
												<span class="input-group-addon">to</span>
												<input type="text" class="input-sm form-control" id="end_date" name="end_date" value="{@end_date}" />
											</div>
											<script>
											<![CDATA[
											$(function() {
												$( "#start_date" ).datepicker({
													//defaultDate: "+1w",
													changeMonth: true,
													dateFormat: "yy-mm-dd",
													numberOfMonths: 1,
													onClose: function( selectedDate ) {
														$( "#end_date" ).datepicker( "option", "minDate", selectedDate );
													}
												});
												$( "#end_date" ).datepicker({
													defaultDate: "+3m",
													changeMonth: true,
													dateFormat: "yy-mm-dd",
													numberOfMonths: 1,
													onClose: function( selectedDate ) {
														$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
													}
												});
											});
											]]>
											</script>
											
										</td>
										<td>
											<input id="country" type="text" name="country" onchange="" size="15" onkeyup="sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');" placeholder="Страна"/>
										</td>
										<td>
											<input id="target" type="text" name="target" onchange="" size="15" onkeyup="sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');" placeholder="Цель"/>
										</td>
										<td>
											<b>
												<input class="btn btn-success" type="button" onclick="sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');" value="Применить"/>
											</b>
										</td>
										<td>
											<input id="ajax" name="ajax" type="hidden" value="1"/>
											<b>
												<input class="btn btn-info" type="button" onclick="buttonSetFilter('langFilter', '1', 'ajax','input', 'http://{//page/@host}/{//page/@name}/viewTur-1/xls-1/', true)" value="Экспорт в Excel"/>
											</b>
										</td>
									</tr>
								</tbody>
							</table>
							<b>Новые оплаты: <xsl:value-of select="@new_pays"/></b>
							<input type="hidden" name="mode" value="langfilt"/>
							<input type='hidden' name='srt'/>
						</form>
					</td>
				</tr>
			</table>
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
							<th>№ п/п</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='date'; sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');" title="Сортировка">Даты<xsl:if test="turs/@order='date'">^</xsl:if>
							</th>
							<th title="">В туре</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='t.name'; sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');" title="Сортировка">Название<xsl:if test="turs/@order='t.name'">^</xsl:if>
							</th>
							<th title="">Тип тура</th>
							<th title="">Стоимость</th>
							<th>Страна</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='b.number'; sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');" title="Сортировка">Цель <xsl:if test="turs/@order='b.number'">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='g.name'; sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');" title="Сортировка">Транспорт <xsl:if test="turs/@order='g.name'">^</xsl:if>
							</th>
							<xsl:if test="count(//page/@xls)=0">
								<th colspan="3" align="center">*</th>
							</xsl:if>
						</tr>
					</thead>
					<tbody>
						<xsl:for-each select="turs/item">
							<tr>
								<td><xsl:if test="new_turists > 0"><xsl:attribute name="class">new_site</xsl:attribute></xsl:if>
									<xsl:value-of select="position()"/>
								</td>
								<td>
									<xsl:value-of select="date"/>
									<xsl:if test="date_to != date">
										 - <xsl:value-of select="date_to"/>
									</xsl:if>
								</td>
								<td>
									<xsl:value-of select="turists"/> /
									<xsl:value-of select="bus_size"/>
								</td>
								<td>
									<xsl:if test="fire = 1"><img src="/images/bigFire.gif" /></xsl:if>
									<xsl:value-of select="name"/></td>
								<td><xsl:value-of select="name_type"/></td>
								<td>
									<xsl:if test="new_pays &gt; 0"><xsl:attribute name="class">ok_pay</xsl:attribute></xsl:if>
									<xsl:if test="new_pays = 0"><xsl:attribute name="class">not_pay</xsl:attribute></xsl:if>
									<xsl:value-of select="cost"/><xsl:text> </xsl:text><xsl:value-of select="currency"/>
								</td>
								<td>
									<xsl:value-of select="loc_name"/>
								</td>
								<td>
									<xsl:value-of select="gid_name"/>
								</td>
								<td>
									<xsl:value-of select="bus_number"/>
								</td>
								<xsl:if test="count(//page/@xls)=0">
<td width="40px" align="center">
<a href="http://{//page/@host}/tc/viewTurList-1/id_tur-{id}/" title="Перейти к туру" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-share-alt"></span></a>
</td>
									<td width="40px" align="center">
										<!--<a href="#" title="редактировать" class="btn btn-info btn-xs" onclick="open_dialog('http://{//page/@host}/tc/turEdit-{id}/','Редактировать тур',520,550); return false;">Редактировать</a>-->
										<a href="http://{//page/@host}/tc/turEdit-{id}/" title="редактировать" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
									</td>
									<td width="40px" align="center">
									<xsl:if test="turists=0">
										<a href="http://{//page/@host}/tc/turDel-{id}/" title="удалить" class="btn btn-danger btn-xs">
											<xsl:attribute name="onClick">
												<xsl:call-template name="confirmMsg">
													<xsl:with-param name="message">Вы действительно хотите удалить тур "<xsl:value-of select="name"/>" на дату(ы) <xsl:value-of select="date"/><xsl:if test="date_to != date"> - <xsl:value-of select="date_to"/></xsl:if>?</xsl:with-param>
												</xsl:call-template>
											</xsl:attribute><span class="glyphicon glyphicon-remove"></span></a>
										</xsl:if>
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
