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


class dao_chart {

var $wpdb;
var $table_name;

function dao_chart($wpdb, $table_name){
	$this->wpdb = $wpdb;
	$this->table_name= $table_name;
}

function select($vo_chart){

	$where_clause = "";

	if(isset($vo_chart)){
		$chart_id = $vo_chart->chart_id;
		$where_clause = "where `chart_id` = $chart_id";
	}

	$query = "SELECT `CHART_ID`, `QUERY_ID`, `CHART_KEY`, `CHART_NAME`, `CHART_TYPE`, `CHART_TITLE`, `CHART_TITLE_SIZE`,
	    `CHART_TITLE_COLOR`, `CHART_BG_COLOR`, `CHART_WIDTH`, `CHART_WIDTH_PERCENT`, `CHART_HEIGHT`, `CHART_HEIGHT_PERCENT`,
	    `CHART_X_COLOR`, `CHART_X_PRECISION`, `CHART_X_THICKNESS`, `CHART_X_GRID_COLOR`, `CHART_X_GRID_LINES`, `CHART_X_LABELS_COLOR`,
	    `CHART_X_LABELS_SIZE`, `CHART_X_LABELS_ROTATION`, `CHART_X_LEGEND`, `CHART_X_LEGEND_COLOR`, `CHART_X_LEGEND_SIZE`, `CHART_Y_COLOR`,
	    `CHART_Y_PRECISION`, `CHART_Y_CURRENCY`, `CHART_Y_THICKNESS`, `CHART_Y_GRID_COLOR`, `CHART_Y_GRID_LINES`, `CHART_Y_LABELS_COLOR`, `CHART_Y_LABELS_SIZE`,
	    `CHART_Y_LABELS_ROTATION`, `CHART_Y_LEGEND`, `CHART_Y_LEGEND_COLOR`, `CHART_Y_LEGEND_SIZE` FROM ".$this->table_name." $where_clause order by `CHART_NAME` asc";
	$rows = $this->wpdb->get_results($query);	
	$vo_chart = array();
	foreach($rows as $row){
		$item = new vo_chart($row->CHART_ID, $row->QUERY_ID, $row->CHART_KEY, $row->CHART_NAME, $row->CHART_TYPE, $row->CHART_TITLE, $row->CHART_TITLE_SIZE, $row->CHART_TITLE_COLOR, $row->CHART_BG_COLOR, $row->CHART_WIDTH, $row->CHART_WIDTH_PERCENT, $row->CHART_HEIGHT, $row->CHART_HEIGHT_PERCENT, $row->CHART_X_COLOR, $row->CHART_X_PRECISION, $row->CHART_X_THICKNESS, $row->CHART_X_GRID_COLOR, $row->CHART_X_GRID_LINES, $row->CHART_X_LABELS_COLOR, $row->CHART_X_LABELS_SIZE, $row->CHART_X_LABELS_ROTATION, $row->CHART_X_LEGEND, $row->CHART_X_LEGEND_COLOR, $row->CHART_X_LEGEND_SIZE, $row->CHART_Y_COLOR, $row->CHART_Y_PRECISION, $row->CHART_Y_CURRENCY, $row->CHART_Y_THICKNESS, $row->CHART_Y_GRID_COLOR, $row->CHART_Y_GRID_LINES, $row->CHART_Y_LABELS_COLOR, $row->CHART_Y_LABELS_SIZE, $row->CHART_Y_LABELS_ROTATION, $row->CHART_Y_LEGEND, $row->CHART_Y_LEGEND_COLOR, $row->CHART_Y_LEGEND_SIZE);
		array_push($vo_chart, $item);
	}

	return $vo_chart;

}

function select_by_key($vo_chart){

	$where_clause = "";

	if(isset($vo_chart)){
		$chart_key = $vo_chart->chart_key;
		$where_clause = "where `CHART_KEY` = '$chart_key'";
	}

	$query = "SELECT `CHART_ID`, `QUERY_ID`, `CHART_KEY`, `CHART_NAME`, `CHART_TYPE`, `CHART_TITLE`, `CHART_TITLE_SIZE`,
	`CHART_TITLE_COLOR`, `CHART_BG_COLOR`, `CHART_WIDTH`, `CHART_WIDTH_PERCENT`, `CHART_HEIGHT`, `CHART_HEIGHT_PERCENT`,
	`CHART_X_COLOR`, `CHART_X_PRECISION`, `CHART_X_THICKNESS`, `CHART_X_GRID_COLOR`, `CHART_X_GRID_LINES`, `CHART_X_LABELS_COLOR`,
	`CHART_X_LABELS_SIZE`, `CHART_X_LABELS_ROTATION`, `CHART_X_LEGEND`, `CHART_X_LEGEND_COLOR`, `CHART_X_LEGEND_SIZE`, `CHART_Y_COLOR`,
	`CHART_Y_PRECISION`, `CHART_Y_CURRENCY`, `CHART_Y_THICKNESS`, `CHART_Y_GRID_COLOR`, `CHART_Y_GRID_LINES`, `CHART_Y_LABELS_COLOR`, `CHART_Y_LABELS_SIZE`, `CHART_Y_LABELS_ROTATION`, `CHART_Y_LEGEND`, `CHART_Y_LEGEND_COLOR`, `CHART_Y_LEGEND_SIZE` FROM ".$this->table_name." $where_clause order by `CHART_NAME` asc";
	$rows = $this->wpdb->get_results($query);	
	$vo_chart = array();
	foreach($rows as $row){
		$item = new vo_chart($row->CHART_ID, $row->QUERY_ID, $row->CHART_KEY, $row->CHART_NAME, $row->CHART_TYPE, $row->CHART_TITLE, $row->CHART_TITLE_SIZE, $row->CHART_TITLE_COLOR, $row->CHART_BG_COLOR, $row->CHART_WIDTH, $row->CHART_WIDTH_PERCENT, $row->CHART_HEIGHT, $row->CHART_HEIGHT_PERCENT, $row->CHART_X_COLOR, $row->CHART_X_PRECISION, $row->CHART_X_THICKNESS, $row->CHART_X_GRID_COLOR, $row->CHART_X_GRID_LINES, $row->CHART_X_LABELS_COLOR, $row->CHART_X_LABELS_SIZE, $row->CHART_X_LABELS_ROTATION, $row->CHART_X_LEGEND, $row->CHART_X_LEGEND_COLOR, $row->CHART_X_LEGEND_SIZE, $row->CHART_Y_COLOR, $row->CHART_Y_PRECISION, $row->CHART_Y_CURRENCY, $row->CHART_Y_THICKNESS, $row->CHART_Y_GRID_COLOR, $row->CHART_Y_GRID_LINES, $row->CHART_Y_LABELS_COLOR, $row->CHART_Y_LABELS_SIZE, $row->CHART_Y_LABELS_ROTATION, $row->CHART_Y_LEGEND, $row->CHART_Y_LEGEND_COLOR, $row->CHART_Y_LEGEND_SIZE);
		array_push($vo_chart, $item);
	}

	return $vo_chart;

}

function add($vo_chart){

	$chart_id = $vo_chart->chart_id;
    $query_id = $vo_chart->query_id;
    $chart_key = $vo_chart->chart_key;
    $chart_name = $vo_chart->chart_name;
    $chart_type = $vo_chart->chart_type;
    $chart_title = $vo_chart->chart_title;
    $chart_title_size = is_numeric($vo_chart->chart_title_size) ? $vo_chart->chart_title_size : 10;
    $chart_title_color = $vo_chart->chart_title_color;
    $chart_bg_color = $vo_chart->chart_bg_color;
    $chart_width = $vo_chart->chart_width;
	$chart_width_percent = $vo_chart->chart_width_percent;
    $chart_height = $vo_chart->chart_height;
	$chart_height_percent = $vo_chart->chart_height_percent;
    $chart_x_color = $vo_chart->chart_x_color;
    $chart_x_precision = $vo_chart->chart_x_axis_precision;
    $chart_x_thickness = $vo_chart->chart_x_thickness;
    $chart_x_grid_color = $vo_chart->chart_x_grid_color;
    $chart_x_grid_lines = $vo_chart->chart_x_grid_lines;
    $chart_x_labels_color = $vo_chart->chart_x_labels_color;
    $chart_x_labels_size = $vo_chart->chart_x_labels_size;
    $chart_x_labels_rotation = $vo_chart->chart_x_labels_rotation;
    $chart_x_legend = $vo_chart->chart_x_legend;
    $chart_x_legend_color = $vo_chart->chart_x_legend_color;
    $chart_x_legend_size = $vo_chart->chart_x_legend_size;
    $chart_y_color = $vo_chart->chart_y_color;
    $chart_y_precision = $vo_chart->chart_y_axis_precision;
    $chart_y_currency = $vo_chart->chart_y_axis_currency;
    $chart_y_thickness = $vo_chart->chart_y_thickness;
    $chart_y_grid_color = $vo_chart->chart_y_grid_color;
    $chart_y_grid_lines = $vo_chart->chart_y_grid_lines;
    $chart_y_labels_color = $vo_chart->chart_y_labels_color;
    $chart_y_labels_size = $vo_chart->chart_y_labels_size;
    $chart_y_labels_rotation = $vo_chart->chart_y_labels_rotation;
    $chart_y_legend = $vo_chart->chart_y_legend;
    $chart_y_legend_color = $vo_chart->chart_y_legend_color;
    $chart_y_legend_size = $vo_chart->chart_y_legend_size;
 
	$query = "INSERT INTO ".$this->table_name."(
				`CHART_ID` ,
				`QUERY_ID` ,
				`CHART_KEY` ,
				`CHART_NAME` ,
				`CHART_TYPE` ,
				`CHART_TITLE` ,
				`CHART_TITLE_SIZE` ,
				`CHART_TITLE_COLOR` ,
				`CHART_BG_COLOR` ,
				`CHART_WIDTH` ,
				`CHART_WIDTH_PERCENT` ,
				`CHART_HEIGHT` ,
				`CHART_HEIGHT_PERCENT` ,
				`CHART_X_COLOR` ,
				`CHART_X_PRECISION` ,
				`CHART_X_THICKNESS` ,
				`CHART_X_GRID_COLOR` ,
				`CHART_X_GRID_LINES` ,
				`CHART_X_LABELS_COLOR` ,
				`CHART_X_LABELS_SIZE` ,
				`CHART_X_LABELS_ROTATION` ,
				`CHART_X_LEGEND` ,
				`CHART_X_LEGEND_COLOR` ,
				`CHART_X_LEGEND_SIZE` ,
				`CHART_Y_COLOR` ,
				`CHART_Y_PRECISION` ,
				`CHART_Y_CURRENCY` ,
				`CHART_Y_THICKNESS` ,
				`CHART_Y_GRID_COLOR` ,
				`CHART_Y_GRID_LINES` ,
				`CHART_Y_LABELS_COLOR` ,
				`CHART_Y_LABELS_SIZE` ,
				`CHART_Y_LABELS_ROTATION` ,
				`CHART_Y_LEGEND` ,
				`CHART_Y_LEGEND_COLOR` ,
				`CHART_Y_LEGEND_SIZE`
				)
				VALUES (
				NULL ,  
				'$query_id' ,
				'$chart_key' ,
				'$chart_name' ,
				'$chart_type' ,
				'$chart_title' ,
				'$chart_title_size' ,
				'$chart_title_color' ,
				'$chart_bg_color' ,
				'$chart_width' ,
				'$chart_width_percent' ,
				'$chart_height' ,
				'$chart_height_percent' ,
				'$chart_x_color' ,
				'$chart_x_precision' ,
				'$chart_x_thickness' ,
				'$chart_x_grid_color' ,
				'$chart_x_grid_lines' ,
				'$chart_x_labels_color' ,
				'$chart_x_labels_size' ,
				'$chart_x_labels_rotation' ,
				'$chart_x_legend' ,
				'$chart_x_legend_color' ,
				'$chart_x_legend_size' ,
				'$chart_y_color' ,
				'$chart_y_precision' ,
				'$chart_y_currency' ,
				'$chart_y_thickness' ,
				'$chart_y_grid_color' ,
				'$chart_y_grid_lines' ,
				'$chart_y_labels_color' ,
				'$chart_y_labels_size' ,
				'$chart_y_labels_rotation' ,
				'$chart_y_legend' ,
				'$chart_y_legend_color' ,
				'$chart_y_legend_size'
				)";

return $this->wpdb->query($query);

}

function edit($vo_chart_old, $vo_chart_new){
	
	$chart_id = $vo_chart_old->chart_id;
	$query_id = $vo_chart_new->query_id;
    $chart_key = $vo_chart_new->chart_key;
    $chart_name = $vo_chart_new->chart_name;
    $chart_type = $vo_chart_new->chart_type;
    $chart_title = $vo_chart_new->chart_title;
    $chart_title_size = is_numeric($vo_chart_new->chart_title_size) ? $vo_chart_new->chart_title_size : 10;
    $chart_title_color = $vo_chart_new->chart_title_color;
    $chart_bg_color = $vo_chart_new->chart_bg_color;
    $chart_width = $vo_chart_new->chart_width;
    $chart_width_percent = $vo_chart_new->chart_width_percent;
    $chart_height = $vo_chart_new->chart_height;
    $chart_height_percent = $vo_chart_new->chart_height_percent;
    $chart_x_color = $vo_chart_new->chart_x_color;
    $chart_x_precision = $vo_chart_new->chart_x_axis_precision;
    $chart_x_thickness = $vo_chart_new->chart_x_thickness;
    $chart_x_grid_color = $vo_chart_new->chart_x_grid_color;
    $chart_x_grid_lines = $vo_chart_new->chart_x_grid_lines;
    $chart_x_labels_color = $vo_chart_new->chart_x_labels_color;
    $chart_x_labels_size = $vo_chart_new->chart_x_labels_size;
    $chart_x_labels_rotation = $vo_chart_new->chart_x_labels_rotation;
    $chart_x_legend = $vo_chart_new->chart_x_legend;
    $chart_x_legend_color = $vo_chart_new->chart_x_legend_color;
    $chart_x_legend_size = $vo_chart_new->chart_x_legend_size;
    $chart_y_color = $vo_chart_new->chart_y_color;
    $chart_y_precision = $vo_chart_new->chart_y_axis_precision;
    $chart_y_currency = $vo_chart_new->chart_y_axis_currency;
    $chart_y_thickness = $vo_chart_new->chart_y_thickness;
    $chart_y_grid_color = $vo_chart_new->chart_y_grid_color;
    $chart_y_grid_lines = $vo_chart_new->chart_y_grid_lines;
    $chart_y_labels_color = $vo_chart_new->chart_y_labels_color;
    $chart_y_labels_size = $vo_chart_new->chart_y_labels_size;
    $chart_y_labels_rotation = $vo_chart_new->chart_y_labels_rotation;
    $chart_y_legend = $vo_chart_new->chart_y_legend;
    $chart_y_legend_color = $vo_chart_new->chart_y_legend_color;
    $chart_y_legend_size = $vo_chart_new->chart_y_legend_size;

	$query = "UPDATE ".$this->table_name." set 
				`QUERY_ID` =  '$query_id',
				`CHART_KEY` =  '$chart_key',
				`CHART_NAME` =  '$chart_name',				
				`CHART_TYPE` =  '$chart_type',
				`CHART_TITLE` =  '$chart_title',
				`CHART_TITLE_SIZE` =  '$chart_title_size',
				`CHART_TITLE_COLOR` =  '$chart_title_color',
				`CHART_BG_COLOR` =  '$chart_bg_color',
				`CHART_WIDTH` =  '$chart_width',
				`CHART_WIDTH_PERCENT` =  '$chart_width_percent',
				`CHART_HEIGHT` =  '$chart_height',
				`CHART_HEIGHT_PERCENT` =  '$chart_height_percent',
				`CHART_X_COLOR` =  '$chart_x_color',
				`CHART_X_PRECISION` =  '$chart_x_precision',
				`CHART_X_THICKNESS` =  '$chart_x_thickness',
				`CHART_X_GRID_COLOR` =  '$chart_x_grid_color',
				`CHART_X_GRID_LINES` =  '$chart_x_grid_lines',
				`CHART_X_LABELS_COLOR` =  '$chart_x_labels_color',
				`CHART_X_LABELS_SIZE` =  '$chart_x_labels_size',
				`CHART_X_LABELS_ROTATION` =  '$chart_x_labels_rotation',
				`CHART_X_LEGEND` =  '$chart_x_legend',
				`CHART_X_LEGEND_COLOR` =  '$chart_x_legend_color',
				`CHART_X_LEGEND_SIZE` =  '$chart_x_legend_size',
				`CHART_Y_COLOR` =  '$chart_y_color',
				`CHART_Y_PRECISION` =  '$chart_y_precision',
				`CHART_Y_CURRENCY` =  '$chart_y_currency',
				`CHART_Y_THICKNESS` =  '$chart_y_thickness',
				`CHART_Y_GRID_COLOR` =  '$chart_y_grid_color',
				`CHART_Y_GRID_LINES` =  '$chart_y_grid_lines',
				`CHART_Y_LABELS_COLOR` =  '$chart_y_labels_color',
				`CHART_Y_LABELS_SIZE` =  '$chart_y_labels_size',
				`CHART_Y_LABELS_ROTATION` =  '$chart_y_labels_rotation',
				`CHART_Y_LEGEND` =  '$chart_y_legend',
				`CHART_Y_LEGEND_COLOR` =  '$chart_y_legend_color',
				`CHART_Y_LEGEND_SIZE` =  '$chart_y_legend_size'
				where `chart_id` = $chart_id";
				
	return $this->wpdb->query($query);

}

function del($vo_chart){

	$where_clause = "";

	if(isset($vo_chart)){
		$chart_id = $vo_chart->chart_id;
		$where_clause = "where `chart_id` = $chart_id";
	}

	$query = "DELETE FROM ".$this->table_name." $where_clause"; 

	return $this->wpdb->query($query);

}

function rows(){

	$query = "SELECT * FROM ".$this->table_name;
	$rows = $this->wpdb->get_results($query);	
	return sizeof($rows);

}

}

?>
