<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="container[@module = 'search']">
        <xsl:call-template name="search-item"/>
    </xsl:template>
    <xsl:template name="search-item">
        <div id="ya-site-results">
            <xsl:attribute name="onclick">return {'tld': 'ru','language': 'ru','encoding': '','htmlcss': '1.x','updatehash': true}</xsl:attribute>
        </div>
        <script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0];s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Results.init();})})(window,document,'yandex_site_callbacks');</script>

    </xsl:template>
</xsl:stylesheet>
