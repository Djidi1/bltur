<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'userlist']">
		<xsl:if test="//page/@isAjax != 1">
			<style type="">
	tr.selected {background-color: #EDEDED;}
	</style>
			<div id="cpanel">
				<table class="adminform" width="100%">
					<tbody>
						<tr>
							<td valign="top">
								<h2>Список туристов</h2>
								<div style="float: left;">
									<div class="icon">
										<a href="#" onclick="open_dialog('http://{//page/@host}/tc/userEdit-0/','Новый турист',520,550); return false;">
											<img src="/images/icon-48-add_tourist.png" alt="Новый турист"/>
											<span>Новый турист</span>
										</a>
									</div>
								</div>
								<div style="float: right;">
									<input class="button" type="button" onclick="printBlock('#printlist');" value="Печать"/>
									<br/>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<table class="viewList" cellpadding="2" cellspacing="1" width="100%">
				<tr>
					<th colspan="11">Поиск по полям</th>
				</tr>
				<tr>
					<td align="left" width="40" height="40">
						<p id="loading" class="load_hide"/>
					</td>
					<td>
						<form id="langFilter" name="langFilter" method="post" action="">
							<table>
								<tbody>
									<tr>
										<td>
											<input placeholder="Фамилия" id="f_name" type="text" name="f_name"  size="15"/>
										</td>
										<td>
											<input placeholder="Телефон" id="f_phone" type="text" name="f_phone"  size="15"/>
										</td>
										<!--<td>
											<b>Выбор группы:</b>
										</td>
										<td>
											<select name="idg" onchange="sendFilter('http://{//page/@host}/{//page/@name}/viewlist-1/', 'langFilter', 'viewListlang');">
												<optgroup label="Группа">
													<option value="">Все</option>
													<xsl:for-each select="groups/item">
														<option value="{id}">
															<xsl:if test=" id = ../../users/@id_group">
																<xsl:attribute name="selected">selected</xsl:attribute>
															</xsl:if>
															<xsl:value-of select="name"/>
														</option>
													</xsl:for-each>
												</optgroup>
											</select>
										</td>-->
										<td>
											<input class="btn btn-success" type="button" onclick="sendFilter('http://{//page/@host}/{//page/@name}/viewlist-1/', 'langFilter', 'viewListlang');" value="Искать"/>
										</td>
										<td>
											<input id="ajax" name="ajax" type="hidden" value="1"/>
											<input class="btn btn-default" type="button" onclick="buttonSetFilter('langFilter', '1', 'ajax','input', 'http://{//page/@host}/{//page/@name}/viewlist-1/xls-1/', true)" value="Экспорт в Excel"/>
										</td>
										<!-- <td>
											<b>Выберите тур:</b>
										</td>
										<td>
											<select id="id_tur" name="id_tur" style="width:200px;">
													<xsl:for-each select="turs/item">
														<option value="{id}">
															<xsl:value-of select="name"/>
															(<xsl:value-of select="date"/>)
														</option>
													</xsl:for-each>
											</select>
										</td> -->
									</tr>
								</tbody>
							</table>
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
				<table class="table table-striped table-hover table-condensed">
					<thead>
						<tr>
							<th>№ п/п</th>
							<th>с нами</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='name'; sendFilter('http://{//page/@host}/{//page/@name}/viewlist-1/', 'langFilter', 'viewListlang');" title="Сортировка">Ф.И.О. <xsl:if test="users/@order='name'">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='phone'; sendFilter('http://{//page/@host}/{//page/@name}/viewlist-1/', 'langFilter', 'viewListlang');" title="Сортировка">Телефон<xsl:if test="users/@order='phone'">^</xsl:if>
							</th>
							<th>Дата рождения / № паспорта </th>
							<!--<th>Страна</th>-->
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='def_mp'; sendFilter('http://{//page/@host}/{//page/@name}/viewlist-1/', 'langFilter', 'viewListlang');" title="Сортировка">Место посадки <xsl:if test="users/@order='def_mp'">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='comment'; sendFilter('http://{//page/@host}/{//page/@name}/viewlist-1/', 'langFilter', 'viewListlang');" title="Сортировка">Комментарии <xsl:if test="users/@order='comment'">^</xsl:if>
							</th>
							<xsl:if test="count(//page/@xls)=0">
								<th colspan="3" align="center">*</th>
							</xsl:if>
						</tr>
						</thead>
						<tbody>
						<xsl:for-each select="users/user">
							<tr>
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
									<xsl:value-of select="dob"/><br/><b><xsl:value-of select="passport"/></b>
								</td>
								<!--<td>
									<xsl:value-of select="code"/>
								</td>-->
								<td>
									<xsl:value-of select="name"/>
								</td>
								<td>
									<xsl:value-of select="comment"/>
								</td>
								<xsl:if test="count(//page/@xls)=0">
									<!-- <td width="40px" align="center">
										<a href="#" onclick="var tur_id = $('#id_tur').val();open_dialog('http://{//page/@host}/tc/travelEdit-0/tur_id-'+tur_id+'/turist_id-{id}/','Добавить туриста в список',520,550); return false;" class="btn btn-default btn-sm">
										<img src="/images/edit_b.png" alt="Добавить туриста" title="отправить в тур" style="width:16px;height:16px;"/></a>
									</td> -->
									<td width="40px" align="center">
										<a href="http://{//page/@host}/tc/userEdit-{id}/" title="редактировать" onclick="open_dialog('http://{//page/@host}/tc/userEdit-{id}/','Редактировать профиль',520,550); return false;" class="btn btn-success btn-sm">
											<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
										</a>
									</td>
									<xsl:if test="c_tours = '0'">
										<td width="40px" align="center">
											<a href="http://{//page/@host}/tc/userDelete-{id}/" title="удалить" class="btn btn-danger btn-sm">
												<xsl:attribute name="onClick"><xsl:call-template name="confirmMsg"><xsl:with-param name="message">Вы действительно хотите удалить?</xsl:with-param></xsl:call-template></xsl:attribute>
												<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
											</a>
										</td>
									</xsl:if>
									<xsl:if test="c_tours > 0">
										<td width="40px" align="center">
											<a href="http://{//page/@host}/tc/userBan-{id}/" title="заблокировать" class="btn btn-warning btn-sm">
												<xsl:attribute name="onClick"><xsl:call-template name="confirmMsg"><xsl:with-param name="message">Вы действительно хотите заблокировать?</xsl:with-param></xsl:call-template></xsl:attribute>
												<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
											</a>
										</td>
									</xsl:if>
								</xsl:if>
							</tr>
						</xsl:for-each>
					</tbody>
				</table>
			</form>
		</div>
	</xsl:template>
</xsl:stylesheet>
