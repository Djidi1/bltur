<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'groupnew']">
		<div>
		<div id="cpanel">
			<table class="adminform" align="center">
				<tbody>
					<tr>
						<td valign="top">
						
							<h2>Создать группу:</h2>
			<form action="http://{//page/@host}/admin/groupAdd-1/" method="post">
				<table>
					<tbody>
						<tr>
							<td>Название (rus):</td>
							<td><input type="text" name="name_ru" /> </td>
						</tr>
						<tr>
							<td>Название (eng):</td>
							<td><input type="text" name="name_en" /> </td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="создать" name="submit"/></td>
						</tr>				
					</tbody>
				</table>
			</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
			
		</div>
		<xsl:call-template name="linkback"/>
	</xsl:template>
</xsl:stylesheet>
