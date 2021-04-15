<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml">
	<head>
		<title>GPS data</title>
		<base target="_top"></base>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta name="geo.position" content="0; 22.7551875" />
		<meta name="ICBM" content="0, 22.7551875" />
	</head>
	<body style="margin:0px;">
		
		<script type="text/javascript">
<?php echo '		
			API = \'google\'; 
			if (self.API && API == \'google\') {
				google_api_key = \'AIzaSyDkpIzOsRl7g4pHH-8ewDWVHXNn14uODd8\'; 
				language_code = \'\';
				document.writeln(\'<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&amp;libraries=geometry&amp;language=\'+(self.language_code?self.language_code:\'\')+\'&amp;key=\'+(self.google_api_key?self.google_api_key:\'\')+\'"><\'+\'/script>\');
			} else {
				document.writeln(\'<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />\');
				document.writeln(\'<script type="text/javascript" src="https://unpkg.com/leaflet/dist/leaflet.js"><\'+\'/script>\');
			}
			thunderforest_api_key = \'\';
'; ?>
			
		</script>

		<div style="margin-left:0px; margin-right:0px; margin-top:0px; margin-bottom:0px;">
			<div id="gmap_div" style="width:700px; height:700px; margin:0px; margin-right:12px; background-color:#f0f0f0; float:left; overflow:hidden;">
				<p style="text-align:center; font:10px Arial;">Censo de Alumbrado<a target="_blank" href="https://serviciostecnicosprofesionales.com">2019</a> Derechos Reservados<br /><br />Espere mientras carga el mapa...</p>
			</div>
				
			<div id="gv_infobox" class="gv_infobox" style="font:11px Arial; border:solid #666666 1px; background-color:#ffffff; padding:4px; overflow:auto; display:none; max-width:400px;">
				
			</div>



			<div id="gv_marker_list" class="gv_marker_list" style="background-color:#ffffff; overflow:auto; display:none;"><!-- --></div>

			<div id="gv_clear_margins" style="height:0px; clear:both;"></div>
		</div>

		
		
		<script type="text/javascript">
<?php echo '			
			gv_options = {};
			
			
			gv_options.center = [19.20,-99.52];  // [latitude,longitude] - be sure to keep the square brackets
			gv_options.zoom = \'auto\';  // higher number means closer view; can also be \'auto\' for automatic zoom/center based on map elements
			gv_options.map_type = \'GV_OSM\';  // popular map_type choices are \'GV_STREET\', \'GV_SATELLITE\', \'GV_HYBRID\', \'GV_TERRAIN\', \'GV_OSM\', \'GV_TOPO_US\', \'GV_TOPO_WORLD\' (https://www.gpsvisualizer.com/misc/google_map_types.html)
			gv_options.map_opacity = 1.00;  // number from 0 to 1
			gv_options.full_screen = true;  // true|false: should the map fill the entire page (or frame)?
			gv_options.width = 1200;  // width of the map, in pixels
			gv_options.height = 600;  // height of the map, in pixels
			
			gv_options.map_div = \'gmap_div\';  // the name of the HTML "div" tag containing the map itself; usually \'gmap_div\'
			gv_options.doubleclick_zoom = true;  // true|false: zoom in when mouse is double-clicked?
			gv_options.doubleclick_center = true;  // true|false: re-center the map on the point that was double-clicked?
			gv_options.scroll_zoom = true; // true|false; or \'reverse\' for down=in and up=out
			gv_options.page_scrolling = true; // true|false; does the map relenquish control of the scroll wheel when embedded in scrollable pages?
			gv_options.autozoom_adjustment = 0;
			gv_options.centering_options = { \'open_info_window\':true, \'partial_match\':true, \'center_key\':\'center\', \'default_zoom\':null } // URL-based centering (e.g., ?center=name_of_marker&zoom=14)
			gv_options.street_view = true; // true|false: allow Google Street View on the map (Google Maps only)
			gv_options.tilt = false; // true|false: allow Google Maps to show 45-degree tilted aerial imagery?
			gv_options.disable_google_pois = false;  // true|false: if you disable clickable POIs on Google Maps, you also lose the labels on parks, airports, etc.
			gv_options.animated_zoom = true; // true|false: only affects Leaflet maps
			
			
			gv_options.zoom_control = \'none\'; // \'large\'|\'small\'|\'none\'
			gv_options.recenter_button = true; // true|false: is there a \'click to recenter\' button above the zoom control?
			gv_options.geolocation_control = false; // true|false; only works on secure servers
			gv_options.scale_control = true; // true|false
			gv_options.map_opacity_control = false;  // \'map\'|\'utilities\'|\'both\'|false: where does the opacity control appear?
			gv_options.map_type_control = false;  // widget to change the background map
			  gv_options.map_type_control.placement = false; // \'map\'|\'utilities\'|\'both\'|false: where does the map type control appear?
			  gv_options.map_type_control.filter = true;  // true|false: when map loads, are irrelevant maps ignored?
			  gv_options.map_type_control.excluded = [];  // comma-separated list of quoted map IDs that will never show in the list (\'included\' also works)
			gv_options.center_coordinates = true;  // true|false: show a "center coordinates" box and crosshair?
			gv_options.measurement_tools = false; // \'map\'|\'utilities\'|\'both\'|false: where does the measurement ruler appear?
			gv_options.measurement_options = { visible:false, distance_color:\'\', area_color:\'\' };
			gv_options.crosshair_hidden = true;  // true|false: hide the crosshair initially?
			gv_options.mouse_coordinates = false;  // true|false: show a "mouse coordinates" box?
			gv_options.utilities_menu = { \'maptype\':false, \'opacity\':false, \'measure\':false, \'geolocate\':false, \'export\':false };
			gv_options.allow_export = false;  // true|false
			
			gv_options.infobox_options = {}; // options for a floating info box (id="gv_infobox"), which can contain anything
			  gv_options.infobox_options.enabled = false;  // true|false: enable or disable the info box altogether
			  gv_options.infobox_options.position = [\'LEFT_TOP\',52,6];  // [Google anchor name, relative x, relative y]
			  gv_options.infobox_options.draggable = true;  // true|false: can it be moved around the screen?
			  gv_options.infobox_options.collapsible = true;  // true|false: can it be collapsed by double-clicking its top bar?

			
			gv_options.default_marker = { color:\'blue\',icon:\'googlemini\',scale:1 }; // icon can be a URL, but be sure to also include size:[w,h] and optionally anchor:[x,y]
			gv_options.vector_markers = false; // are the icons on the map in embedded SVG format?
			gv_options.marker_tooltips = true; // do the names of the markers show up when you mouse-over them?
			gv_options.marker_shadows = true; // true|false: do the standard markers have "shadows" behind them?
			gv_options.marker_link_target = \'_blank\'; // the name of the window or frame into which markers\' URLs will load
			gv_options.info_window_width = 300;  // in pixels, the width of the markers\' pop-up info "bubbles" (can be overridden by \'window_width\' in individual markers)
			gv_options.thumbnail_width = 0;  // in pixels, the width of the markers\' thumbnails (can be overridden by \'thumbnail_width\' in individual markers)
			gv_options.photo_size = [0,0];  // in pixels, the size of the photos in info windows (can be overridden by \'photo_width\' or \'photo_size\' in individual markers)
			gv_options.hide_labels = false;  // true|false: hide labels when map first loads?
			gv_options.labels_behind_markers = false; // true|false: are the labels behind other markers (true) or in front of them (false)?
			gv_options.label_offset = [0,0];  // [x,y]: shift all markers\' labels (positive numbers are right and down)
			gv_options.label_centered = false;  // true|false: center labels with respect to their markers?  (label_left is also a valid option.)
			gv_options.driving_directions = false;  // put a small "driving directions" form in each marker\'s pop-up window? (override with dd:true or dd:false in a marker\'s options)
			gv_options.garmin_icon_set = \'24x24\'; // \'gpsmap\' are the small 16x16 icons; change it to \'24x24\' for larger icons
			gv_options.marker_list_options = {};  // options for a dynamically-created list of markers
			  gv_options.marker_list_options.enabled = false;  // true|false: enable or disable the marker list altogether
			  gv_options.marker_list_options.floating = true;  // is the list a floating box inside the map itself?
			  gv_options.marker_list_options.position = [\'RIGHT_BOTTOM\',6,38];  // floating list only: position within map
			  gv_options.marker_list_options.min_width = 160; // minimum width, in pixels, of the floating list
			  gv_options.marker_list_options.max_width = 160;  // maximum width
			  gv_options.marker_list_options.min_height = 0;  // minimum height, in pixels, of the floating list
			  gv_options.marker_list_options.max_height = 310;  // maximum height
			  gv_options.marker_list_options.draggable = true;  // true|false, floating list only: can it be moved around the screen?
			  gv_options.marker_list_options.collapsible = true;  // true|false, floating list only: can it be collapsed by double-clicking its top bar?
			  gv_options.marker_list_options.include_tickmarks = false;  // true|false: are distance/time tickmarks included in the list?
			  gv_options.marker_list_options.include_trackpoints = false;  // true|false: are "trackpoint" markers included in the list?
			  gv_options.marker_list_options.dividers = false;  // true|false: will a thin line be drawn between each item in the list?
			  gv_options.marker_list_options.desc = true;  // true|false: will the markers\' descriptions be shown below their names in the list?
			  gv_options.marker_list_options.icons = true;  // true|false: should the markers\' icons appear to the left of their names in the list?
			  gv_options.marker_list_options.thumbnails = false;  // true|false: should markers\' thumbnails be shown in the list?
			  gv_options.marker_list_options.folders_collapsed = false;  // true|false: do folders in the list start out in a collapsed state?
			  gv_options.marker_list_options.folders_hidden = false;  // true|false: do folders in the list start out in a hidden state?
			  gv_options.marker_list_options.collapsed_folders = []; // an array of folder names
			  gv_options.marker_list_options.hidden_folders = []; // an array of folder names
			  gv_options.marker_list_options.count_folder_items = false;  // true|false: list the number of items in each folder?
			  gv_options.marker_list_options.wrap_names = true;  // true|false: should marker\'s names be allowed to wrap onto more than one line?
			  gv_options.marker_list_options.unnamed = \'[unnamed]\';  // what \'name\' should be assigned to  unnamed markers in the list?
			  gv_options.marker_list_options.colors = false;  // true|false: should the names/descs of the points in the list be colorized the same as their markers?
			  gv_options.marker_list_options.default_color = \'\';  // default HTML color code for the names/descs in the list
			  gv_options.marker_list_options.limit = 0;  // how many markers to show in the list; 0 for no limit
			  gv_options.marker_list_options.center = false;  // true|false: does the map center upon a marker when you click its name in the list?
			  gv_options.marker_list_options.zoom = false;  // true|false: does the map zoom to a certain level when you click on a marker\'s name in the list?
			  gv_options.marker_list_options.zoom_level = 16;  // if \'zoom\' is true, what level should the map zoom to?
			  gv_options.marker_list_options.info_window = true;  // true|false: do info windows pop up when the markers\' names are clicked in the list?
			  gv_options.marker_list_options.url_links = false;  // true|false: do the names in the list become instant links to the markers\' URLs?
			  gv_options.marker_list_options.toggle = false;  // true|false: does a marker disappear if you click on its name in the list?
			  gv_options.marker_list_options.help_tooltips = false;  // true|false: do "tooltips" appear on marker names that tell you what happens when you click?
			  gv_options.marker_list_options.id = \'gv_marker_list\';  // id of a DIV tag that holds the list
			  gv_options.marker_list_options.header = \'\'; // HTML code; be sure to put backslashes in front of any single quotes, and don\'t include any line breaks
			  gv_options.marker_list_options.footer = \'\'; // HTML code
			gv_options.marker_filter_options = {};  // options for removing waypoints that are out of the current view
			  gv_options.marker_filter_options.enabled = false;  // true|false: should out-of-range markers be removed?
			  gv_options.marker_filter_options.movement_threshold = 8;  // in pixels, how far the map has to move to trigger filtering
			  gv_options.marker_filter_options.limit = 0;  // maximum number of markers to display on the map; 0 for no limit
			  gv_options.marker_filter_options.update_list = true;  // true|false: should the marker list be updated with only the filtered markers?
			  gv_options.marker_filter_options.sort_list_by_distance = false;  // true|false: should the marker list be sorted by distance from the center of the map?
			  gv_options.marker_filter_options.min_zoom = 0;  // below this zoom level, don\'t show any markers at all
			  gv_options.marker_filter_options.zoom_message = \'\';  // message to put in the marker list if the map is below the min_zoom threshold
			gv_options.synthesize_fields = {}; // for example: {label:\'{name}\'} would cause all markers\' names to become visible labels
				

			
		
			var script = (self.API && API == \'google\') ? \'google_maps/functions3.js\' : \'leaflet/functions.js\';
			if (document.location.protocol == \'https:\') { // secure pages require secure scripts
				document.writeln(\'<script src="https://www.gpsvisualizer.com/\'+script+\'" type="text/javascript"><\'+\'/script>\');
			} else {
				document.writeln(\'<script src="http://maps.gpsvisualizer.com/\'+script+\'" type="text/javascript"><\'+\'/script>\');
			}
'; ?>
			
		</script>
		<style type="text/css">
<?php echo '		
			#gmap_div .gv_marker_info_window {
				font-size:11px !important;
			}
			#gmap_div .gv_label {
				opacity:0.90; filter:alpha(opacity=90);
				color:white; background-color:#333333; border:1px solid black; padding:1px;
				font:9px Verdana !important;
				font-weight:normal !important;
			}
			.legend_block {
				display:inline-block; border:solid 1px black; width:9px; height:9px; margin:0px 2px 0px 0px;
			}
'; ?>
			
		</style>
		
		
		<script type="text/javascript">
<?php echo '		
			function GV_Map() {
			  
				GV_Setup_Map();				
				
'; ?>
				
<?php $_from = $this->_tpl_vars['Rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['RowsGrid'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['RowsGrid']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Row']):
        $this->_foreach['RowsGrid']['iteration']++;
?>
	<?php echo 'GV_Draw_Marker({lat:'; ?>
<?php echo $this->_tpl_vars['Row']['Latitude']; ?>
,lon:<?php echo $this->_tpl_vars['Row']['Longitude']; ?>
,name:'<?php echo $this->_tpl_vars['Row']['IdLum']; ?>
',desc:'TIPO DE LUMINARIA:<?php echo $this->_tpl_vars['Row']['TipoDeLuminaria']; ?>
--TIPO DE CALLE:<?php echo $this->_tpl_vars['Row']['TipoDeCalle']; ?>
--TIPO DE VIA:<?php echo $this->_tpl_vars['Row']['Via']; ?>
--FECHA CAPTURA:<?php echo $this->_tpl_vars['Row']['FechaCaptura']; ?>
--MUNICIPIO:<?php echo $this->_tpl_vars['Row']['Municipio']; ?>
--COLONIA:<?php echo $this->_tpl_vars['Row']['Colonia']; ?>
--CALLE:<?php echo $this->_tpl_vars['Row']['Calle']; ?>
--CARGA ACEPTADA:<?php echo $this->_tpl_vars['Row']['CargaAceptada']; ?>
    LIGA A FOTOGRAFIA:    https://emihermx.com/toluca2021/<?php echo $this->_tpl_vars['Row']['Fotografia']; ?>
',label:'<?php echo $this->_tpl_vars['Row']['TipoLuminaria']; ?>
',color:'',icon:''<?php echo '});'; ?>

<?php $_from = $this->_tpl_vars['Row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['FieldName'] => $this->_tpl_vars['RowColumn']):
?>
<?php endforeach; endif; unset($_from); ?>
<?php endforeach; endif; unset($_from); ?>
<?php echo '
				GV_Finish_Map();
			}
			GV_Map();
'; ?>
			
		</script>
			
	</body>

</html>