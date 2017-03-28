<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'turedit']">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Редактор туров</h3>
			</div>
			<div class="panel-body">
				<form action="http://{//page/@host}/tc/turUpdate-{tur/id}/" method="post" name="main_form">
					<div>
						<input type="hidden" name="tur_id" value="{tur/id}"/>
						<table class="table table-condensed table-striped">
							<tbody>
								<tr>
									<th>Название:</th>
									<td>
										<input type="text" name="name" value="{tur/name}" size="30" style="width: 100%;"/>
									</td>
								</tr>
								<tr>
									<th>Тип тура:</th>
									<td>
										<select class="" name="id_type">
											<xsl:for-each select="types/item">
												<option value="{id}">
													<xsl:if test="id = //tur/tur_type">
														<xsl:attribute name="selected">selected</xsl:attribute>
													</xsl:if>
													<xsl:value-of select="name_type"/>
												</option>
											</xsl:for-each>
										</select>
									</td>
								</tr><tr>
									<th>Страна:</th>
									<td>
										<select class="" name="id_loc">
											<xsl:for-each select="locs/item">
												<option value="{id}">
													<xsl:if test="id = //tur/id_loc">
														<xsl:attribute name="selected">selected</xsl:attribute>
													</xsl:if>
													<xsl:value-of select="name"/>
												</option>
											</xsl:for-each>
										</select>
									</td>
								</tr>
								<!--<tr>
									<th>Из района:</th>
									<td>
										<select class="" name="id_loc">
											<xsl:for-each select="locs/item">
												<option value="{id}">
													<xsl:if test="id = //tur/id_loc">
														<xsl:attribute name="selected">selected</xsl:attribute>
													</xsl:if>
													<xsl:value-of select="name"/>
												</option>
											</xsl:for-each>
										</select>
										--><!--<div class="col-xs-4">
								<button class="btn btn-info" onclick="var round_id=$('input[name=\'round_id\']').val(); open_dialog('http://{//page/@host}/tc/locNew-1/tur_id-{tur/id}/round_id-'+round_id+'/','Добавить район отправления',320,350); return false;">Добавить</button>
									</div>--><!--
									</td>
								</tr>
								<tr>
									<th>Направление:</th>
									<td>
										<select class="" name="id_city">
											<xsl:for-each select="citys/item">
												<option value="{id}">
													<xsl:if test="id = //tur/id_city">
														<xsl:attribute name="selected">selected</xsl:attribute>
													</xsl:if>
													<xsl:value-of select="name"/>
												</option>
											</xsl:for-each>
										</select>
										--><!--<div class="col-xs-8"></div>
								<div class="col-xs-4">
								<button class="btn btn-info" onclick="var round_id=$('input[name=\'round_id\']').val(); open_dialog('http://{//page/@host}/tc/cityNew-1/tur_id-{tur/id}/round_id-'+round_id+'/','Добавить город',320,350); return false;">Добавить</button>
									</div>--><!--
									</td>
								</tr>-->
										<!--<div class="col-xs-8"></div>
								<div class="col-xs-4">
								<button class="btn btn-info" onclick="var round_id=$('input[name=\'round_id\']').val(); open_dialog('http://{//page/@host}/tc/cityNew-1/tur_id-{tur/id}/round_id-'+round_id+'/','Добавить город',320,350); return false;">Добавить</button>
									</div>
									</td>
								</tr>-->
								<tr>
									<th>Транспорт:</th>
									<td>
										<select class="" name="id_transport">
											<xsl:for-each select="transport/item">
												<option value="{id}">
													<xsl:if test="id = //tur/tur_transport">
														<xsl:attribute name="selected">selected</xsl:attribute>
													</xsl:if>
													<xsl:value-of select="transp_name"/>
												</option>
											</xsl:for-each>
										</select>
									</td>
								</tr>
								<tr>
									<th>Цель поездки:</th>
									<td>
										<select class="" name="id_target">
											<xsl:for-each select="targets/item">
												<xsl:if  test="id != 6">
												<option value="{id}">
													<xsl:if test="id = //tur/tur_target">
														<xsl:attribute name="selected">selected</xsl:attribute>
													</xsl:if>
													<xsl:value-of select="target_name"/>
												</option>
												</xsl:if>
											</xsl:for-each>
										</select>
									</td>
								</tr>
								<tr>
									<th>Даты тура:</th>
									<td class="form-inline">
										<table>
											<tr>
												<td>с <input class="daty_from" type="text" name="date[]" value="{tur/date}" size="30" style="width: 40%;position: relative; z-index: 100000;"/>
											   по <input class="daty_to" type="text" name="date_to[]" value="{tur/date_to}" size="30" style="width: 40%;position: relative; z-index: 100000;"/>
												</td>
												<td width="20%">
													<div class="input-group">
														<input type="text" name="days[]" value="{tur/days}" size="30"/> <span class="input-group-addon" >дней.</span>
													</div>
												</td>
												<td>
												 <xsl:if test="count(tur/id) = 0">
													<span class="btn btn-success" onclick="clone_row(this)" alt="copy" title="copy">
														<span class="glyphicon glyphicon-plus"/>
													</span>
												 </xsl:if>
												</td>
												<td>
												 <xsl:if test="count(tur/id) = 0">
													<span class="btn btn-danger" onclick="delete_row(this)" alt="delete" title="delete">
														<span class="glyphicon glyphicon-remove"/>
													</span>
												 </xsl:if>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<th>Стоимость:</th>
									<td>
										<div class="input-group">
											<input type="text" name="cost" value="{tur/cost}" size="30" style="width: 185px;text-align: right;"/>
											<!--<input type="text" name="currency" value="{tur/currency}" size="3"  class="input-group-addon" style="width:60px;"/>-->
											<select name="currency" class="input-group-addon" style="width:70px;">
												<option value="руб.">
													<xsl:if test="'руб.' = tur/currency">
														<xsl:attribute name="selected">selected</xsl:attribute>
													</xsl:if>руб.</option>
												<option value="у.е.">
													<xsl:if test="'у.е.' = tur/currency">
														<xsl:attribute name="selected">selected</xsl:attribute>
													</xsl:if>у.е.</option>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<th>Вместимость автобуса:</th>
									<td>
										<div class="input-group">
											<input type="text" name="bus_size" value="{tur/bus_size}" size="30"/> <span class="input-group-addon" >мест.</span>
										</div>
									</td>
								</tr>
								<tr><th>Горящий:</th><td>
									<input type="checkbox" onclick="if (this.checked) $('#fire').val('1'); else $('#fire').val('0');">
										<xsl:if test="tur/fire = 1"><xsl:attribute name="checked">checked</xsl:attribute></xsl:if></input>
									<input id="fire" class="" type="hidden" name="fire" value="{tur/fire}"/></td>
								</tr>	
								<tr>
									<th>Описание тура:</th>
									<td>
										<textarea id="edit_content" name="overview" class="form-control" rows="4">
											<xsl:value-of select="tur/overview"/>
										</textarea>
									</td>
								</tr>	
								<tr>
									<th>Дополнительная информация:</th>
									<td>
										<textarea id="dop_info" name="dop_info" class="form-control" rows="4">
											<xsl:value-of select="tur/dop_info"/>
										</textarea>
									</td>
								</tr>
								<!--<tr>
							<th>Описание тура:</th>
							<td><div class="col-xs-8">
								<select class="" name="id_page">
								<option value="0"> - </option>
									<xsl:for-each select="pages/item">
										<option value="{id}">
											<xsl:if test="id = //tur/id_page">
												<xsl:attribute name="selected">selected</xsl:attribute>
											</xsl:if>
											<xsl:value-of select="title"/>
										</option>
									</xsl:for-each>
								</select>
								</div>
								<div class="col-xs-4">
									</div>
							</td>
						</tr>-->
								<!--<tr>
							<th>Гид:</th>
							<td><div class="col-xs-8">
								<select class="" name="id_gid">
									<option value="0">-</option>
									<xsl:for-each select="gids/item">
										<option value="{id}">
											<xsl:if test="id = //tur/id_gid">
												<xsl:attribute name="selected">selected</xsl:attribute>
											</xsl:if>
											<xsl:value-of select="name"/>
										</option>
									</xsl:for-each>
								</select>
								</div>
								<div class="col-xs-4">
								<button class="btn btn-info" onclick="var round_id=$('input[name=\'round_id\']').val(); open_dialog('http://{//page/@host}/tc/gidNew-1/tur_id-{tur/id}/round_id-'+round_id+'/','Добавить гида',320,350); return false;">Добавить</button>
									</div>
							</td>
						</tr>
						<tr>
							<th>Транспорт:</th>
							<td><div class="col-xs-8">
								<select class="" name="id_bus">
									<option value="0">-</option>
									<xsl:for-each select="bus/item">
										<option value="{id}">
											<xsl:if test="id = //tur/id_bus">
												<xsl:attribute name="selected">selected</xsl:attribute>
											</xsl:if>
											<xsl:value-of select="number"/>
										</option>
									</xsl:for-each>
								</select>
								</div>
								<div class="col-xs-4">
								<button class="btn btn-info" onclick="var round_id=$('input[name=\'round_id\']').val(); open_dialog('http://{//page/@host}/tc/busNew-1/tur_id-{tur/id}/round_id-'+round_id+'/','Добавить транспорт',320,350); return false;">Добавить</button>
									</div>
							</td>
						</tr>-->
								<tr>
									<th>Информация по выезду:</th>
									<td>
										<textarea name="comment" class="form-control" rows="4">
											<xsl:value-of select="tur/comment"/>
										</textarea>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input class="btn btn-success" type="submit" value="сохранить" name="submit"/>
									</td>
								</tr>
							</tbody>
						</table>
						<font color="red">Все поля обязательны для заполнения.</font>
					</div>
				</form>
			</div>
		</div>
	</xsl:template>
</xsl:stylesheet>
