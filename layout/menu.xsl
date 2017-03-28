<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="container[@module = 'menu_mainmenu']">
		<div id="{@module }" class="menu">
			<h3>Меню</h3>
			<ul>
				<xsl:apply-templates select="items/menuitem"/>
			</ul>
		</div>
	</xsl:template>
	
	<xsl:template match="container[@module = 'mainmenu']">
		<xsl:apply-templates select="items/menuitem"/>
	</xsl:template>

	<xsl:template match="container[@module = 'menu_services']">
	<div id="{@module }" class="menu">
			<ul>
				<xsl:apply-templates select="items/menuitem"/>
			</ul>
		</div>
	</xsl:template>
	<xsl:template match="container[@module = 'menu_about']">
		<div id="{@module }" class="menu">
			<ul>
				<xsl:apply-templates select="items/menuitem"/>
			</ul>
		</div>
	</xsl:template>
	
	<xsl:template match="container[@module = 'edit_menu']">	
		<div id="{@module}" class="menu">
		<p><a href="http://{//page/@host}/menu/viewadm-1/">menu</a></p>
			<h3>
				<a href="http://{//page/@host}/menu/viewmenu-1/menu-{items/@menuCodename}/">
					<xsl:value-of select="items/@menutitle"/>
				</a>
			</h3>
			<p class="addr">
				<a href="http://{//page/@host}/menu/editroot-1/menu-{items/@id}/">
					Редактировать
				</a>
			<a href="http://{//page/@host}/menu/newnode-1/root_id-{items/@id}/">
					добавить пункт
				</a></p>
			<ul>
				<xsl:apply-templates select="items/menuadminitem"/>
			</ul>
		</div>
	</xsl:template>
	<xsl:template match="container[@module = 'mainmenu']">
		<xsl:apply-templates select="items/menuitem"/>
	</xsl:template>
	<xsl:template match="menuadminitem">
		<li>
			<b><a href="http://{//page/@host}/{module}/{queryString}" title="{title}">
				<xsl:value-of select="title"/>
			</a></b>
			<xsl:text> </xsl:text>
			<a href="http://{//page/@host}/menu/editnode-1/node_id-{id}/root_id-{root_id}/" title="изменить">изменить</a>
			<xsl:text> </xsl:text>
			<a href="http://{//page/@host}/menu/delnode-1/node_id-{id}/root_id-{root_id}/" title="изменить">удалить</a>
			<xsl:text> </xsl:text>
			<a href="http://{//page/@host}/menu/newnode-1/node_id-{id}/root_id-{root_id}/" title="изменить">подпункт</a>
			<xsl:if test="count(items/item) != 0">
				<ul>
					<xsl:apply-templates select="items/menuadminitem"/>
				</ul>
			</xsl:if>
		</li>
	</xsl:template>
	<xsl:template match="menuitem">
		<li>
			<xsl:attribute name="id">item_<xsl:value-of select="codename"/>_<xsl:value-of select="count(module/container/image[@inp = 'menuItem'])"/></xsl:attribute>
			<xsl:if test="isActive = '1'">
				<xsl:attribute name="class">active</xsl:attribute>
			</xsl:if>
			<a href="http://{//page/@host}/{module}/{queryString}mi-{id}/" title="{title}">
			
			<xsl:if test="count(module/container/image[@inp = 'menuItem']) != 0">
				<xsl:variable name="src" select="module/container/image[@inp = 'menuItem']/codename"/>
				<img alt="{title}" src="http://{//page/@host}/image/image-{$src}" />
			</xsl:if>
			<xsl:if test="count(module/container/image[@inp = 'menuItem']) = 0">
				<xsl:value-of select="title"/>
			</xsl:if>				
			</a>
			<xsl:if test="count(items/item) != 0">
				<ul>
					<xsl:apply-templates select="items/menuitem"/>
				</ul>
			</xsl:if>
		</li>
	</xsl:template>
</xsl:stylesheet>
