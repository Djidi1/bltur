<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'adminmain']">
		<div id="cpanel">
			<table class="adminform" align="center" style="margin: 0 auto;">
				<tbody>
					<tr>
						<td valign="top">
							<h2>Управление турами</h2>
							
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/tc/">
										<img src="/images/icon-48-tourist.png" alt="Туристы"/>
										<span>Туристы</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/tc/viewTur-1/">
										<img src="/images/icon-48-language.png" alt="Туры"/>
										<span>Туры</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/tc/viewTurList-1/">
										<img src="/images/icon-48-test.png" alt="Списки"/>
										<span>Списки</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/tc/viewAgentReportList-1/">
										<img src="/images/icon-48-section.png" alt="Списки"/>
										<span>Агентства</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/tc/search_order-1/">
										<img src="/images/icon-48-search-tourist.png" alt="Поиск"/>
										<span>Поиск</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/tc/dobList-1/">
										<img src="/images/icon-48-install.png" alt="Дни рожденья"/>
										<span>Дни рожденья</span>
									</a>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<h2>Дополнительно</h2>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/pages/">
										<img src="/images/icon-48-article.png" alt="Страницы"/>
										<span>Страницы</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="/news/newsadmin-1/">
										<img src="/images/icon-48-news.png" alt="Новости"/>
										<span>Новости</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="/tc/viewStoryList-1/">
										<img src="/images/icon-48-menumgr.png" alt="Список Программ"/>
										<span>Программы</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/tc/LocList-1/">
										<img src="/images/icon-48-category.png" alt="Районы"/>
										<span>Районы</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/email/">
										<img src="/images/icon-48-mail.png" alt="Email рассылка"/>
										<span>Рассылка</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/email/viewlist-1">
										<img src="/images/icon-48-mail.png" alt="Email подписчики"/>
										<span>Подписчики</span>
									</a>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<h2>Системные настройки</h2>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/admin/userList-1/">
										<img src="/images/icon-48-user.png" alt="Пользователи"/>
										<span>Пользователи</span>
									</a>
								</div>
							</div>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/admin/groupList-1/">
										<img src="/images/icon-48-groups.png" alt="Группы"/>
										<span>Группы</span>
									</a>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<xsl:call-template name="linkback"/>
		</div>
	</xsl:template>
</xsl:stylesheet>
