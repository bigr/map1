<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:output method="text" version="1.0" encoding="UTF-8" indent="yes" omit-xml-declaration="no"/>



<xsl:template match="/">
    <xsl:apply-templates select="/html/body//div[@id='resultStats']"/>
</xsl:template>

<xsl:template match="div[@id='resultStats']">
    <xsl:value-of select="substring-after(text(),': ')"/>
</xsl:template>

<xsl:template match="*"/>

</xsl:stylesheet>
