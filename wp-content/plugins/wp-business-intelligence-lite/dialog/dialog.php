<?php

/***************************************************************************


	WP Business Intelligence Lite
	Author: WP Business Intelligence
	Website: www.wpbusinessintelligence.com
	Contact: http://www.wpbusinessintelligence.com/contactus/

	This file is part of WP Business Intelligence Lite.

    WP Business Intelligence Lite is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    WP Business Intelligence Lite is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WP Business Intelligence Lite; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	You can find a copy of the GPL licence here:
	http://www.gnu.org/licenses/gpl-3.0.html
 ******************************************************************************/

//#######################################################################
//##########################     ENGLISH      ###########################
//#######################################################################

$wpbi_dialog['disclaimer']['software']['version']				= 	__('1.0.4', 'wpbusinessintelligence');
$wpbi_dialog['disclaimer']['license']['gpl']					= 	__('
	<b>Terms of use</b><br>
	<br>
	WP Business Intelligence v', 'wpbusinessintelligence').$wpbi_dialog['disclaimer']['software']['version'].__('	<br>
	Author: WP Business Intelligence	<br>
	Website: <a href="http://www.wpbusinessintelligence.com">www.wpbusinessintelligence.com</a>	<br>
	Contact: <a href="http://www.wpbusinessintelligence.com/contacts/">http://www.wpbusinessintelligence.com/contactus/</a> 	<br>
	<br>
	WP Business Intelligence is free software; you can redistribute it and/or modify	<br>
    it under the terms of the GNU General Public License as published by	<br>
    the Free Software Foundation; either version 2 of the License, or	<br>
    (at your option) any later version.	<br>
	<br>
    This program is distributed in the hope that it will be useful,	<br>
    but WITHOUT ANY WARRANTY; without even the implied warranty of	<br>
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the	<br>
    GNU General Public License for more details.	<br>
	<br>
    You should have received a copy of the GNU General Public License	<br>
    along with this program; if not, write to the Free Software	<br>
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA	<br>
		<br>
	You can find a copy of the GPL licence <a href="http://www.gnu.org/licenses/gpl-3.0.html">here</a>.	<br>
	', 'wpbusinessintelligence');

//***********************************************************************
//****************************   MESSAGES    ****************************
//***********************************************************************

$wpbi_dialog['msg']['standard']['error']					= 	__('<b>ERROR: </b>', 'wpbusinessintelligence');
$wpbi_dialog['msg']['standard']['warning']				= 	__('<b>WARNING: </b>', 'wpbusinessintelligence');
$wpbi_dialog['msg']['standard']['ok']						= 	__('<b>OK: </b>', 'wpbusinessintelligence');
$wpbi_dialog['msg']['query']['no-records']				= 	__('<i>Query returned 0 records</i>', 'wpbusinessintelligence');
$wpbi_dialog['msg']['error']['only-select-allowed']		= 	$wpbi_dialog['msg']['standard']['error'].__('Only SELECT statement allowed.', 'wpbusinessintelligence');
$wpbi_dialog['msg']['warning']['no-connections']			= 	$wpbi_dialog['msg']['standard']['warning'].__('You have no database connections. Create one!', 'wpbusinessintelligence');
$wpbi_dialog['msg']['warning']['no-queries']				= 	$wpbi_dialog['msg']['standard']['warning'].__('You have no query. Create one!', 'wpbusinessintelligence');
$wpbi_dialog['msg']['ok']['connection-working']			= 	$wpbi_dialog['msg']['standard']['ok'].__('Connection is working!', 'wpbusinessintelligence');
$wpbi_dialog['msg']['error']['connection-error']			= 	$wpbi_dialog['msg']['standard']['error'].__('Could not connect to the database!!', 'wpbusinessintelligence');

//***********************************************************************
//******************************   PAGES    *****************************
//***********************************************************************

//Commons
$wpbi_dialog['button']['label']['set'] 					= 	__('Set', 'wpbusinessintelligence');
$wpbi_dialog['button']['label']['edit'] 					= 	__('Edit', 'wpbusinessintelligence');
$wpbi_dialog['button']['label']['test'] 					= 	__('Test', 'wpbusinessintelligence');
$wpbi_dialog['button']['label']['save'] 					= 	__('Save', 'wpbusinessintelligence');
$wpbi_dialog['button']['label']['drop'] 					= 	__('Drop', 'wpbusinessintelligence');
$wpbi_dialog['button']['label']['draw'] 					= 	__('Draw', 'wpbusinessintelligence');
$wpbi_dialog['action']['label']['edit'] 					= 	__('Edit', 'wpbusinessintelligence');
$wpbi_dialog['action']['label']['save'] 					= 	__('Save', 'wpbusinessintelligence');
$wpbi_dialog['action']['label']['copy'] 					= 	__('Copy', 'wpbusinessintelligence');
$wpbi_dialog['item']['name']['copy'] 						= 	__('Copy of ', 'wpbusinessintelligence');
$wpbi_dialog['action']['label']['test'] 					= 	__('Test', 'wpbusinessintelligence');
$wpbi_dialog['action']['label']['drop'] 					= 	__('Drop', 'wpbusinessintelligence');

//Preferences
$wpbi_dialog['page']['wpbi']['title'] 				= 	__('Welcome to WP Business Intelligence Lite', 'wpbusinessintelligence');
$wpbi_dialog['page']['wpbi']['description'] 			= 	__('WP Business Intelligence Lite is a Wordpress plugin that transform your site in a powerful Business Intelligence tool.
<br><br>
All the documentation and tutorials can be found at <a href="www.wpbusinessintelligence.com">www.wpbusinessintelligence.com</a><br><br>

If you like WP Business Intelligence Lite, you may be interested in the following extensions: <br>
<b>WP Business Intelligence Pro</b>: With 10+ chart types, connection to unlimited DBs and 24/7 support.<br>
<b>WP Business Intelligence Chart - TinyMCE Button</b>: Extend TinyMCE\'s functionalities by adding a chart button. <br>
<b>WP Business Intelligence Table - TinyMCE Button</b>: Extend TinyMCE\'s functionalities by adding a table button.<br>
', 'wpbusinessintelligence');

//Connections
$wpbi_dialog['page']['connections']['title'] 				= 	__('Connections', 'wpbusinessintelligence');
$wpbi_dialog['page']['connections']['description'] 		= 	__('Create a database connection.', 'wpbusinessintelligence');
$wpbi_dialog['action']['connections']['create']	 		= 	__('Create database connections', 'wpbusinessintelligence');
$wpbi_dialog['action']['connections']['edit']		 		= 	__('Edit database connections', 'wpbusinessintelligence');
$wpbi_dialog['action']['connections']['list']	 			= 	__('Database connections list.', 'wpbusinessintelligence');
$wpbi_dialog['field']['connections']['name'] 				= 	__('Name', 'wpbusinessintelligence');
$wpbi_dialog['field']['connections']['host'] 				= 	__('Host', 'wpbusinessintelligence');
$wpbi_dialog['field']['connections']['user']				= 	__('Username', 'wpbusinessintelligence');
$wpbi_dialog['field']['connections']['pass']				= 	__('Password', 'wpbusinessintelligence');
$wpbi_dialog['header']['connections']['alias']			= 	__('DB Connection', 'wpbusinessintelligence');
$wpbi_dialog['header']['connections']['name'] 			= 	__('DB Name', 'wpbusinessintelligence');
$wpbi_dialog['header']['connections']['host'] 			= 	__('DB Host', 'wpbusinessintelligence');
$wpbi_dialog['header']['connections']['user']				= 	__('DB Username', 'wpbusinessintelligence');

//Queries
$wpbi_dialog['page']['queries']['title'] 					= 	__('Queries', 'wpbusinessintelligence');
$wpbi_dialog['page']['queries']['description'] 			= 	__('Create a query.', 'wpbusinessintelligence');
$wpbi_dialog['field']['queries']['connection'] 			= 	__('Connection', 'wpbusinessintelligence');
$wpbi_dialog['field']['queries']['name'] 					= 	__('Query name', 'wpbusinessintelligence');
$wpbi_dialog['field']['queries']['statement']				= 	__('SQL Statement', 'wpbusinessintelligence');
$wpbi_dialog['header']['queries']['name'] 				= 	__('Name', 'wpbusinessintelligence');
$wpbi_dialog['header']['queries']['database'] 			= 	__('Database', 'wpbusinessintelligence');
$wpbi_dialog['header']['queries']['statement']			= 	__('Statement', 'wpbusinessintelligence');
$wpbi_dialog['query']['new']['test']						= 	__('<i>The query returned <b>%d</b> records; anyway the testing tool displays only the first %d</i>', 'wpbusinessintelligence');
$wpbi_dialog['query']['saved']['test']					= 	__('Testing query <b>%s</b><p><i>%s</i></p>', 'wpbusinessintelligence');
$wpbi_dialog['query']['saved']['edit']					= 	__('
Editing query <b>%s</b><p><i>%s</i></p>
<p>
<b>Take care!!!</b> Modifying this query could affect all the related views. Be sure you are not changing the key fields used by the views in order to avoid unexpected results.
</p>', 'wpbusinessintelligence');
$wpbi_dialog['label']['button']['add']					= 	__('Save', 'wpbusinessintelligence');
$wpbi_dialog['label']['button']['edit']					= 	__('Edit', 'wpbusinessintelligence');
$wpbi_dialog['label']['button']['test']					= 	__('Test', 'wpbusinessintelligence');

//Tables
$wpbi_dialog['page']['tables']['title'] 					= 	__('Tables', 'wpbusinessintelligence');
$wpbi_dialog['page']['tables']['description'] 			= 	__('Select a query and click on "Set" to create a new table.', 'wpbusinessintelligence');
$wpbi_dialog['field']['tables']['query'] 					= 	__('Query', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['settings'] 				= 	__('Parameters', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['values']					= 	__('Values', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-name']				= 	__('Table Name', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-title']				= 	__('Table Title', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-style']				= 	__('CSS Class', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-html-values']		= 	__('Html Values', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-header']				= 	__('Header', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-footer']				= 	__('Footer', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-rows-pg']			= 	__('Rows per page (0 = no pagination)', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-col']				= 	__('Column', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-col-visible']		= 	__('Visible', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-col-label']			= 	__('Rename to', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['table-col-istime']			= 	__('Is Time', 'wpbusinessintelligence');
$wpbi_dialog['form']['option']['table-style-default']		= 	__('WordPress', 'wpbusinessintelligence');
$wpbi_dialog['header']['tables']['name'] 					= 	__('Name', 'wpbusinessintelligence');
$wpbi_dialog['header']['tables']['query'] 				= 	__('Associated Query', 'wpbusinessintelligence');
$wpbi_dialog['table']['saved']['test']					= 	__('Testing table <b>%s</b><p><i>%s</i></p>', 'wpbusinessintelligence');
$wpbi_dialog['table']['saved']['edit']					= 	__('Editing table <b>%s</b><p><i>%s</i></p>', 'wpbusinessintelligence');

//Charts
$wpbi_dialog['header']['charts']['name'] 					= 	__('Name', 'wpbusinessintelligence');
$wpbi_dialog['header']['charts']['type'] 					= 	__('Type', 'wpbusinessintelligence');
$wpbi_dialog['header']['charts']['query'] 				= 	__('Associated Query', 'wpbusinessintelligence');
$wpbi_dialog['page']['charts']['title'] 					= 	__('Charts', 'wpbusinessintelligence');
$wpbi_dialog['page']['charts']['description'] 			= 	__('Select a query and click on "Set" to create a new chart.', 'wpbusinessintelligence');
$wpbi_dialog['field']['charts']['title'] 					= 	__('Title', 'wpbusinessintelligence');
$wpbi_dialog['field']['charts']['name'] 					= 	__('Name', 'wpbusinessintelligence');
$wpbi_dialog['field']['charts']['query']					= 	__('Query', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-name']				= 	__('Chart Name', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-title']				= 	__('Chart Title', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-title-color']		= 	__('Chart Title Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-title-size']			= 	__('Chart Title Size', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-type']				= 	__('Chart Type', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-header']				= 	__('Header', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-footer']				= 	__('Footer', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-bgcolor']			= 	__('Background', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-width']				= 	__('Width', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-height']				= 	__('Height', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-x-precision']				= 	__('X axis precision', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-y-precision']				= 	__('Y axis precision', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-y-currency']				= 	__('Y axis currency', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-rows-pg']			= 	__('Rows per page (0 = no pagination)', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-col']				= 	__('Column', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-col-label']			= 	__('Label', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-col-y']				= 	__('Y', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-col-value']			= 	__('Value', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-col-color']			= 	__('Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-col-rename']			= 	__('Rename To', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['chart-col-istime']			= 	__('Is Time', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['basic-settings'] 			= 	__('Main Chart Settings', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-legend']				= 	__('Legend', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-legend-size']			= 	__('Legend Size', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-label-size']			= 	__('Labels Size', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-axis-thick']			= 	__('Axis Thickness', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-legend-color']			= 	__('Legend Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-label-color']			= 	__('Labels Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-label-rotation']			= 	__('Labels Rotation', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-grid-color']			= 	__('Axis Grid Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-grid-step']			= 	__('Axis Grid Lines (%)', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-x-axis-color']			= 	__('Axis Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['x-settings'] 				= 	__('X Axis Settings', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-legend']				= 	__('Legend', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-legend-size']			= 	__('Legend Size', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-label-size']			= 	__('Labels Size', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-grid-color']			= 	__('Axis Grid Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-grid-step']			= 	__('Axis Grid Lines (%)', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-axis-thick']			= 	__('Axis Thickness', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-legend-color']			= 	__('Legend Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-label-color']			= 	__('Labels Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-label-rotation']			= 	__('Labels Rotation', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['ch-y-axis-color']			= 	__('Axis Color', 'wpbusinessintelligence');
$wpbi_dialog['form']['label']['y-settings'] 				= 	__('Y Axis Settings', 'wpbusinessintelligence');
$wpbi_dialog['charts']['x-label']['concat-string']		= 	__(' ', 'wpbusinessintelligence');
$wpbi_dialog['charts']['y-label']['concat-string']		= 	__(' ', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['line']					= 	__('Line', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['line-area']				= 	__('Area', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar']						= 	__('Bar (Default)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-filled']				= 	__('Bar (Filled)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-glass']				= 	__('Bar (Glass)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-3d']					= 	__('Bar (3D)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-sketch']				= 	__('Bar (Sketch)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-cylinder']			= 	__('Bar (Cylinder)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-cylinder-outline']	= 	__('Bar (Cylinder Outline)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-rounded-glass']		= 	__('Bar (Rounded Glass)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-dome']				= 	__('Bar (Dome)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-round-3d']			= 	__('Bar (Round 3D)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-horizontal']			= 	__('Bar (Horizontal)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['bar-stacked']				= 	__('Multi Bar', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['candle']					= 	__('Bar (Candle)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['pie']						= 	__('Pie', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['donut']						= 	__('Donut', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['scatter']					= 	__('Scatter', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['scatter-line']			= 	__('Scatter (Line)', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['cumulative-line']			= 	__('Cumulative Line', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['line-and-bar']			= 	__('Line and Bar', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['multi-line-focus']			= 	__('Multi-Line Focus', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['stacked-area']			= 	__('Stacked Area', 'wpbusinessintelligence');
$wpbi_dialog['charts']['type']['radar']					= 	__('Radar', 'wpbusinessintelligence');
$wpbi_dialog['charts']['line']['tooltip']					= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['line-area']['tooltip']			= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar']['tooltip']					= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-filled']['tooltip']			= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-glass']['tooltip']			= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-3d']['tooltip']				= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-sketch']['tooltip']			= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-cylinder']['tooltip']			= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-cylinder-outline']['tooltip']	= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-rounded-glass']['tooltip']	= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-dome']['tooltip']				= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-round-3d']['tooltip']			= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-horizontal']['tooltip']		= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['bar-stacked']['tooltip']			= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['candle']['tooltip']				= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['pie']['tooltip']					= 	__('#percent#<br>#val# of #total#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['scatter']['tooltip']				= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['scatter-line']['tooltip']			= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['radar']['tooltip']				= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['charts']['default']['tooltip']				= 	__('#val#', 'wpbusinessintelligence');
$wpbi_dialog['chart']['saved']['test']					= 	__('Testing chart <b>%s</b><p><i>%s</i></p>', 'wpbusinessintelligence');
$wpbi_dialog['chart']['saved']['edit']					= 	__('Editing chart <b>%s</b><p><i>%s</i></p>', 'wpbusinessintelligence');

//Variables
$wpbi_dialog['page']['variables']['title'] 				= 	__('Variables', 'wpbusinessintelligence');
$wpbi_dialog['page']['variables']['description'] 			= 	__('Create a variable and an associated default value.', 'wpbusinessintelligence');
$wpbi_dialog['action']['variables']['create']	 			= 	__('Create variables', 'wpbusinessintelligence');
$wpbi_dialog['action']['variables']['edit']		 		= 	__('Edit variables', 'wpbusinessintelligence');
$wpbi_dialog['action']['variables']['list']	 			= 	__('Variables list.', 'wpbusinessintelligence');
$wpbi_dialog['field']['variables']['name'] 				= 	__('Name', 'wpbusinessintelligence');
$wpbi_dialog['field']['variables']['value'] 				= 	__('Value', 'wpbusinessintelligence');
$wpbi_dialog['header']['variables']['name']				= 	__('Variable Name', 'wpbusinessintelligence');
$wpbi_dialog['header']['variables']['value'] 				= 	__('Default Value', 'wpbusinessintelligence');

//***********************************************************************
//******************************   VIEWS    *****************************
//***********************************************************************

//Table
$wpbi_dialog['table']['pagination']['stats']				= 	__('Displaying %d-%d of %d', 'wpbusinessintelligence');
$wpbi_dialog['table']['pagination']['prev_text']			= 	__('&laquo;', 'wpbusinessintelligence');
$wpbi_dialog['table']['pagination']['next_text']			= 	__('&raquo;', 'wpbusinessintelligence');

?>