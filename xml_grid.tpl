<kml xmlns="http://earth.google.com/kml/2.0">
<Document>
{foreach item=Row from=$Rows name=RowsGrid}
	<Placemark id="{$Row.IdLum}">
	<name>{$Row.TipoLuminaria}</name>
	<description><![CDATA[Id luminaria: {$Row.IdLum}<br>Colonia: {$Row.Colonia}<br>Calle: {$Row.Calle}<br>Fecha Censo: {$Row.FechaCaptura}<br><br><img src="https://emihermx.com/toluca2021/{$Row.Fotografia}">]]></description>
	<Point>
    <coordinates>{$Row.Longitude},{$Row.Latitude}</coordinates>
    </Point>
    </Placemark>
{foreach item=RowColumn key=FieldName from=$Row}
{/foreach}
{/foreach}
</Document>
</kml>
