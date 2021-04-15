<kml xmlns="http://earth.google.com/kml/2.0">
<Document>
<?php $_from = $this->_tpl_vars['Rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['RowsGrid'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['RowsGrid']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Row']):
        $this->_foreach['RowsGrid']['iteration']++;
?>
	<Placemark id="<?php echo $this->_tpl_vars['Row']['IdLum']; ?>
">
	<name><?php echo $this->_tpl_vars['Row']['TipoLuminaria']; ?>
</name>
	<description><![CDATA[Id luminaria: <?php echo $this->_tpl_vars['Row']['IdLum']; ?>
<br>Colonia: <?php echo $this->_tpl_vars['Row']['Colonia']; ?>
<br>Calle: <?php echo $this->_tpl_vars['Row']['Calle']; ?>
<br>Fecha Censo: <?php echo $this->_tpl_vars['Row']['FechaCaptura']; ?>
<br><br><img src="https://emihermx.com/toluca2021/<?php echo $this->_tpl_vars['Row']['Fotografia']; ?>
">]]></description>
	<Point>
    <coordinates><?php echo $this->_tpl_vars['Row']['Longitude']; ?>
,<?php echo $this->_tpl_vars['Row']['Latitude']; ?>
</coordinates>
    </Point>
    </Placemark>
<?php $_from = $this->_tpl_vars['Row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FieldName'] => $this->_tpl_vars['RowColumn']):
?>
<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
</Document>
</kml>