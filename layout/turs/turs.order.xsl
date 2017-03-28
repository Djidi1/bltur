<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'orderedit']">
		<div id="cpanel">
			<table class="table" align="center" width="100%">
				<tbody>
					<tr>
						<th>Заказ тура: <xsl:value-of select="tour/item/name"/>
						</th>
					</tr>
					<tr>
						<td valign="top">
							<form action="http://{//page/@host}/turs/orderUpdate-{order/id}/" method="post" name="main_form">
								<div>
									<input type="hidden" name="order_id" value="{order/id}"/>
									<input type="hidden" name="tur_id" value="{tour/item/id}"/>
									Дата отправления
									<b><xsl:value-of select="tour/item/date"/></b><br/>
									Стоимость: <b><xsl:value-of select="tour/item/cost"/> <xsl:value-of select="tour/item/currency"/></b>
									<!--<fieldset>
										<legend>Обязательно к заполнению</legend>
										<table class="table">
											<tbody>
												 
													<th style="width: 150px;">Телефон:</th>
													<td>
														<input type="text" required="" name="phone" value="{order/phone}" size="30" style="width: 100%;"/>
													</td>
												</tr>
												<tr>
													<th style="width: 150px;">Имя:</th>
													<td>
														<input type="text" required="" name="name" value="{order/name}" size="30" style="width: 100%;"/>
													</td>
												</tr> 
											</tbody>
										</table>
									</fieldset>-->
									<fieldset>
										<!-- <legend>Туристы</legend> -->
										<div class="turists">
										<table class="turists_in_order table">
											<thead>
												<tr>
													<th colspan="2">Турист № <span class="number">1</span> 
														<span class="btn btn-xs btn-danger delete_button" style="display:none;float: right;height: 24px;margin: 0 5px;" onclick="$(this).parent().parent().parent().parent().remove();">X</span></th>
												</tr>
												<tr>
													<td colspan="2">
														<div class="radio">
															<input type="radio" id="radio11" name="radio1" onclick="var obj=$(this).parent().parent().parent().parent().parent(); $(obj).find('.search_turist').hide();$(obj).find('tbody').attr('style','');" checked="checked" style="display: none;"/>
																<label for="radio11" class=" btn btn-info">еду первый раз</label><xsl:text> </xsl:text>
															<input type="radio" id="radio21" name="radio1" onclick="var obj=$(this).parent().parent().parent().parent().parent(); $(obj).find('.search_turist').show();$(obj).find('tbody').hide();" style="display: none;"/>
																<label for="radio21" class=" btn btn-info">ездил с BalticLines</label>
														</div>
														<div class="search_turist row" style="display:none;">Поиск: <input type="text" class="pass_num" value=""></input>
															<span class="button" onclick="var obj=$(this).parent().parent().parent().parent().parent();tourist_by_passport(obj);">Найти</span><br/>
															<span style="color:maroon;">Введите номер паспорта туриста.</span>
														</div>
														<!--<span class="button" onclick="var pn=$('.pass_num').val();tourist_by_passport(pn);">Найти</span></div>-->
													</td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th style="width: 150px;">Фамилия:</th>
													<td>
														<input required="" class="turist_f" type="text" name="turist_f[]" value="{order/name_f}" size="30" style="width: 100%;"/>
														<input class="turist_id" type="hidden" name="turist_id[]" value="{order/turist_id}"/>
													</td>
												</tr>
												<tr>
													<th>Имя:</th>
													<td>
														<input required="" class="turist_i" type="text" name="turist_i[]" value="{order/name_i}" size="30" style="width: 100%;"/>
													</td>
												</tr>
												<tr>
													<th>Отчество:</th>
													<td>
														<input class="turist_o" type="text" name="turist_o[]" value="{order/name_o}" size="30" style="width: 100%;"/>
													</td>
												</tr>
												<tr>
													<th>Телефон:</th>
													<td>
														<input class="turist_phone" type="text" name="turist_phone[]" value="{order/turist_phone}" size="30" style="width: 100%;" required="" />
													</td>
												</tr>
												<tr>
													<th>Дата рождения:</th>
													<td>
														<input required="" id="dob_input_0" class="turist_dob daty" type="text" name="turist_dob[]" value="{order/dob}" size="30" style="width: 100%;position: relative; z-index: 100000;"/>
													</td>
												</tr>
												<tr>
													<th>№ паспорта:</th>
													<td>
														<input class="turist_passport pass_num" type="text" name="turist_passport[]" value="{order/passport}" size="30" style="width: 100%;" onkeyup="check_passport(this)" />
														
														<input type="hidden" name="turist_country[]" value="1"/>
													</td>
												</tr>
												<tr>
													<th style="width: 150px;">Место посадки:</th>
													<td class="mp_result">
														<select class="multi2" name="def_mp[]" style="width: 100%;" required="">
															<xsl:for-each select="mp/item">
																<option value="{id}">
																	<xsl:if test="id = order/def_mp">
																		<xsl:attribute name="selected">selected</xsl:attribute>
																	</xsl:if>
																	<xsl:value-of select="name"/>
																</option>
															</xsl:for-each>
														</select>
													</td>
												</tr>
												<!-- <tr>
													<th>Гражданство:</th>
													<td>
														<select  class="turist_country" name="turist_country[]">
															<xsl:for-each select="countris/item">
																<option value="{id}">
																	<xsl:if test="id = //user/country">
																		<xsl:attribute name="selected">selected</xsl:attribute>
																	</xsl:if>
																	<xsl:value-of select="name"/>
																</option>
															</xsl:for-each>
														</select>
													</td>
												</tr> -->
											</tbody>
										</table>
										</div>
										<input class="btn btn-info" type="button" value="со мной едет... (добавить туриста)" name="" onclick="add_turist_table();"/>
									</fieldset>
									
									<fieldset>
										<legend>Дополнительно</legend>
										<table class="table">
											<tbody>
												<tr>
													<th style="width: 150px;">Комментарии:</th>
													<td>
														<textarea rows="4" cols="30" name="comment">
															<xsl:value-of select="order/comment"/>
														</textarea>
													</td>
												</tr>
												<tr>
													<td colspan="2">
														<input class="btn btn-success" type="submit" value="Отправить заявку" name="submit"/>
													</td>
												</tr>
											</tbody>
										</table>
									</fieldset>
								</div>
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</xsl:template>
</xsl:stylesheet>