<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="container[@module = 'turlist']">
        <xsl:if test="//page/@isAjax != 1">
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Выберите тур</h3>
                        </div>
                        <div class="alert alert-warning"><!--Поиск работает в тестовом режиме до 05.10.2014.<br/>-->
                            По всем вопросам звоните:
                            <br/>
                            8 (812) 715-06-11, 8 (812) 383-77-73
                        </div>
                        <form id="form_searcher" class="form-vertical" method="POST" style="padding: 0 15px 15px 15px;">
                            <div class="form-group">
                                <label class="control-label">Тип отдыха</label>
                                <div>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-sm btn-primary active">
                                            <input type="radio" name="type" checked="checked" value="1"/>
                                            Групповой
                                        </label>
                                        <!-- <label class="btn btn-sm btn-danger"><input type="radio" name="type" value="5"/> <span class="glyphicon glyphicon-tree-conifer"></span> Новый год</label> -->
                                        <label class="btn btn-sm btn-warning">
                                            <input type="radio" name="type" value="4"/>
                                            Праздничный тур
                                        </label>
                                        <label class="btn btn-sm btn-success">
                                            <input type="radio" name="type" value="3"/>
                                            Отдых
                                        </label>
                                        <label class="btn btn-sm btn-info">
                                            <input type="radio" name="type" value="2"/>
                                            Индивидуальный
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Страна тура</label>
                                <div>
                                    <select name="country" onchange="searcher_request();">
                                        <option value="">Все</option>
                                        <xsl:for-each select="countris/item">
                                            <option value="{id}">
                                                <xsl:if test=" id = ../../users/@country">
                                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                                </xsl:if>
                                                <xsl:value-of select="name"/>
                                            </option>
                                        </xsl:for-each>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Из какого района</label>
                                <div>
                                    <label class="btn btn-sm btn-default">
                                        <input type="checkbox" name="raion[]" value="КУПЧИНО"/>
                                        Купчино
                                    </label>
                                    <label class="btn btn-sm btn-default">
                                        <input type="checkbox" name="raion[]" value="ВП|ВЕСЕЛЫЙ"/>
                                        Веселый Поселок - Ржевка
                                    </label>
                                    <label class="btn btn-sm btn-default">
                                        <input type="checkbox" name="raion[]" value="ГРАЖДАНКА"/>
                                        Гражданка - Просвещения
                                    </label>
                                    <label class="btn btn-sm btn-default">
                                        <input type="checkbox" name="raion[]" value="[.]" checked="checked"/>
                                        Все районы
                                    </label>
                                    <span class="btn btn-sm btn-info"
                                          onclick="$(this).parent().find('input').prop( 'checked', true );searcher_request();">
                                        Любой
                                    </span>
                                </div>
                            </div>
                            <!--<div class="form-group">-->
                                <!--<label class="control-label">Транспорт</label>-->
                                <!--<div>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="transport[]" value="1" checked="checked"/>-->
                                        <!--Автобус-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="transport[]" value="2"/>-->
                                        <!--Автобус + паром-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="transport[]" value="5"/>-->
                                        <!--Паром-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="transport[]" value="3"/>-->
                                        <!--Ж/Д-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="transport[]" value="4"/>-->
                                        <!--Авиа-->
                                    <!--</label>-->
                                    <!--<span class="btn btn-sm btn-info"-->
                                          <!--onclick="$(this).parent().find('input').prop( 'checked', true );searcher_request();">-->
                                        <!--Любой-->
                                    <!--</span>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="form-group">-->
                                <!--<label class="control-label">Ваша цель</label>-->
                                <!--<div>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="1" checked="checked"/>-->
                                        <!--Откатать визу-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="1" checked="checked"/>-->
                                        <!--Экскурсия-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="2"/>-->
                                        <!--Шопинг-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="3"/>-->
                                        <!--Спорт-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="4"/>-->
                                        <!--С детьми-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="5"/>-->
                                        <!--Путешествие-->
                                    <!--</label>-->
                                    <!--&lt;!&ndash;<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="6"/> Откатывать визу</label>&ndash;&gt;-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="7"/>-->
                                        <!--Каникулы-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-default">-->
                                        <!--<input type="checkbox" name="target[]" value="8"/>-->
                                        <!--Круиз-->
                                    <!--</label>-->
                                    <!--<label class="btn btn-sm btn-danger">-->
                                        <!--<input type="checkbox" name="target[]" value="9"/>-->
                                        <!--Не Лаппеенранта-->
                                    <!--</label>-->
                                    <!--<span class="btn btn-sm btn-info"-->
                                          <!--onclick="$(this).parent().find('input').prop( 'checked', true );searcher_request();">-->
                                        <!--Любая-->
                                    <!--</span>-->
                                <!--</div>-->
                            <!--</div>-->
                            <div class="form-group">
                                <label class="control-label">Период путешествия</label>
                                <div class="col-md-8">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <input type="text" class="input-sm form-control" id="start_date" name="start_date"/>
                                        <span class="input-group-addon">по</span>
                                        <input type="text" class="input-sm form-control" id="end_date" name="end_date"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select name="how_long" style="width:80px;" onchange="searcher_request();">
                                        <option value="0">Дней</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">от 4</option>
                                    </select>
                                </div>
                                <script>
                                    <![CDATA[
									$(function() {
									var now_date = new Date();
									var next_date = new Date(new Date(now_date).setMonth(now_date.getMonth()+6));
										$( "#start_date" ).datepicker({
											//defaultDate: "+1w",
											minDate: 0,
											changeMonth: true,
											dateFormat: "dd.mm.yy",
											numberOfMonths: 1,
											onClose: function( selectedDate ) {
												$( "#end_date" ).datepicker( "option", "minDate", selectedDate );
											}
										}).datepicker('setDate', now_date);
										$( "#end_date" ).datepicker({
											defaultDate: "+6m",
											changeMonth: true,
											dateFormat: "dd.mm.yy",
											numberOfMonths: 1,
											onClose: function( selectedDate ) {
												$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
											}
										}).datepicker('setDate', next_date);;
									});
									]]>
                                </script>
                            </div>
                            <!--<div class="form-group">-->
                                <!--<label class="control-label">Продолжительность (дней)</label>-->
                                <!--<div>-->
                                    <!---->
                                <!--</div>-->
                            <!--</div>-->
                            <hr/>
                            <div class="form-group">
                                <label class="control-label">Бюджет поездки</label>
                                <div style="text-align:center">от
                                    <input type="text" name="price_from" id="price_from" value="0"
                                           style="display: inline;width: 70px;text-align: right;"/>
                                    до
                                    <input type="text" name="price_to" id="price_to" value="20000"
                                           style="display: inline;width: 70px;text-align: right;"/>
                                    руб.
                                </div>
                                <div>
                                    <input id="price_tur" type="text" class="span2" value="" data-slider-min="0"
                                           data-slider-max="100000" data-slider-step="500"
                                           data-slider-value="[0,20000]" data-slider-tooltip="hide"
                                           data-slider-handle="triangle"/>
                                    <div class="col-sm-6">
                                        <b>0 р.</b>
                                    </div>
                                    <div class="col-sm-6" style="text-align:right;">
                                        <b>100 000 р.</b>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="ajax" value="1"/>
                            <hr/>
                            <label class="control-label"/>
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-sm btn-info" onclick="location.reload();">
                                        Сбросить
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-sm btn-success" onclick="searcher_request();">
                                        Применить фильтр
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="panel panel-info" style="min-width: 700px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Найденные туры по категориям</h3>
                        </div>
                        <div id="loadingDiv">
                            <div class="dumbBoxOverlay"/>
                            <div class="vertical-offset">
                                <div class="dumbBox"/>
                            </div>
                        </div>
                        <div id="viewListlang" class="panel-body">
                            <xsl:call-template name="viewTable"/>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function searcher_request() {
                setTimeout(search_timeout,500);
                }
                function search_timeout() {
                var form = $( '#form_searcher' );
                $.ajax( {
                type: "POST",
                url: form.attr( 'action' ),
                data: form.serialize(),
                success: function( response ) {
                $('#viewListlang').html(response);
                }
                } );
                }
                function price_vals(values) {
                $("#price_from").val(values[0]); $("#price_to").val(values[1]);
                }
                $( document ).ready(function() {
                $('#form_searcher').on('change', 'input' , function(){ searcher_request(); });
                $("#price_tur").slider({});
                $("#price_tur").on("slide", function(slideEvt,data) { price_vals(slideEvt.value); });
                $("#price_tur").on("slideStart", function(slideEvt,data) { price_vals(slideEvt.value);
                searcher_request(); });
                $("#price_tur").on("slideStop", function(slideEvt,data) { price_vals(slideEvt.value);
                searcher_request(); });
                });

            </script>
            <!--
            <form id="langFilter" name="langFilter" method="post" action="">
                <div class="row">
                    <div class="col-md-4">
                        <b>Место отправления:</b>
                        <select name="loc" onchange="sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');">
                            <option value="">Все</option>
                            <xsl:for-each select="locs/item">
                                <option value="{id}">
                                    <xsl:if test=" id = ../../users/@id_loc">
                                        <xsl:attribute name="selected">selected</xsl:attribute>
                                    </xsl:if>
                                    <xsl:value-of select="name"/>
                                </option>
                            </xsl:for-each>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <b>Направление:</b>
                        <select name="country" onchange="sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');">
                            <option value="">Все</option>
                            <xsl:for-each select="countris/item">
                                <option value="{id}">
                                    <xsl:if test=" id = ../../users/@country">
                                        <xsl:attribute name="selected">selected</xsl:attribute>
                                    </xsl:if>
                                    <xsl:value-of select="name"/>
                                </option>
                            </xsl:for-each>
                        </select>
                    </div>
                </div>
                <
<td>Отфильтровать направления:
<input id="city" type="text" name="city" onchange="" size="15" onkeyup="sendFilter('http://{//page/@host}/{//page/@name}/viewTur-1/', 'langFilter', 'viewListlang');"/>
</td>
->
                <<b>
<input class="button" type="button" onclick="buttonSetFilter('langFilter', '1', 'ajax','input', 'http://{//page/@host}/{//page/@name}/viewTur-1/xls-1/', true)" value="Экспорт в Excel"/>
</b>->
                <input id="ajax" name="ajax" type="hidden" value="1"/>
                <input type="hidden" name="mode" value="langfilt"/>
                <input type='hidden' name='srt'/>
            </form>-->
        </xsl:if>
        <xsl:if test="//page/@isAjax = 1">
            <xsl:call-template name="viewTable"/>
        </xsl:if>
    </xsl:template>
    <xsl:template name="viewTable">
        <div>
            <form name="app_form" style="margin:0px" method="post" action="" id="printlist">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active"><a href="#bus" aria-controls="bus" role="tab" data-toggle="tab"><i class="fa fa-bus"/> Экскурсии</a></li>
                    <li role="presentation"><a href="#sport" aria-controls="sport" role="tab" data-toggle="tab"><i class="fa fa-heartbeat"/> Спорт</a></li>
                    <li role="presentation"><a href="#ship" aria-controls="ship" role="tab" data-toggle="tab"><i class="fa fa-ship"/> Круизы</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="bus">
                        <table class="table table-striped table-condensed table-hover">
                            <thead>
                                <xsl:call-template name="table-header"/>
                            </thead>
                            <tbody>
                                <xsl:call-template name="table-content">
                                    <xsl:with-param name="target" select="1"/>
                                </xsl:call-template>
                            </tbody>
                        </table></div>
                    <div role="tabpanel" class="tab-pane" id="sport">
                        <table class="table table-striped table-condensed table-hover">
                            <thead>
                                <xsl:call-template name="table-header"/>
                            </thead>
                            <tbody>
                                <xsl:call-template name="table-content">
                                    <xsl:with-param name="target" select="3"/>
                                </xsl:call-template>
                            </tbody>
                        </table></div>
                    <div role="tabpanel" class="tab-pane" id="ship">
                        <table class="table table-striped table-condensed table-hover">
                            <thead>
                                <xsl:call-template name="table-header"/>
                            </thead>
                            <tbody>
                                <xsl:call-template name="table-content">
                                    <xsl:with-param name="target" select="8"/>
                                </xsl:call-template>
                            </tbody>
                        </table></div>
                </div>
            </form>
        </div>
    </xsl:template>
    <xsl:template name="table-header">
        <tr>
            <th/>
            <th>Дата</th>
            <th>Название</th>
            <th>Дней</th>
            <th>Стоимость</th>
            <th style="white-space: nowrap;">Наличие мест</th>
            <xsl:if test="count(//page/@xls)=0">
                <th colspan="1" align="center"/>
            </xsl:if>
        </tr>
    </xsl:template>
    <xsl:template name="table-content">
        <xsl:param name="target"/>
        <xsl:if test="count(turs/item[tur_target = $target]) = 0">
            <tr>
                <th colspan="7">Туры в данной категории не найдены, попробуйте изменить критерии поиска.
                    <br/>
                    Или просто позвоните нам!
                </th>
            </tr>
        </xsl:if>
        <xsl:for-each select="turs/item[tur_target = $target]">
            <tr>
                <td style="white-space: nowrap;">
                    <xsl:if test="tur_transport = 1"><i class="fa fa-bus text-warning" title="Автобус"/></xsl:if>
                    <xsl:if test="tur_transport = 2"><i class="fa fa-bus text-warning" title="Автобус и Паром"/><i class="fa fa-ship text-info" title="Автобус и Паром"/></xsl:if>
                    <xsl:if test="tur_transport = 3"><i class="fa fa-train text-success" title="Поезд"/></xsl:if>
                    <xsl:if test="tur_transport = 4"><i class="fa fa-plane text-danger" title="Самолет"/></xsl:if>
                    <xsl:if test="tur_transport = 5"><i class="fa fa-ship text-info" title="Паром"/></xsl:if>
                </td>
                <td>
                    <nobr>
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"
                              style="color:#5cb85c" title="Отъезд"/>
                        <xsl:value-of select="date"/>
                    </nobr>
                    <xsl:if test="date_to != date">
                        <br/>
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"
                              style="color:#5bc0de" title="Возвращение"/>
                        <xsl:value-of select="date_to"/>
                    </xsl:if>
                </td>
                <td>
                    <a href="#" title="Описание тура" class="btn btn-info fire{fire}"
                       onclick="var data = $(this).parent().find('.overview').html(); open_text(data,'Описание тура'); return false;"
                       style="max-width:380px;text-align:left;white-space:normal;">
                        <xsl:value-of select="name"/>
                        <br/>
                        <i style="color:#a94442">
                            <xsl:value-of select="dop_info"/>
                        </i>
                    </a>
                    <div class="overview" style="display:none;">
                        <a href="#" onclick="printBlock('print_data_{position()}')"
                           class="btn btn-info glyphicon glyphicon-print"
                           style="width: initial;float: right;"/>
                        <div id="print_data_{position()}" class="printBlock">
                            <xsl:value-of select="overview" disable-output-escaping="yes"/>
                        </div>
                    </div>
                </td>
                <td style="text-align:center">
                    <xsl:if test="days > 1">
                        <xsl:value-of select="days"/>
                    </xsl:if>
                </td>
                <td style="text-align:right">
                    <xsl:if test="cost = 0"><b>звоните</b></xsl:if>
                    <xsl:if test="cost > 0">
                        <xsl:value-of select="cost"/>
                        <xsl:text> </xsl:text>
                        <xsl:if test="currency = 'руб.'"><i class="fa fa-rub" title="Рубли"/></xsl:if>
                        <xsl:if test="currency = 'у.е.'"><i class="fa fa-eur" title="у.е."/></xsl:if>
                    </xsl:if>
                </td>
                <td style="text-align:center">
                    <xsl:if test="turists = 0  and bus_size &gt;= 1">
                        <span class="text-success">Места есть</span>
                    </xsl:if>
                    <xsl:if test="turists > 0 and turists &lt; bus_size">
                        <span class="text-info">Осталось
                            <xsl:value-of select="bus_size - number(turists)"/>
                        </span>
                    </xsl:if>
                    <xsl:if test="turists >= bus_size and days=1">
                        <span class="text-danger">Лист ожидания</span>
                    </xsl:if>
                </td>
                <xsl:if test="count(//page/@xls)=0">
                    <td style="text-align:center">
                        <xsl:if test="turists &lt; bus_size">
                            <a href="#" title="Подать заявку" class="btn btn-success"
                               onclick="open_dialog('http://{//page/@host}/turs/order-{id}/','Забронировать',520,550); return false;">
                                Забронировать
                            </a>
                        </xsl:if>
                        <xsl:if test="turists >= bus_size">
                            <b class="text-primary">По запросу</b>
                        </xsl:if>
                    </td>
                </xsl:if>
            </tr>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>