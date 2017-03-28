<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'grouplist']">
		<style type="">
	tr.selected {background-color: #EDEDED;}
	</style>
		<div id="cpanel">
			<table class="adminform" width="100%">
				<tbody>
					<tr>
						<td valign="top">
							<h2>Список групп</h2>
							<div style="float: left;">
								<div class="icon">
									<a href="http://{//page/@host}/admin/groupNew-1/">
										<img src="/images/icon-48-groups.png" alt="Создать группу"/>
										<span>Создать группу</span>
									</a>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div>
			<table cellpadding="3" cellspacing="1" border="0" width="100%">
				<tbody>
					<tr bgcolor="#B0C4DE">
						<th>ID</th>
						<th>Название</th>
						<th align="center" colspan="4">*</th>
					</tr>
					<xsl:for-each select="groups/item">
						<tr onmouseout="this.className = 'darck';" onmouseover="this.className = 'selected';" class="darck">
							<xsl:attribute name="bgcolor"><xsl:if test="position() mod 2 =1">#EDF7FE</xsl:if><xsl:if test="position() mod 2 =0">#E4F2FD</xsl:if></xsl:attribute>
							<td>
								<xsl:value-of select="id"/>
							</td>
							<td>
								<xsl:value-of select="name"/>
							</td>
							<td align="center" width="40px">
								<a href="http://{//page/@host}/admin/userList-1/idg-{id}/" title="список пользователей">
									<img alt="список" src="/images/list.png" border="0"/>
								</a></td>
							<td align="center" width="40px">
								<a href="http://{//page/@host}/admin/groupEdit-{id}/" title="редактировать">
									<img alt="редактировать" src="/images/edit.png" border="0"/>
								</a></td>
							<td align="center" width="40px">
								<a href="http://{//page/@host}/admin/groupRightsAdmin-{id}/" title="права">
									<img alt="права" src="/images/list_keys.gif" border="0"/>
								</a></td>
							<td align="center" width="40px">
								<a href="http://{//page/@host}/admin/groupHide-{id}/" title="удалить">
									<img alt="удалить" src="/images/del.png" border="0"/>
								</a>
							</td>
						</tr>
					</xsl:for-each>
				</tbody>
			</table>
			<xsl:call-template name="linkback"/>
		</div>
	</xsl:template>
</xsl:stylesheet>
