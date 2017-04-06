<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="container[@module = 'turlist']">
        <xsl:if test="//page/@isAjax != 1">
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-info" style="text-align:center">
                        <h1>
                            <xsl:value-of select="@tour_name"/>
                        </h1>
                        <h3>
                            <xsl:value-of select="@tour_path"/>
                        </h3>
                    </div>
                    <div class="box-container">
                        <div class="panel panel-info" style="width:100%">
                            <!-- Default panel contents -->
                            <div class="panel-heading">Программа тура</div>
                            <div class="panel-body">
                                <xsl:value-of select="item/overview" disable-output-escaping="yes"/>
                            </div>
                        </div>
                        <div style="text-align:center">
                            <div class="btn btn-success">Заказать тур</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <a href="/turs/viewTur-1/" title="Подбор тура..." class="btn btn-warning btn-xs"
                               style="color: #fff;width: 100px;float: right;">Подбор тура
                            </a>
                            <h3 class="panel-title">Ближайшие туры</h3>
                        </div>
                        <div id="viewListlang" class="panel-body">
                            <table width="100%" class="table table-striped table-condensed table-hover"
                                   style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th/>
                                        <th/>
                                        <th>Дата</th>
                                        <th>Тур</th>
                                        <th>Места</th>
                                        <th/>
                                    </tr>
                                </thead>
                                <tbody>
                                    <xsl:for-each select="topten/item">
                                        <tr>
                                            <td style="white-space: nowrap;">
                                                <xsl:if test="tur_transport = 1">
                                                    <i class="fa fa-bus text-warning" title="Автобус"/>
                                                </xsl:if>
                                                <xsl:if test="tur_transport = 2">
                                                    <i class="fa fa-bus text-warning" title="Автобус и Паром"/>
                                                    <i class="fa fa-ship text-info" title="Автобус и Паром"/>
                                                </xsl:if>
                                                <xsl:if test="tur_transport = 3">
                                                    <i class="fa fa-train text-success" title="Поезд"/>
                                                </xsl:if>
                                                <xsl:if test="tur_transport = 4">
                                                    <i class="fa fa-plane text-danger" title="Самолет"/>
                                                </xsl:if>
                                                <xsl:if test="tur_transport = 5">
                                                    <i class="fa fa-ship text-info" title="Паром"/>
                                                </xsl:if>
                                            </td>
                                            <td>
                                                <xsl:if test="comment != ''">
                                                    <div class="btn btn-danger btn-xs" title="{comment}">
                                                        <xsl:attribute name="onclick">
                                                            var text = '<xsl:value-of select="comment_alert"/>';
                                                            <![CDATA[
												bootbox.alert(text);
												]]>
                                                        </xsl:attribute>
                                                        <span class="glyphicon glyphicon-info-sign"/>
                                                    </div>
                                                </xsl:if>
                                            </td>
                                            <td>
                                                <xsl:value-of select="tur_date"/>
                                                <xsl:if test="days > 1">
                                                    (<xsl:value-of select="days"/>)
                                                </xsl:if>
                                            </td>
                                            <td>
                                                <a href="#" title="Описание тура" class="btn btn-info fire{fire}"
                                                   onclick="var data = $(this).parent().find('.overview').html(); open_text(data,'Описание тура'); return false;"
                                                   style="max-width:340px;text-align:left;white-space:normal;font-size: 12px;">
                                                    <xsl:value-of select="tur_name"/>
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
                                                <xsl:if test="turists = 0 and bus_size &gt;= 1">
                                                    <b class="text-success">места есть</b>
                                                </xsl:if>
                                                <xsl:if test="turists > 0 and turists &lt; bus_size">
                                                    <b class="text-info">осталось
                                                        <xsl:value-of select="bus_size - number(turists)"/>
                                                    </b>
                                                </xsl:if>
                                                <xsl:if test="turists >= bus_size and days=1">
                                                    <b class="text-danger">лист ожидания</b>
                                                </xsl:if>
                                            </td>
                                            <td style="text-align:center">
                                                <xsl:value-of select="tur_cost"/><xsl:text> </xsl:text>
                                                <xsl:if test="tur_cost_curr = 'руб.'">
                                                    <i class="fa fa-rub" title="Рубли"/>
                                                </xsl:if>
                                                <xsl:if test="tur_cost_curr = 'у.е.'">
                                                    <i class="fa fa-eur" title="у.е."/>
                                                </xsl:if>
                                                <br/>
                                                <xsl:if test="turists &lt; bus_size">
                                                    <a href="#" title="Подать заявку" class="btn btn-success btn-xs"
                                                       onclick="open_dialog('/turs/order-{id}/','Забронировать',520,550); return false;">
                                                        Забронировать
                                                    </a>
                                                </xsl:if>
                                                <xsl:if test="turists >= bus_size">
                                                    <b class="text-primary">По запросу</b>
                                                </xsl:if>
                                            </td>
                                        </tr>
                                    </xsl:for-each>
                                </tbody>
                            </table>
                            <a href="/turs/viewTur-1/" title="Далее..." class="btn btn-success">Следующие даты
                                <span class="glyphicon glyphicon-arrow-right"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <br/>

            <!-- <xsl:call-template name="viewTable"/> -->
            <br/>
        </xsl:if>
        <xsl:if test="//page/@isAjax = 1">
            <xsl:call-template name="viewTable"/>
        </xsl:if>
    </xsl:template>
    <!-- НОВОСТИ НА ГЛАВНОЙ -->
    <xsl:template name="newsListIndex">
        <div class="panel panel-info arrow left small ">
            <div class="panel-heading">
                <h3 class="panel-title">Новости</h3>
            </div>
            <div class="panel-body">
                <xsl:for-each select="news/item">
                    <header class="text-left">
                        <span class="label label-info" style="float: right;">
                            <time class="comment-date" datetime="{time}">
                                <i class="fa fa-clock-o"/>
                                <xsl:text> </xsl:text><xsl:value-of select="time"/>
                            </time>
                        </span>
                        <div class="comment-user">
                            <i class="fa fa-newspaper-o"/>
                            <xsl:text> </xsl:text>
                            <strong>
                                <xsl:value-of select="title"/>
                            </strong>
                        </div>
                    </header>
                    <div class="comment-post">
                        <xsl:value-of select="content" disable-output-escaping="yes"/>
                    </div>
                    <xsl:if test="subject != ''">
                        <p class="text-right" style="margin: 0;">
                            <a href="/news/view-{id}/" class="btn btn-warning btn-xs">Подробнее<xsl:text> </xsl:text>
                                <i class="fa fa-share"/>
                            </a>
                        </p>
                    </xsl:if>
                    <hr/>
                </xsl:for-each>
            </div>
        </div>
    </xsl:template>
    <xsl:template name="viewTable">
        <div class="row demo-tiles">
            <xsl:for-each select="menu/item">
                <div class="col-xs-3">
                    <div class="tile">
                        <xsl:if test="id=4">
                            <xsl:attribute name="class">tile tile-hot</xsl:attribute>
                        </xsl:if>
                        <div class="tile-title">
                            <xsl:value-of select="name"/>
                        </div>
                        <img src="/images/menu_{id}.png" alt="{name}" class="tile-image"/>
                        <p>
                            <xsl:value-of select="desc"/>
                        </p>
                        <div class="price">цена от
                            <xsl:value-of select="cost"/>
                        </div>
                        <a class="btn btn-info btn-large btn-block" href="/turs/type-{id}/">
                            <xsl:if test="id>1">
                                <xsl:attribute name="disabled">disabled</xsl:attribute>
                                <xsl:attribute name="title">Запись приостановлена. Выбирайте туры в финляндию.
                                </xsl:attribute>
                            </xsl:if>
                            Выбрать
                        </a>
                        <!--<a class="btn btn-info btn-large btn-block" href="{url}">Выбрать</a>-->
                    </div>
                </div>
            </xsl:for-each>
        </div>
    </xsl:template>
</xsl:stylesheet>