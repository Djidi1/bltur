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
								<h2>Список пользователей</h2>
								<div style="float: left;">
									<div class="icon">
										<a href="http://{//page/@host}/admin/newUser-1/">
											<img src="/images/icon-48-adduser.png" alt="Новый пользователь"/>
											<span>Новый пользователь</span>
										</a>
									</div>
								</div>
								<div style="float: right;">
									<input type="button" onclick="printBlock('#printlist');" value="Печать"/>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<table class="viewList" cellpadding="2" cellspacing="1" width="100%">
				<tr>
					<th colspan="11">Поиск по полям
					</th>
				</tr>
				<tr>
					<td align="left" width="40" height="40">
						<p id="loading" class="load_hide"/>
					</td>
					<td>
						<form id="langFilter" name="langFilter"  method="post" action="">
							<table>
								<tbody>
									<tr>
										<td>Ф.И.О.:<br/>
											<input id="f_name" type="text" name="f_name" onchange="" size="15" onkeyup="sendFilter('http://{//page/@host}/{//page/@name}/userList-1/', 'langFilter', 'viewListlang');"/>
										</td>
										<td>Логин:<br/>
											<input id="f_login" type="text" name="f_login" onchange="" size="15" onkeyup="sendFilter('http://{//page/@host}/{//page/@name}/userList-1/', 'langFilter', 'viewListlang');"/>
										</td>
										<td>
											<b>Выбор группы:</b>
										</td>
										<td>
											<select name="idg" onchange="sendFilter('http://{//page/@host}/{//page/@name}/userList-1/', 'langFilter', 'viewListlang');">
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
										</td>
										<td>
										<input id="ajax" name="ajax" type="hidden" value="1"/>
											<b><input type="button" onclick="buttonSetFilter('langFilter', '1', 'ajax','input', 'http://{//page/@host}/{//page/@name}/userList-1/xls-1/', true)" value="Экспорт в Excel"/></b>
										</td>
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
				<table class="table table-hover table-stripsed table-condensed">
					<thead>
						<tr>
							<th>№  [ID]</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='name'; sendFilter('http://{//page/@host}/{//page/@name}/userList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Ф.И.О. <xsl:if test="users/@order='name'">^</xsl:if>
							</th>
							<th>Агент</th>
							<th>Телефон</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='email'; sendFilter('http://{//page/@host}/{//page/@name}/userList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Почта <xsl:if test="users/@order='email'">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='login'; sendFilter('http://{//page/@host}/{//page/@name}/userList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Логин <xsl:if test="users/@order='login'">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='group_name'; sendFilter('http://{//page/@host}/{//page/@name}/userList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Группа <xsl:if test="users/@order='group_name'">^</xsl:if>
							</th>
							<th style="cursor:pointer" onclick="document.langFilter.srt.value='date_reg'; sendFilter('http://{//page/@host}/{//page/@name}/userList-1/', 'langFilter', 'viewListlang');" title="Сортировка">Дата регистрации <xsl:if test="users/@order='date_reg'">^</xsl:if>
							</th>
							<xsl:if test="count(//page/@xls)=0">
							<th colspan="3" align="center">*</th>
							</xsl:if>
						</tr>
					</thead>
					<tbody>
						<xsl:for-each select="users/user">
							<xsl:if test="isban=0">
								<tr>
									<td>
									<xsl:value-of select="position()"/> [<xsl:value-of select="id"/>]
									</td>
									<td>
										<xsl:value-of select="name"/>
									</td>
									<td>
										<xsl:value-of select="tab_no"/>
									</td>
									<td>
										<xsl:value-of select="ip"/>
									</td>
									<td>
										<xsl:value-of select="email"/>
									</td>
									<td>
										<xsl:value-of select="login"/>
									</td>
									<td>
										<xsl:value-of select="group_name"/>
									</td>
									
									<td>
										<xsl:value-of select="date_reg"/>
									</td>
									<xsl:if test="count(//page/@xls)=0">
									<td width="40px" align="center">
										<a href="http://{//page/@host}/admin/userEdit-{id}/" title="редактировать" class="btn btn-success btn-xs">
											<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
										</a>
									</td>
									<td width="40px" align="center">
										<a href="http://{//page/@host}/admin/userBan-{id}/" title="удалить" class="btn btn-danger btn-xs">
											<xsl:attribute name="onClick">return confirm('Вы действительно хотите удалить<xsl:value-of select="name"/>?');</xsl:attribute>
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
										</a>
									</td>
									</xsl:if>
								</tr>
							</xsl:if>
						</xsl:for-each>
						<xsl:if test="count(users/user[isban=1]) &gt; 0">
						<tr>
							<xsl:attribute name="bgcolor">#FF9999</xsl:attribute>
							<td colspan="10" align="center">
								<font color="#000000">
									<b>Удаленные пользователи</b>
								</font>
							</td>
						</tr>
						</xsl:if>
						<xsl:for-each select="users/user">
							<xsl:if test="isban=1">
								<tr>
									<xsl:attribute name="bgcolor"><xsl:if test="position() mod 2 =1">#EDF7FE</xsl:if><xsl:if test="position() mod 2 =0">#E4F2FD</xsl:if></xsl:attribute>
									<td>
										<xsl:value-of select="id"/>
									</td>
									<td>
										<xsl:value-of select="name"/>
									</td>
									
									<td>
										<xsl:value-of select="email"/>
									</td>
									<td>
										<xsl:value-of select="login"/>
									</td>
									<td>
										<xsl:value-of select="group_name"/>
									</td>
									
									<td>
										<xsl:value-of select="date_reg"/>
									</td>
									<xsl:if test="count(//page/@xls)=0">
									<td width="40px" align="center">
										<a href="http://{//page/@host}/admin/userUnBan-{id}/" title="восстановить">
											<img alt="восстановить" src="/images/revert.png" border="0"/>
										</a>
									</td>
									<td width="40px" align="center">
										<a href="http://{//page/@host}/admin/userBan-{id}/full-1/" title="удалить полностью">
											<xsl:attribute name="onClick">return confirm('Вы действительно хотите удалить безвозвратно?');</xsl:attribute>
											<img alt="удалить" src="/images/del.png" border="0"/>
										</a>
									</td>
									</xsl:if>
								</tr>
							</xsl:if>
						</xsl:for-each>
					</tbody>
				</table>
			</form>
		</div>
	</xsl:template>
</xsl:stylesheet>
