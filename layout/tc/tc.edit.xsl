<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'useredit']">

<div id="cpanel">
			<table class="adminform" align="center" width="100%">
				<tbody>
				<tr>
					<th>Редактировать профиль туриста:</th>
				</tr>
					<tr>
						<td valign="top">
			<form action="http://{//page/@host}/tc/userUpdate-{user/id}/tur_id-{@tur_id}" method="post" name="main_form">
			<div>
				<input type="hidden" name="user_id" value="{user/id}"/>
				<table>
					<tbody>
						<tr><th>Фамилия:</th><td><input type="text" name="username_f" value="{user/name_f}" size="30" style="width: 100%;"/></td></tr>
						<tr><th>Имя:</th><td><input type="text" name="username_i" value="{user/name_i}" size="30" style="width: 100%;"/></td></tr>
						<tr><th>Отчество:</th><td><input type="text" name="username_o" value="{user/name_o}" size="30" style="width: 100%;"/></td></tr>
						<tr><th>Телефон:</th><td><input type="text" name="phone" value="{user/phone}" size="30" style="width: 100%;"/></td></tr>
						<tr><th>Дата рождения:</th><td><input class="daty" type="text" name="dob" value="{user/dob}" size="30" style="width: 100%;position: relative; z-index: 100000;"/></td></tr>
						<tr><th>№ паспорта:</th><td><input type="text" name="passport" value="{user/passport}" size="30" style="width: 100%;"/></td></tr>						
						<tr>
							<th>Страна:</th>
							<td>
								<select class="multi" name="country" style="width: 263px;">
									<xsl:for-each select="countris/item">
										<option value="{id}">
											<xsl:if test="id = //user/country">
												<xsl:attribute name="selected">selected</xsl:attribute>
											</xsl:if>
											<xsl:value-of select="name"/>
										</option>
									</xsl:for-each>
								</select>
								<button class="ui-button ui-widget ui-state-default ui-corner-all" onclick="var round_id=$('input[name=\'round_id\']').val(); open_dialog('http://{//page/@host}/tc/countryNew-1/user_id-{user/id}/round_id-'+round_id+'/','Добавить страну',320,350); return false;" style="margin-left: 5px;padding: 2px;">Добавить</button>
							</td>
						</tr>
						<tr>
							<th>Место посадки:</th>
							<td id="mp_result">
								<select class="multi" name="def_mp" style="width: 263px;">
									<xsl:for-each select="mp/item">
										<option value="{id}">
											<xsl:if test="id = //user/def_mp">
												<xsl:attribute name="selected">selected</xsl:attribute>
											</xsl:if>
											<xsl:value-of select="name"/>
										</option>
									</xsl:for-each>
								</select>
								<button class="ui-button ui-widget ui-state-default ui-corner-all" onclick="var round_id=$('input[name=\'round_id\']').val(); open_dialog('http://{//page/@host}/tc/mpNew-1/user_id-{user/id}/round_id-'+round_id+'/','Добавить место посадки',320,350); return false;" style="margin-left: 5px;padding: 2px;">Добавить</button>
							</td>
						</tr>
						
						<tr><th>Комментарии:</th><td><textarea rows="4" cols="40"  name="comment"><xsl:value-of select="user/comment"/></textarea></td></tr>
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
