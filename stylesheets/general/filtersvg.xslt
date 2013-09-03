<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
	version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:svg="http://www.w3.org/2000/svg">

<xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes" omit-xml-declaration="no"/>

<xsl:template match="svg:svg">
    <xsl:element name="svg" namespace="http://www.w3.org/2000/svg">
	<xsl:attribute name="width">$size</xsl:attribute>
	<xsl:attribute name="height">$size</xsl:attribute>
	<xsl:attribute name="viewBox">0 0 26880 26880</xsl:attribute>	
	
	<xsl:text>$pre</xsl:text>
	<xsl:apply-templates select="svg:path|svg:g"/>
	<xsl:text>$post</xsl:text>
    </xsl:element>
</xsl:template>

<xsl:template match="svg:g">
    <xsl:element name="g" namespace="http://www.w3.org/2000/svg">
	<xsl:apply-templates select="@transform"/>
	<xsl:apply-templates select="@style"/>	
	<xsl:apply-templates select="svg:path|svg:g"/>
    </xsl:element>
</xsl:template>
    
<xsl:template match="svg:path[@d = '']"/>
    
<xsl:template match="svg:path">
    <xsl:element name="path" namespace="http://www.w3.org/2000/svg">
	<xsl:apply-templates select="@style"/>	
	<xsl:apply-templates select="@d"/>
	<xsl:apply-templates select="@transform"/>
    </xsl:element>
</xsl:template>


<xsl:template match="@style">
    <xsl:attribute name="style">
	<xsl:call-template name="string-replace-all">
	    <xsl:with-param name="text">
		<xsl:call-template name="string-replace-all">
		  <xsl:with-param name="text">
		      <xsl:call-template name="string-replace-all">
			<xsl:with-param name="text" select="."/>
			<xsl:with-param name="replace" select="'fill:#000000'"/>
			<xsl:with-param name="by" select="'fill:$color'"/>
		      </xsl:call-template>	
		  </xsl:with-param>
		  <xsl:with-param name="replace" select="'fill-opacity:1'"/>
		  <xsl:with-param name="by" select="'fill-opacity:$opacity'"/>
		</xsl:call-template>
	    </xsl:with-param>
	    <xsl:with-param name="replace" select="'stroke:#000000'"/>
	    <xsl:with-param name="by" select="'stroke:none'"/>
	</xsl:call-template>
    </xsl:attribute>
</xsl:template>

<xsl:template match="@*">
    <xsl:copy>
        <xsl:apply-templates select="@*"/>
    </xsl:copy>
</xsl:template>

<xsl:template name="string-replace-all">
  <xsl:param name="text"/>
  <xsl:param name="replace"/>
  <xsl:param name="by"/>
  <xsl:choose>
    <xsl:when test="contains($text,$replace)">
      <xsl:value-of select="substring-before($text,$replace)"/>
      <xsl:value-of select="$by"/>
      <xsl:call-template name="string-replace-all">
        <xsl:with-param name="text" select="substring-after($text,$replace)"/>
        <xsl:with-param name="replace" select="$replace"/>
        <xsl:with-param name="by" select="$by"/>
      </xsl:call-template>
    </xsl:when>
    <xsl:otherwise>
      <xsl:value-of select="$text"/>
    </xsl:otherwise>
  </xsl:choose>
</xsl:template>


</xsl:stylesheet>
