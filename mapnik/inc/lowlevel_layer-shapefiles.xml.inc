

<Style name="nepopulated">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom1;
     <Filter>[SCALERANK]=1</Filter>
     <TextSymbolizer size="8" dy="2" fill="grey" fontset-name="book-fonts" halo-radius="1">[NAMEASCII]</TextSymbolizer>
    </Rule>
</Style>
<Style name="world">
    <Rule>
      &maxscale_zoom0;
      &minscale_zoom7;
      <PolygonSymbolizer fill="#eeeeee"/>
    </Rule>
</Style>
<Style name="coast-poly">
    <Rule>
      &maxscale_zoom7;
      <PolygonSymbolizer fill="#eeeeee"/>
    </Rule>
</Style>
  
<Style name="builtup">
    <Rule>
      &maxscale_zoom8;
      &minscale_zoom10;
      <PolygonSymbolizer fill="#ddd"/>
    </Rule>
</Style>
<Layer name="world" status="on" srs="&srs900913;">
    <StyleName>world</StyleName>
    <Datasource>
      <Parameter name="type">shape</Parameter>
      <Parameter name="file">&world_boundaries;/shoreline_300</Parameter>
    </Datasource>
</Layer>
<Layer name="coast-poly" status="on" srs="&srs900913;">
    <StyleName>coast-poly</StyleName>
    <Datasource>
      <Parameter name="type">shape</Parameter>
      <Parameter name="file">&world_boundaries;/processed_p</Parameter>
    </Datasource>
</Layer>
<Layer name="builtup" status="on" srs="&srsmercator;">
    <StyleName>builtup</StyleName>
    <Datasource>
      <Parameter name="type">shape</Parameter>
      <Parameter name="file">&world_boundaries;/builtup_area</Parameter>
    </Datasource>
</Layer>
<Layer name="necountries" status="on" srs="&srs4326;">
    <StyleName>necountries</StyleName>
    <Datasource>
      <Parameter name="type">shape</Parameter>
      <Parameter name="file">&world_boundaries;/110m_admin_0_boundary_lines_land.shp</Parameter>
    </Datasource>
</Layer>
<Layer name="nepopulated" status="on" srs="&srs4326;">
    <StyleName>nepopulated</StyleName>
    <Datasource>
      <Parameter name="type">shape</Parameter>
      <Parameter name="file">&world_boundaries;/ne_10m_populated_places.shp</Parameter>
      <Parameter name="encoding">latin1</Parameter>
    </Datasource>
</Layer>

<Style name="country_fill">
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='CZ'</Filter>   
      <PolygonSymbolizer fill="#3300bb" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='CZ'</Filter>   
      <PolygonSymbolizer fill="#3300bb" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='SK'</Filter>   
      <PolygonSymbolizer fill="#6600aa" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='SK'</Filter>   
      <PolygonSymbolizer fill="#6600aa" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='AT'</Filter>   
      <PolygonSymbolizer fill="#dd0099" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='AT'</Filter>   
      <PolygonSymbolizer fill="#dd0099" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='PL'</Filter>   
      <PolygonSymbolizer fill="#ee0000" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='PL'</Filter>   
      <PolygonSymbolizer fill="#ee0000" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='HU'</Filter>   
      <PolygonSymbolizer fill="#33EE44" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='HU'</Filter>   
      <PolygonSymbolizer fill="#33EE44" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='SI'</Filter>   
      <PolygonSymbolizer fill="#aabb00" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='SI'</Filter>   
      <PolygonSymbolizer fill="#aabb00" fill-opacity="0.23" />
    </Rule>
     <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='HR'</Filter>   
      <PolygonSymbolizer fill="#66cccc" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='HR'</Filter>   
      <PolygonSymbolizer fill="#66cccc" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='DE'</Filter>   
      <PolygonSymbolizer fill="#BB7700" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='DE'</Filter>   
      <PolygonSymbolizer fill="#BB7700" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='FR'</Filter>   
      <PolygonSymbolizer fill="#0033bb" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='FR'</Filter>   
      <PolygonSymbolizer fill="#0033bb" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='IT'</Filter>   
      <PolygonSymbolizer fill="#4499ff" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='IT'</Filter>   
      <PolygonSymbolizer fill="#4499ff" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='CH'</Filter>   
      <PolygonSymbolizer fill="#aa0000" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='CH'</Filter>   
      <PolygonSymbolizer fill="#aa0000" fill-opacity="0.23" />
    </Rule>
     <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='NL'</Filter>   
      <PolygonSymbolizer fill="#ff4400" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='NL'</Filter>   
      <PolygonSymbolizer fill="#ff4400" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='BE'</Filter>   
      <PolygonSymbolizer fill="#88BB22" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='BE'</Filter>   
      <PolygonSymbolizer fill="#88BB22" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='LU'</Filter>   
      <PolygonSymbolizer fill="#00AAFF" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='LU'</Filter>   
      <PolygonSymbolizer fill="#00AAFF" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='RO'</Filter>   
      <PolygonSymbolizer fill="#0011FF" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='RO'</Filter>   
      <PolygonSymbolizer fill="#0011FF" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='BG'</Filter>   
      <PolygonSymbolizer fill="#00CC66" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='BG'</Filter>   
      <PolygonSymbolizer fill="#00CC66" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='GR'</Filter>   
      <PolygonSymbolizer fill="#0088DD" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='GR'</Filter>   
      <PolygonSymbolizer fill="#0088DD" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='BA'</Filter>   
      <PolygonSymbolizer fill="#FFAA33" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='BA'</Filter>   
      <PolygonSymbolizer fill="#FFAA33" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='RS'</Filter>   
      <PolygonSymbolizer fill="#EE0033" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='RS'</Filter>   
      <PolygonSymbolizer fill="#EE0033" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='ME'</Filter>   
      <PolygonSymbolizer fill="#66EE00" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='ME'</Filter>   
      <PolygonSymbolizer fill="#66EE00" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='ES'</Filter>   
      <PolygonSymbolizer fill="#CC2200" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='ES'</Filter>   
      <PolygonSymbolizer fill="#CC2200" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='PT'</Filter>   
      <PolygonSymbolizer fill="#009000" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='PT'</Filter>   
      <PolygonSymbolizer fill="#009000" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='GB'</Filter>   
      <PolygonSymbolizer fill="#7700AA" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='GB'</Filter>   
      <PolygonSymbolizer fill="#7700AA" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='DK'</Filter>   
      <PolygonSymbolizer fill="#FF0055" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='DK'</Filter>   
      <PolygonSymbolizer fill="#FF0055" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='NO'</Filter>   
      <PolygonSymbolizer fill="#00EEAA" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='NO'</Filter>   
      <PolygonSymbolizer fill="#00EEAA" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='SE'</Filter>   
      <PolygonSymbolizer fill="#FFDD00" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='SE'</Filter>   
      <PolygonSymbolizer fill="#FFDD00" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='FI'</Filter>   
      <PolygonSymbolizer fill="#22BBDD" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='FI'</Filter>   
      <PolygonSymbolizer fill="#22BBDD" fill-opacity="0.23" />
    </Rule>
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom6;
      <Filter>[ISO_A2]='IE'</Filter>   
      <PolygonSymbolizer fill="#77DD00" fill-opacity="0.3" />
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[ISO_A2]='IE'</Filter>   
      <PolygonSymbolizer fill="#77DD00" fill-opacity="0.23" />
    </Rule>
</Style>

<Style name="country_boundary">
    <Rule>
        &maxscale_zoom7;
        &minscale_zoom7;
        <LineSymbolizer stroke="#8a2060" stroke-width="0.3"/>
    </Rule>
    <Rule>
        &maxscale_zoom1;
        &minscale_zoom6;
        <LineSymbolizer stroke="#674950" stroke-width="0.3"/>
    </Rule>
</Style>

<Style name="graticules">
    <Rule>
      &maxscale_zoom1;
      &minscale_zoom7;
     <LineSymbolizer stroke="#0077bb" stroke-width="0.1"/>
    </Rule>
</Style>


<Style name="country_text">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[size]='4'</Filter>
     <TextSymbolizer placement="line" size="190" dy="0" opacity="0.25" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[size]='3'</Filter>
     <TextSymbolizer placement="line" size="120" dy="0" opacity="0.27" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[size]='2'</Filter>
     <TextSymbolizer placement="line" size="70" dy="0" opacity="0.29" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[size]='1'</Filter>
     <TextSymbolizer placement="line" size="40" dy="0" opacity="0.31" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[size]='0'</Filter>
     <TextSymbolizer placement="line" size="25" dy="0" opacity="0.33" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>    
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[size]='4'</Filter>
     <TextSymbolizer placement="line" size="95" dy="0" opacity="0.30" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[size]='3'</Filter>
     <TextSymbolizer placement="line" size="60" dy="0" opacity="0.33" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[size]='2'</Filter>
     <TextSymbolizer placement="line" size="35" dy="0" opacity="0.36" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[size]='1'</Filter>
     <TextSymbolizer placement="line" size="20" dy="0" opacity="0.39" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[size]='0'</Filter>
     <TextSymbolizer placement="line" size="13" dy="0" opacity="0.44" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule> 
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[size]='4'</Filter>
     <TextSymbolizer placement="line" size="48" dy="0" opacity="0.36" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[size]='3'</Filter>
     <TextSymbolizer placement="line" size="30" dy="0" opacity="0.40" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[size]='2'</Filter>
     <TextSymbolizer placement="line" size="17" dy="0" opacity="0.50" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[size]='1'</Filter>
     <TextSymbolizer placement="line" size="13" dy="0" opacity="0.60" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[text]</TextSymbolizer>
    </Rule>
</Style>

<Style name="urb_text1">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[population].match('[3456789]\d\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="35" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[name]</TextSymbolizer>     
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[population].match('[3456789]\d\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="27" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[name]</TextSymbolizer>     
    </Rule>
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[population].match('[3456789]\d\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="23" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1">[name]</TextSymbolizer>     
    </Rule>
</Style>
<Style name="urb_text2">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[population].match('[12]\d\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="30" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[name]</TextSymbolizer>     
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[population].match('[12]\d\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="23" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1" text-transform="uppercase">[name]</TextSymbolizer>     
    </Rule>
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[population].match('[12]\d\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="20" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1">[name]</TextSymbolizer>     
    </Rule>
</Style>
<Style name="urb_text3">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[population].match('[6789]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="27" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)" text-transform="uppercase">[name]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[population].match('[6789]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="21" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[population].match('[6789]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="18" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
</Style>
<Style name="urb_text4">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[population].match('[345]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="24" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)" text-transform="uppercase">[name]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[population].match('[345]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="18" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[population].match('[345]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="14" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
</Style>
<Style name="urb_text5">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[population].match('[12]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="21" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)" text-transform="uppercase">[name]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[population].match('[12]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="16" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom5;
      &minscale_zoom5;
      <Filter>[population].match('[12]\d\d\d\d\d')</Filter>   
     <TextSymbolizer size="12" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="2" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
</Style>
<Style name="urb_text6">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[population].match('[6789]\d\d\d\d')</Filter>    
     <TextSymbolizer size="19" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
    <Rule>
      &maxscale_zoom6;
      &minscale_zoom6;
      <Filter>[population].match('[6789]\d\d\d\d')</Filter>    
     <TextSymbolizer size="13" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
</Style>
<Style name="urb_text7">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[population].match('[345]\d\d\d\d')</Filter>    
     <TextSymbolizer size="17" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>
    
</Style>
<Style name="urb_text8">
    <Rule>
      &maxscale_zoom7;
      &minscale_zoom7;
      <Filter>[population].match('[2]\d\d\d\d')</Filter>    
     <TextSymbolizer size="13" dy="0" fill="#000000" fontset-name="bold-fonts" halo-radius="1" halo-fill="rgba(255,255,255,0.4)">[name]</TextSymbolizer>
    </Rule>    
</Style>




<Layer name="countries" status="on" srs="&srs4326;">    
    <StyleName>country_fill</StyleName>
    <StyleName>country_boundary</StyleName>
    <Datasource>
      <Parameter name="type">shape</Parameter>
      <Parameter name="file">&lowlevel_shapefile;/ne_10m_admin_0_countries.shp</Parameter>      
    </Datasource>
</Layer>



<Layer name="graticules" status="on" srs="&srs4326;">        
    <StyleName>graticules</StyleName>
    <Datasource>
      <Parameter name="type">shape</Parameter>
      <Parameter name="file">&lowlevel_shapefile;/ne_10m_graticules_1.shp</Parameter>      
    </Datasource>
</Layer>

<Layer name="country_text" status="on" srs="&srs4326;">        
    <StyleName>country_text</StyleName>
    <Datasource>
			<Parameter name="type">osm</Parameter>
			<Parameter name="file">&lowlevel_shapefile;/countries.osm</Parameter>
		</Datasource>
</Layer>


<Layer name="urbs" status="on" srs="&srs4326;" clear-label-cache="on">        
    <StyleName>urb_text1</StyleName>
    <StyleName>urb_text2</StyleName>
    <StyleName>urb_text3</StyleName>
    <StyleName>urb_text4</StyleName>
    <StyleName>urb_text5</StyleName>
    <StyleName>urb_text6</StyleName>
    <StyleName>urb_text7</StyleName>
    <StyleName>urb_text8</StyleName>
    <Datasource>
      <Parameter name="type">osm</Parameter>
      <Parameter name="file">&lowlevel_shapefile;/urb.osm</Parameter>      
    </Datasource>
</Layer>

