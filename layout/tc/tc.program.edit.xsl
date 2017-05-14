<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="container[@module = 'program']">
        <form action="" method="post" class="row">
            <input type="hidden" name="id_program" value="{item/id}"/>
            <div class="form-group">
                <label style="width: 100%;">Заголовок
                    <input type="text" name="name" class="form-control" value="{item/name}"/>
                </label>
            </div>
            <div class="form-group">
                <label style="width: 100%;">Город
                    <input type="text" name="city" class="form-control" value="{item/city}"/>
                </label>
            </div>
            <div class="form-group">
                <label style="width: 100%;">Страна
                    <input type="text" name="country" class="form-control" value="{item/country}"/>
                </label>
            </div>
            <div class="form-group">
                <label>Текст</label>
                <textarea class="ckeditor content_edit form-control" name="overview" style="width:100%">
                    <xsl:value-of select="item/overview" disable-output-escaping="yes"/>
                </textarea>
            </div>
            <div class="text-muted small" style="text-align: right">
                Последние изменения программы:
                <xsl:value-of select="item/date"/>
            </div>
            <input type="submit" name="sub_action" value="Сохранить" class="btn btn-success"/>
            <input type="submit" name="sub_action" value="Удалить" class="btn btn-danger" style="float:right;" onclick="return confirm('Удалить эту программу тура?')"/>
        </form>
    </xsl:template>
</xsl:stylesheet>