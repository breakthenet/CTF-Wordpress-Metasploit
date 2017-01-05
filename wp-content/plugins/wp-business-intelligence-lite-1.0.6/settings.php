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


/***	Global settings	***/
$wpbi_settings['parameter']['debug'] 			= false;
$wpbi_settings['parameter']['page-interval'] 	= 20;

$wpbi_settings['parameter']['encryption-key'] 	= '9_9WP-busintell9_9'; //DO NOT CHANGE IF YOU HAVE ALREADY CREATED DB CONNECTIONS!!!

//pie chart color set: pie chart colors cannot be set via the administration console; the following is the default color combination for pie charts
$wpbi_settings['pie-chart']['color-set'] 		= array('#ff0000','#32cd32','#64649b','#699696','#c837c8','#fafa05','#2d12c1','#15e5f1','#190190','#c31c21','#1f4f51','#226226','#159258','#28a18b','#2bc2bc','#1ef2ee','#320221','#352352','#285384','#3b62b7','#3e83e8','#31b41a','#44c34d','#47e47e','#3b14b0','#4e23e3','#514514','#447546','#578479','#5aa5aa','#4dd5dc','#60e50f','#640640','#573672','#6a45a5','#6d66d6','#609708','#73a63b','#76c76c','#69f79e','#7d06d1','#802802','#735834','#866767','#898898','#7cb8ca','#8fc7fd','#92e92e','#861960','#992893','#9c49c4','#8f79f6','#a28929','#a5aa5a','#98da8c','#abe9bf','#af0af0','#a23b22','#b54a55','#b86b86','#ab9bb8','#beaaeb','#c1cc1c','#b4fc4e','#c80b81','#cb2cb2','#be5ce4','#d16c17','#d48d48','#c7bd7a','#daccad','#ddedde','#d11e10','#e42d43','#e74e74','#da7ea6','#ed8dd9','#f0af0a','#e3df3c','#f6ee6f','#fa0fa0','#ed3fd2','#1004f0','#103610','#f69106','#109af9','#10cc10','#fff10f','#113010','#116211','#109511','#11c610','#11f811','#112b12','#125c11','#128e12','#11c112','#12f211','#132413','#125713');

//Form parameter
$wpbi_settings['parameter']['qy_db'] 			= 'qy_db';
$wpbi_settings['parameter']['qy_statement'] 	= 'qy_statement';
$wpbi_settings['parameter']['qy_name'] 		= 'qy_name';
$wpbi_settings['parameter']['qy_id'] 			= 'query_id';
$wpbi_settings['parameter']['db_id'] 			= 'db_id';
$wpbi_settings['parameter']['db_name'] 		= 'db_name';
$wpbi_settings['parameter']['db_host'] 		= 'db_host';
$wpbi_settings['parameter']['db_user'] 		= 'db_user';
$wpbi_settings['parameter']['db_pass'] 		= 'db_pass';
$wpbi_settings['parameter']['tb-name'] 		= 'tb_name';
$wpbi_settings['parameter']['tb-id'] 			= 'tb_id';
$wpbi_settings['parameter']['tb-title'] 		= 'tb_title';
$wpbi_settings['parameter']['tb-style'] 		= 'tb_style';
$wpbi_settings['parameter']['tb-header'] 		= 'tb_header';
$wpbi_settings['parameter']['tb-footer'] 		= 'tb_footer';
$wpbi_settings['parameter']['tb-html-values'] 	= 'tb_html_values';
$wpbi_settings['parameter']['tb-row-pg'] 		= 'tb_row_pg';
$wpbi_settings['parameter']['action'] 			= 'action';
$wpbi_settings['parameter']['ch-type'] 		= 'ch_type';
$wpbi_settings['parameter']['ch-id'] 			= 'ch_id';
$wpbi_settings['parameter']['ch-name'] 		= 'ch_name';
$wpbi_settings['parameter']['ch-title'] 		= 'ch_title';
$wpbi_settings['parameter']['ch-title-color']	= 'ch_title_color';
$wpbi_settings['parameter']['ch-title-size'] 	= 'ch_title_size';
$wpbi_settings['parameter']['ch-bgcolor'] 		= 'ch_bgcolor';
$wpbi_settings['parameter']['ch-width'] 		= 'ch_width';
$wpbi_settings['parameter']['ch-width-percent']= 'ch_width_percent';
$wpbi_settings['parameter']['ch-height'] 		= 'ch_height';
$wpbi_settings['parameter']['ch-height-percent']= 'ch_height_percent';
$wpbi_settings['parameter']['ch-x-precision'] 		= 'ch_x_precision';
$wpbi_settings['parameter']['ch-x-legend']		= 'ch_x_label';
$wpbi_settings['parameter']['ch-x-legend-size']	= 'ch_x_legend_size';
$wpbi_settings['parameter']['ch-x-legend-color']= 'ch_x_legend_color';
$wpbi_settings['parameter']['ch-x-label-size']	= 'ch_x_label_size';
$wpbi_settings['parameter']['ch-x-label-rotation']	= 'ch_x_label_rotation';
$wpbi_settings['parameter']['ch-x-label-color']= 'ch_x_label_color';
$wpbi_settings['parameter']['ch-x-grid-color']= 'ch_x_grid_color';
$wpbi_settings['parameter']['ch-x-grid-step']= 'ch_x_grid_step';
$wpbi_settings['parameter']['ch-x-axis-thick']= 'ch_x_axis_thick';
$wpbi_settings['parameter']['ch-x-axis-color']= 'ch_x_axis_color';
$wpbi_settings['parameter']['ch-y-precision'] 		= 'ch_y_precision';
$wpbi_settings['parameter']['ch-y-currency'] 		= 'ch_y_currency';
$wpbi_settings['parameter']['ch-y-legend']		= 'ch_y_label';
$wpbi_settings['parameter']['ch-y-legend-size']	= 'ch_y_legend_size';
$wpbi_settings['parameter']['ch-y-legend-color']= 'ch_y_legend_color';
$wpbi_settings['parameter']['ch-y-label-rotation']= 'ch_y_label_rotation';
$wpbi_settings['parameter']['ch-y-label-size']	= 'ch_y_label_size';
$wpbi_settings['parameter']['ch-y-label-color']= 'ch_y_label_color';
$wpbi_settings['parameter']['ch-y-axis-color']= 'ch_y_axis_color';
$wpbi_settings['parameter']['ch-y-axis-thick']= 'ch_y_axis_thick';
$wpbi_settings['parameter']['ch-y-grid-color']= 'ch_y_grid_color';
$wpbi_settings['parameter']['ch-y-grid-step']= 'ch_y_grid_step';
$wpbi_settings['parameter']['ch-x-column-cb']= 'x_column';
$wpbi_settings['parameter']['ch-x-column-cb']= 'y_column';
$wpbi_settings['parameter']['ch-v-column-cb']= 'v_column';
$wpbi_settings['parameter']['ch-istime-column-cb']= 'istime_column';
$wpbi_settings['parameter']['ch-tx-column-tf']= 'tx_column';
$wpbi_settings['parameter']['tb-tx-column-tf']= 'tx_column';
$wpbi_settings['parameter']['tb-cb-column-tf']= 'cb_column';

$wpbi_settings['parameter']['var_id'] 			= 'var_id';
$wpbi_settings['parameter']['var_name'] 		= 'var_name';
$wpbi_settings['parameter']['var_value'] 		= 'var_value';
$wpbi_settings['parameter']['charts_help'] 		= '<div id="help_barchart"><p><span style="font-weight:bold">Bar Chart</span></p><p>Each column marked as "value" will be plotted as a column.<br/>The "label" will be on the x axis.<br/>For this chart the colors will be randomly chosen and are not selected via the color picker.</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_hbarchart"><p><span style="font-weight:bold">Horizontal Bar Chart</span></p><p>Select one column as "label".<br/>All the other columns shall be "values" to be represented as bars grouped by label.</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_linechart"><p><span style="font-weight:bold">Line Chart</span></p><p>Each column marked as "value" will be plotted as a line.</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_multibarchart"><p><span style="font-weight:bold">Multibar Chart</span></p><p>Select one column as "label".<br/>All the other columns shall be "values" to be represented as bars grouped by label.</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_scatterchart"><p><span style="font-weight:bold">Scatter Chart</span></p><p>If only 2 columns are selected as "Value" they are used as X and Y coordinates of points in the order displayed.<br/>If more than 2 "Values" are selected they shall be a multiple of 3 and will be interpreted as X, Y and size of each point.</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_piechart"><p><span style="font-weight:bold">Pie/Donut Chart</span><p>For pie/donut charts select one column as "label" <br/>and then another that can be either "value" only or both "value" and "label".</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_cumulinechart"><p><span style="font-weight:bold">Cumulative Line Chart</span><p>Each column selected as "value" will be plotted as a separate line<br/>with the possibility to align to 0 all the lines on any point of the X axis.</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_lineandbarchart"><p><span style="font-weight:bold">Line And Bar Chart</span><p>This chart plots the first selected column as a bar chart and the second as a line</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_stackedareachart"><p><span style="font-weight:bold">Stacked Area Chart</span><p>Each column selected as "value" will be plotted as a separate line with filled area.<br/>Each line can be plotted separately by clicking on it.</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>
                                                   <div id="help_focuslinechart"><p><span style="font-weight:bold">Multi Line With Focus</span><p>This is a multi line chart with the possibility to zoom a speific segment of the X axis.</p><p><a href="http://www.wpbusinessintelligence.com/wp-business-intelligence-faq" target="_blank">See the FAQ</a> for more details.</p></div>';
$wpbi_settings['value']['add'] 				= 'add';
$wpbi_settings['value']['test'] 				= 'test';
$wpbi_settings['value']['edit'] 				= 'edit';
$wpbi_settings['value']['save'] 				= 'save';
$wpbi_settings['value']['set'] 				= 'set';
$wpbi_settings['value']['drop'] 				= 'drop';
$wpbi_settings['value']['edit-test'] 			= 'edit_test';

/**************************/

/***	Table names		***/
$wpbi_sql['tname']['databases'] 	= 'wp_wpbi_databases';
$wpbi_sql['tname']['queries']		= 'wp_wpbi_queries';
$wpbi_sql['tname']['tables']		= 'wp_wpbi_tables';
$wpbi_sql['tname']['cols']			= 'wp_wpbi_tb_cols';
$wpbi_sql['tname']['charts']		= 'wp_wpbi_charts';
$wpbi_sql['tname']['chart-cols']	= 'wp_wpbi_ch_cols';
$wpbi_sql['tname']['vars']			= 'wp_wpbi_vars';
/**************************/

/***	Page URL		***/
$wpbi_url['page']['queries'] 		= 	'admin/queries/queries.php';
$wpbi_url['page']['tables'] 		= 	'admin/tables/tables.php';
$wpbi_url['page']['charts'] 		= 	'admin/charts/charts.php';
$wpbi_url['page']['connections'] 	= 	'admin/connections/connections.php';
$wpbi_url['page']['preferences'] 	= 	'admin/preferences/preferences.php';
$wpbi_url['page']['variables'] 	= 	'admin/variables/variables.php';
/**************************/

/***	Page Slugs		***/
$wpbi_url['slug']['queries'] 		= 	'queries';
$wpbi_url['slug']['tables'] 		= 	'tables';
$wpbi_url['slug']['charts'] 		= 	'charts';
$wpbi_url['slug']['connections'] 	= 	'connections';
$wpbi_url['slug']['preferences'] 	= 	'wpbi';
$wpbi_url['slug']['variables'] 	= 	'variables';
/**************************/

/***	Page Templates	***/
//The path is related to the templates directory
$wpbi_url['tpl']['root-path'] 			= 	 dirname(WP_PLUGIN_DIR.'/'.plugin_basename(__FILE__)).'/templates/';
$wpbi_url['tpl']['generic'] 			= 	'pages/generic.tpl';
$wpbi_url['tpl']['header'] 			= 	'pages/page.header.tpl';
$wpbi_url['tpl']['footer'] 			= 	'pages/page.footer.tpl';
$wpbi_url['tpl']['queries-new'] 		= 	'pages/queries.new.tpl';
$wpbi_url['tpl']['queries-edit'] 		= 	'pages/queries.edit.tpl';
$wpbi_url['tpl']['connections-edit'] 	= 	'pages/connections.edit.tpl';
$wpbi_url['tpl']['connections-new'] 	= 	'pages/connections.new.tpl';
$wpbi_url['tpl']['variables-edit'] 	= 	'pages/variables.edit.tpl';
$wpbi_url['tpl']['variables-new'] 		= 	'pages/variables.new.tpl';
$wpbi_url['tpl']['tables-new-1']		= 	'pages/tables.new.1.tpl';
$wpbi_url['tpl']['tables-new-2']		= 	'pages/tables.new.2.tpl';
$wpbi_url['tpl']['tables-edit-1']		= 	'pages/tables.edit.1.tpl';
$wpbi_url['tpl']['tables-edit-2']		= 	'pages/tables.edit.2.tpl';
$wpbi_url['tpl']['charts-new-1']		= 	'pages/charts.new.1.tpl';
$wpbi_url['tpl']['charts-new-2']		= 	'pages/charts.new.2.tpl';
$wpbi_url['tpl']['charts-edit-1']		= 	'pages/charts.edit.1.tpl';
$wpbi_url['tpl']['charts-edit-2']		= 	'pages/charts.edit.2.tpl';
$wpbi_url['tpl']['css']				= 	'scripts/css.tpl';
$wpbi_url['tpl']['table']				= 	'views/table.tpl';
$wpbi_url['tpl']['table-title']		= 	'views/table.title.tpl';
$wpbi_url['tpl']['table-pagination']	= 	'views/table.pagination.tpl';
$wpbi_url['tpl']['table-header']		= 	'views/table.header.tpl';
$wpbi_url['tpl']['table-footer']		= 	'views/table.footer.tpl';
$wpbi_url['tpl']['table-body-row']		= 	'views/table.body.row.tpl';
$wpbi_url['tpl']['table-body-row-col']	= 	'views/table.body.row.column.tpl';
$wpbi_url['tpl']['chart']				= 	'views/chart.tpl';
$wpbi_url['tpl']['nvd3chart']		    = 	'views/nvd3chart.tpl';
$wpbi_url['tpl']['iframe']				= 	'iframe/iframe.tpl';
/**************************/

/***	Resources URL		***/

//php
$wpbi_url['chart']['phplib'] 			= 	'resources/open-flash-chart/php-ofc-library/open-flash-chart.php';

//Scripts, CSS
$wpbi_url['colorpicker']['colorpicker'] = 	plugins_url('/resources/colorpicker/jquery.colorPicker.js', __FILE__);
$wpbi_url['colorpicker']['css']			=	plugins_url('/resources/colorpicker/colorPicker.css', __FILE__);
$wpbi_url['jquery']['iframe-auto-height']	= 	plugins_url('/resources/jquery-iframe-auto-height/js/jquery.iframe-auto-height.plugin.js', __FILE__);
$wpbi_url['jquery']['alphanumeric']		= 	plugins_url('/resources/jquery-alphanumeric/jquery.alphanumeric.js', __FILE__);

/*** nvd3 files ***/
$wpbi_url['nvd3']['css']			        =	plugins_url('/resources/nvd3/js/src/nv.d3.css', __FILE__);
$wpbi_url['nvd3']['nvd3']			        =	plugins_url('/resources/nvd3/js/nv.d3.min.js', __FILE__);
$wpbi_url['nvd3']['d3js']			        =	plugins_url('/resources/nvd3/js/lib/d3.v2.js', __FILE__);

/**************************/

/*** datatables files ***/
$wpbi_url['datatables']['jquery']			=	plugins_url('/resources/datatables/js/jquery.dataTables.js', __FILE__);
$wpbi_url['datatables']['jquerymin']		=	plugins_url('/resources/datatables/js/jquery.dataTables.min.js', __FILE__);

/**************************/

/***		Styles		***/
$wpbi_url['styles']['directory'] 			= 	dirname(WP_PLUGIN_DIR.'/'.plugin_basename(__FILE__)).'/css/';
$wpbi_url['styles']['url'] 				= 	plugins_url('/css/', __FILE__);
/**************************/

/***		TinyMCE		***/
$wpbi_settings['tinymce']['js']			= 	plugins_url('/tinymce/wpbusinessintelligence.js', __FILE__);
$wpbi_settings['tinymce']['js-chart']		= 	plugins_url('/wpbi_tinymce_chart/wpbi_tinymce_chart.js', __FILE__);
$wpbi_settings['tinymce']['js-table']		= 	plugins_url('/tinymce/tinymce_table/wpbi_tinymce_table.js', __FILE__);
$wpbi_settings['tinymce']['tag']			=	'wpbusinessintelligence';
/**************************/

/***        DB parameters   ***/
$wpbi_settings['parameter']['wp-db-connection-entry'] 	= 'SELECT * FROM ' . $wpbi_sql['tname']['databases'] . ' WHERE DB_NAME = ';

?>