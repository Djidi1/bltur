<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'storylist']">
		<xsl:if test="//page/@isAjax != 1">
			<div id="viewListlang">
				<div class="panel panel-info">
					<div class="panel-heading"><h3 style="margin: 0;">Программы туров</h3></div>
					<div class="panel-body">
						<xsl:call-template name="viewTable"/>
					</div>
				</div>
			</div>
		</xsl:if>
		<xsl:if test="//page/@isAjax = 1">
			<xsl:call-template name="viewTable"/>
		</xsl:if>
	</xsl:template>
	<xsl:template name="viewTable">
		<div>
			<form name="app_form" style="margin:0px" method="post" action="" id="printlist">
					<table id="DataTable2" width="100%" class="table table-striped  table-condensed table-hover">
							<thead>
								<tr>
									<th>Дата</th>
									<th>Страна</th>
									<th>Название</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<xsl:for-each select="story/item">
									<tr>
										<td><xsl:value-of select="date"/></td>
										<td><xsl:value-of select="country"/></td>
										<td><xsl:value-of select="name"/></td>
										<td>
										<a href="#" title="Описание тура" class="btn btn-info fire{fire}" onclick="var data = $(this).parent().find('.overview').html(); open_text(data,'Описание тура'); return false;" style="max-width:340px;text-align:left;white-space:normal;">
												<span class="glyphicon glyphicon-eye-open" />
											</a>
											<div class="overview" style="display:none;">
												<a href="#" onclick="printBlock('print_data_{position()}')" class="btn btn-info glyphicon glyphicon-print" style="width: initial;float: right;"/>
												<div id="print_data_{position()}" class="printBlock">
													<xsl:value-of select="overview" disable-output-escaping="yes"/>
												</div>
											</div>
										</td>
										<td>
											<a href="/tc/viewStoryList-1/edit-{id}" class="btn btn-success" target="_blank"><span class="glyphicon glyphicon-pencil" /></a>
										</td>
									</tr>
								</xsl:for-each>
							</tbody>
						</table>
						<script>
						$(document).ready( function () {
							$('#DataTable2').DataTable({ "language": {"url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"},
														 "columns": [{ "searchable": false },null,null,{ "searchable": false }]});
						} );
						</script>
			</form>
		</div>
	</xsl:template>
</xsl:stylesheet>