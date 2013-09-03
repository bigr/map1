<xsl:stylesheet
   version="2.0"
   xmlns:xsl="http://www.w3.org/1999/XSL/Transform"    
   xmlns:r="http://map1.eu/xmlns/gpx-report/1.0"
   xmlns:xs="http://www.w3.org/2001/XMLSchema" 
>
  <xsl:output
    indent="yes" 
    cdata-section-elements="style"
    doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
    doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"
    />    

  <xsl:template match="r:gpx-report">
    <html>
      <head>
        <link rel="stylesheet" type="text/css" href="style.css"/>        
      </head>
      <body>
        <h1><xsl:value-of select="@name"/></h1>
        <xsl:apply-templates select="r:profile" />
        <xsl:apply-templates select="r:uphill_stats" />
        <xsl:apply-templates select="r:uphills" />
      </body>
    </html>
  </xsl:template>
  
  <xsl:template match="r:profile">
      <xsl:variable name="l" select="@l div 100"/>
      <svg height="450" width="{$l + 150}" class="profile trip">                
        <xsl:apply-templates select="r:pt" />        
        <xsl:apply-templates select="../r:uphills/r:uphill" mode="trip" />      
        <path d="M 50,400 L {$l + 50},400" class="axis axis-x"/>
        <path d="M 50,0 L 50,405" class="axis axis-y"/>        
        
        <path d="M 50,{400 - @z1 div 4} L {$l + 60}, {400 - @z1 div 4}" class="marker marker-x"/>
        <path d="M {$l + 50},{400 - @z2 div 4} L {$l + 60}, {400 - @z2 div 4}" class="marker marker-x"/>
        <path d="M {$l + 60}, {400 - @z1 div 4} L {$l + 60}, {400 - @z2 div 4}" class="kvote"/>
        <text x="{$l + 100}" y="{400 - (@z1 + @z2) div 8}" class="elevation"><xsl:value-of select="@h" />m</text>
        <text x="{$l + 100}" y="{400 - (@z1 + @z2) div 8 + 15}" class="global-slope">(<xsl:value-of select="@s" />%)</text>
        
        <text x="30" y="390" class="units">[m]</text>        
        <text x="70" y="420" class="units">[km]</text>
               
        <xsl:for-each select="1 to xs:integer(floor(@l div 10000))">
          <xsl:variable name="x" select=". * 100 + 50"/>
          <path d="M {$x}, 398 L {$x}, 405" class="axis-tick axis-tick-y"/>
          <path d="M {$x}, 0 L {$x}, 398" class="grid grid-y"/>
          <text x="{$x}" y="420" class="axis-label axis-y-label"><xsl:value-of select=". * 10" /></text>          
        </xsl:for-each>
        
        
        <xsl:for-each select="1 to 7">
          <xsl:variable name="y" select=". * 50"/>
          <path d="M 45, {$y} L 53, {$y}" style="axis-tick axis-tick-x" />
          <path d="M 53, {$y} L {$l + 50}, {$y}" class="grid grid-x"/>
          <text x="40" y="{$y}" class="axis-label axis-x-label"><xsl:value-of select="(8 - .) * 200" /></text>          
        </xsl:for-each> 
      </svg>   
  </xsl:template>
  
  <xsl:template match="r:profile/r:pt"> 
    <xsl:variable name="last" select="preceding-sibling::r:pt[1]"/>
    <path d="M {$last/@m div 100 + 50}, {400 - $last/@z div 4} L {@m div 100 + 50},{400 - @z div 4}" class="profile-contour"/>
    <xsl:if test="@label">
      <path d="M {@m div 100 + 50}, {400 - @z div 4} L {@m div 100 + 50},{400 - @z div 4 - 25}" class="waypoint-marker"/>
      <text x="{@m div 100 + 50}" y="{400 - @z div 4 - 30}" transform="rotate(-90,{@m div 100 + 50},{400 - @z div 4 - 30})" class="waypoint"><xsl:value-of select="@label"/></text>         
    </xsl:if>
  </xsl:template>
  
  <xsl:template match="r:uphill" mode="trip">
    
    <path d="M {@m1 div 100 + 50}, {(1600-@z1) div 4} L {@m1 div 100 + 50},400" class="marker marker-y"/>   
    <path d="M {@m2 div 100 + 50}, {(1600-@z2) div 4} L {@m2 div 100 + 50},400" class="marker marker-y"/> 
    
    
    <circle cx="{@m1 div 200 + @m2 div 200 + 50}" cy="360" r="{@h div 50 + 10}" class="uphill-number"/>
    <text x="{@m1 div 200 + @m2 div 200 + 50}" y="360" class="uphill-number" style="font-size: {@h div 50 + 13}px"><xsl:value-of select="position()"/></text>   
    
  </xsl:template>
  
  <xsl:template match="r:uphill_stats">
    <svg height="400" width="{count(r:uphill_stat) * 60}" class="profile trip">   
      <xsl:apply-templates select="r:uphill_stat" />
    </svg>
  </xsl:template>
  <xsl:template match="r:uphill_stat">
    <rect x="{count(../r:uphill_stat) * 60 - (position() - 1) * 60}" y="{400 - @h div 3}" width="60" height="{@h div 3}" style="stroke: #000; stroke-width: 0.1px; fill: {@c}"/>
    <circle cx="{count(../r:uphill_stat) * 60 - (position() - 1) * 60 + 30}" cy="{400 - @h div 3 - 55}" r="20" class="uphillstat-number"/>
    <text x="{count(../r:uphill_stat) * 60 - (position() - 1) * 60 + 30}" y="{400 - @h div 3 - 55}" class="uphillstat-number"><xsl:value-of select="@i"/></text> 
    <text x="{count(../r:uphill_stat) * 60 - (position() - 1) * 60 + 30}" y="{400 - @h div 3 - 25}" class="uphillstat-height"><xsl:value-of select="@h"/>m</text> 
    <text x="{count(../r:uphill_stat) * 60 - (position() - 1) * 60 + 30}" y="{400 - @h div 3 - 10}" class="uphillstat-slope">(<xsl:value-of select="@s"/>%)</text> 
  </xsl:template>
  
  <xsl:template match="r:uphills">
    <br /><br /><br /><br />
    <ul id="uphills">
      <xsl:apply-templates select="r:uphill" />
    </ul>
  </xsl:template>
  
  <xsl:template match="r:uphill">
    <xsl:variable name="l" select="@l div 10"/>
    <li style="float: left; list-style-type: none;">      
      <svg height="450" width="{$l + 200}" class="profile uphill">        
        <xsl:apply-templates select="r:seg" />
        <path d="M 50,400 L {@l div 10 + 50},400" class="axis axis-x"/>
        <path d="M 50,0 L 50,405" class="axis axis-y"/>        
        
        <path d="M 50,{400 - @z1 div 4} L {$l + 60}, {400 - @z1 div 4}" class="marker marker-x"/>
        <path d="M {$l + 50},{400 - @z2 div 4} L {$l + 60}, {400 - @z2 div 4}" class="marker marker-x"/>
        <path d="M {$l + 60}, {400 - @z1 div 4} L {$l + 60}, {400 - @z2 div 4}" class="kvote"/>
        <text x="{$l + 100}" y="{400 - (@z1 + @z2) div 8}" class="elevation"><xsl:value-of select="@h" />m</text>
        <text x="{$l + 100}" y="{400 - (@z1 + @z2) div 8 + 15}" class="global-slope">(<xsl:value-of select="@s" />%)</text>
        
        <text x="30" y="390" class="units">[m]</text>        
        <text x="70" y="420" class="units">[m]</text>
               
        <xsl:for-each select="1 to xs:integer(floor(@l div 1000))">
          <xsl:variable name="x" select=". * 100 + 50"/>
          <path d="M {$x}, 398 L {$x}, 405" class="axis-tick axis-tick-y"/>
          <path d="M {$x}, 0 L {$x}, 398" class="grid grid-y"/>
          <text x="{$x}" y="420" class="axis-label axis-y-label"><xsl:value-of select=". * 1000" /></text>          
        </xsl:for-each>
        
        
        <xsl:for-each select="1 to 7">
          <xsl:variable name="y" select=". * 50"/>
          <path d="M 45, {$y} L 53, {$y}" style="axis-tick axis-tick-x" />
          <path d="M 53, {$y} L {$l + 50}, {$y}" class="grid grid-x"/>
          <text x="40" y="{$y}" class="axis-label axis-x-label"><xsl:value-of select="(8 - .) * 200" /></text>          
        </xsl:for-each>                        
        
        <circle cx="80" cy="30" r="22" class="uphill-number"/>
        <text x="80" y="30" class="uphill-number"><xsl:value-of select="position()"/></text>  
        <text x="180" y="25" class="uphill-position"><xsl:value-of select="format-number(@m1 div 1000,'#0.0')"/> - <xsl:value-of select="format-number(@m2 div 1000,'#0.0')"/> km</text>
        <text x="180" y="45" class="uphill-length">(<xsl:value-of select="format-number((@m2 - @m1) div 1000,'#0.00')"/>km)</text>
      </svg>
    </li>
  </xsl:template>
  
  <xsl:template match="r:uphill/r:seg">    
    <path d="M {@m1 div 10 + 50},400 L {@m1 div 10 + 50},{400 - @z1 div 4} L {@m2 div 10 + 50},{400 - @z2 div 4} L {@m2 div 10 + 50},400 z" style="fill: {@c}; stroke: none"/>
    <path d="M {@m1 div 10 + 50},{400-@z1 div 4} L {@m2 div 10 + 50},{400-@z2 div 4}" class="profile-contour"/>
    <path d="M {@m1 div 10 + 50},400 L {@m1 div 10 + 50},{400 - @z1 div 4} M {@m2 div 10 + 50},400 L {@m2 div 10 + 50},{400 - @z2 div 4} z" class="marker marker-y"/>    
    <text x="{@m1 div 20 + @m2 div 20 + 50}" y="{(3200 - @z2 -@z1) div 8 - 10}" transform="rotate(-90,{@m1 div 20 + @m2 div 20 + 50},{(3200 - @z2 -@z1) div 8 - 10})" class="slope-segment"><xsl:value-of select="@s"/>%</text>
  </xsl:template>    
  
</xsl:stylesheet>
