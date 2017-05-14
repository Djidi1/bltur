<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'storylist']">
		<xsl:if test="//page/@isAjax != 1">
			<div id="viewListlang">
				<div class="panel panel-info">
					<div class="panel-heading">
						<a href="/tc/viewStoryList-1/edit-0/" class="btn btn-success" style="float:right">Добавить программу</a>
						<h3 style="margin: 0;">Программы туров</h3>
					</div>
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
					<table id="DataTable2" width="100%" class="data-table table table-striped  table-condensed table-hover">
							<thead>
								<tr>
									<th>Дата</th>
									<th>Страна</th>
									<th>Город</th>
									<th>Название</th>
								</tr>
							</thead>
							<tbody>
								<xsl:for-each select="story/item">
									<!--<tr onclick="var data = $('.overview_{position()}').html(); open_text(data,'Описание тура');" style="cursor:pointer">-->
									<tr onclick="window.location = '/tc/viewStoryList-1/edit-{id}/'" style="cursor:pointer">
										<td><xsl:value-of select="date"/></td>
										<td><xsl:value-of select="country"/></td>
										<td><xsl:value-of select="city"/></td>
										<td><xsl:value-of select="name"/></td>
									</tr>
								</xsl:for-each>
							</tbody>
						</table>
				<!--<xsl:for-each select="story/item">-->
					<!--<div class="overview_{position()}" style="display:none;">-->
						<!--<a href="#" onclick="printBlock('print_data_{position()}')" class="btn btn-info glyphicon glyphicon-print" style="width: initial;float: right;"/>-->
						<!--<div id="print_data_{position()}" class="printBlock">-->
							<!--<xsl:value-of select="overview" disable-output-escaping="yes"/>-->
						<!--</div>-->
					<!--</div>-->
				<!--</xsl:for-each>-->
						<script>
							<![CDATA[
						$(document).ready( function () {
						/*	$('#DataTable2').DataTable({ "language": {"url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"},
														 "columns": [{ "searchable": false },null,null,{ "searchable": false }]});*/

							// Параметры для таблицы с фиксированным заголовком
							var table_options = {language: {
							"processing": "Подождите...",
							"search": "Поиск:",
							"lengthMenu": "Показать _MENU_ записей",
							"info": "Записи с _START_ до _END_ из _TOTAL_ записей",
							"infoEmpty": "Записи с 0 до 0 из 0 записей",
							"infoFiltered": "(отфильтровано из _MAX_ записей)",
							"infoPostFix": "",
							"loadingRecords": "Загрузка записей...",
							"zeroRecords": "Записи отсутствуют.",
							"emptyTable": "В таблице отсутствуют данные",
							"paginate": {
							"first": "Первая",
							"previous": "Предыдущая",
							"next": "Следующая",
							"last": "Последняя"
							},
							"aria": {
							"sortAscending": ": активировать для сортировки столбца по возрастанию",
							"sortDescending": ": активировать для сортировки столбца по убыванию"
							}
							},
							stateSave: true,    // фиксирует запрос в строке поиска
							fixedHeader: true,  // фиксирует заголовки таблиц
							paging: false
							//                columnDefs: [
							//                    { type: 'ruDate', targets: 2 }
							//                ]
							};
							RegExp.escape = function(s) {
							return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
							};
							$(document).ready(function() {
							var sorting_table = $('.data-table').DataTable( table_options );

							var data = localStorage.getItem('DataTables_DataTable2_' + window.location.pathname);
							var saved_state = JSON.parse(data);

							$(".data-table thead th").each(function (i) {
							var col_name = $(this).html();
							if (col_name != '') {
							var select = $('<select class="form-control input-sm" style="max-width:180px !important;" data-live-search="true" onclick="event.stopPropagation();"><option value="">' + col_name + '</option></select>')
							.appendTo($(this).empty())
							.on('change', function () {
							var val = $(this).val();
							val = RegExp.escape(val);
							sorting_table.column(i)
							.search(val ? '^' + val + '$' : '', true, false)
							.draw();
							});

							var d_saved = saved_state.columns[i].search.search;
							console.log(d_saved);
							sorting_table.column(i).data().unique().sort().each(function (d) {
							var d_var = d;
							d_var = d_var.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
							var d_var = d_var ? '^' + d_var + '$' : '';
							var opt_selected = d_var == d_saved ? 'selected' : '';
							select.append('<option value="' + d + '" ' + opt_selected + '>' + d + '</option>');
							});
							}
							});
							} );

							} );]]>
						</script>
			</form>
		</div>
	</xsl:template>
</xsl:stylesheet>