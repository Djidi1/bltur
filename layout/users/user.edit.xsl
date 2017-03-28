<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'useredit']">

<div id="cpanel">
			<table class="adminform" align="center">
				<tbody>
					<tr>
						<td valign="top">
						
							<h2>Редактировать профиль пользователя:</h2>
			<form action="http://{//page/@host}/admin/userUpdate-{user/user_id}/" method="post" name="main_form">
			<div>
				<input type="hidden" name="user_id" value="{user/user_id}"/>
				<table>
					<tbody>
						<tr>
							<td>ФИО:</td>
							<td>
								<input type="text" name="username" value="{user/name}" size="30"/>
							</td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td>
								<input type="text" name="email" id="email" value="{user/email}" size="30"/>
							</td>
						</tr>
						<tr>
							<td>Телефон:</td>
							<td><input type="text" name="ip" value="{user/ip}" size="30"/> </td>
						</tr>
						<tr>
							<td>Название Агента:</td>
							<td>
							<xsl:if test="user/tab_no = 'undefined type: NULL'"><input type="text" name="tab_no" id="tab_no" value="" size="30"/></xsl:if>
							<xsl:if test="user/tab_no != 'undefined type: NULL'"><input type="text" name="tab_no" id="tab_no" value="{user/tab_no}" size="30"/></xsl:if>
							</td>
						</tr>
						<tr>
							<td>Логин*:</td>
							<td>
								<input type="text" name="login" id="login" value="{user/login}" size="30"/>
							</td>
						</tr>
						<tr>
							<td>
								Пароль:
							</td>
							<td>
								<input type="password" name="pass" id="pass" />
							</td>
						</tr>
						<tr>
							<td>Группа:</td>
							<td>
								<select name="group_id">
									<xsl:for-each select="groups/item">
										<option value="{id}">
											<xsl:if test="id = //user/group_id">
												<xsl:attribute name="selected">selected</xsl:attribute>
											</xsl:if>
											<xsl:value-of select="name"/>
										</option>
									</xsl:for-each>
								</select>
							</td>
						</tr>
						
						<!--<tr>
							<td>Доступ к данным о пассажирах:</td>
							<td>
								<input type="checkbox" name="allowpass" id="allowpass">
								<xsl:if test="user_rights/item/allow = '1'">
								<xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input>
							</td>
						</tr>-->
						<!--						<tr>
							<td>Изменить пароль автоматически:</td>
							<td><input type="hidden" name="isAutoPass" value="0" /><input type="checkbox" name="isAutoPass" value="1" id="isAutoPass"></input> </td>
						</tr>		-->
						<tr>
							<td>Заблокировать:</td>
							<td>
								<input type="hidden" name="isBan" value="0"/>
								<input type="checkbox" name="isBan" value="1" id="isBan"/>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" value="сохранить" name="submit"/>
							</td>
						</tr>
					</tbody>
				</table>
				<font color="red">Все поля обязательны для заполнения.</font>
				<xsl:call-template name="linkback"/>
			</div>
		</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>	
	
		
	</xsl:template>
</xsl:stylesheet>
