<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'login']">
		<div class="form">
			<xsl:if test="login != 1">
				<xsl:call-template name="loginform"/>
			</xsl:if>
			<xsl:if test="login = 1">
				<xsl:call-template name="statusbar"/>
			</xsl:if>
		</div>
	</xsl:template>
	<xsl:template name="loginform">
		<div class="poping_links">
			<a href="#" id="openHome">Главная</a>
			<a href="javascript:;" onclick="showThem('login_pop');return false;" id="openLogin">Войти</a>
		</div>
		<div id="login_pop" style="display: none;">
			<form id="login-form" action="/?login" method="post" name="form">
				<div class="module_login">
					<div class="boxIndent">
						<div class="wrapper">
							<form action="#" method="post" id="login-form">
								<span class="msg-login">
									<xsl:value-of select="title"/>
								</span>
								<p>
									<xsl:value-of select="error"/>
								</p>
								<p id="form-login-username">
									<label for="modlgn-username">Логин</label>
									<input id="modlgn-username" type="text" name="username" class="" size="18" value="" onblur="" onfocus=""/>
								</p>
								<p id="form-login-password">
									<label for="modlgn-passwd">Пароль</label>
									<input id="modlgn-passwd" type="password" name="userpass" class="" size="18" value="" onblur="" onfocus=""/>
								</p>
								<div class="wrapper">
									<div class="create">
										<input type="submit" name="submit" value="Войти" style="padding: 5px;border-radius: 5px;"/>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</form>
		</div>
	</xsl:template>
	<xsl:template name="statusbar">
		<div class="poping_links">
			<span style="display: inline-block; padding: 0 10px;"><xsl:value-of select="error"/></span>
			<a href="?logout" id="openLogin">Выйти</a><br/>
			<a href="/admin/" style="padding-right: 0px;">Администрирование</a>
		</div>
	</xsl:template>
</xsl:stylesheet>
