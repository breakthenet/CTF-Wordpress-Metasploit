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


class dao_ch_cols {

var $wpdb;
var $table_name;

function dao_ch_cols($wpdb, $table_name){
	$this->wpdb = $wpdb;
	$this->table_name= $table_name;
}

function select($vo_ch_cols){

	$where_clause = "";

	if(isset($vo_ch_cols)){
		$id = $vo_ch_cols->ch_id;
		$where_clause = "where `chart_id` = $id";
	}

	$query = "SELECT `COL_ID`, `CHART_ID`, `COL_LABEL`, `COL_COLOR`, `IS_LABEL`, `IS_VALUE`, `IS_TIME` FROM ".$this->table_name." $where_clause order by COL_ID asc";
	$rows = $this->wpdb->get_results($query);	
	$vo_ch_cols = array();
	foreach($rows as $row){
		$item = new vo_ch_cols($row->COL_ID,$row->CHART_ID,$row->COL_LABEL,$row->COL_COLOR,$row->IS_LABEL,$row->IS_VALUE, $row->IS_TIME);
		array_push($vo_ch_cols, $item);
	}

	return $vo_ch_cols;

}

function add($vo_ch_cols){

	$id = $vo_ch_cols->id;
	$ch_id = $vo_ch_cols->ch_id;
	$col_label = $vo_ch_cols->col_label;
	$col_color = $vo_ch_cols->col_color;
	$is_label = $vo_ch_cols->is_label;
	$is_value = $vo_ch_cols->is_value;
    $is_time = $vo_ch_cols->is_time;

	$query = "INSERT INTO ".$this->table_name."(`CHART_ID`, `COL_LABEL`, `COL_COLOR`, `IS_LABEL`, `IS_VALUE`, `IS_TIME`) values ($ch_id, '$col_label','$col_color',$is_label,$is_value, $is_time)";

	return $this->wpdb->query($query);

}

function edit($vo_ch_cols_old, $vo_ch_cols_new){
	
	$id = $vo_ch_cols_old->id;
	$ch_id = $vo_ch_cols_new->ch_id;
	$col_label = $vo_ch_cols_new->col_label;
	$col_color = $vo_ch_cols_new->col_color;
	$is_label = $vo_ch_cols_new->is_label;
	$is_value = $vo_ch_cols_new->is_value;
    $is_time = $vo_ch_cols_new->is_time;

	$query = "UPDATE ".$this->table_name." set `chart_id` = $ch_id, `col_label` = '$col_label', `col_color` = '$col_color', `is_label` = $is_label, `is_value` = $is_value, `is_time` = $is_time where `col_id` = $id";
echo $query;
	return $this->wpdb->query($query);

}

function del($vo_ch_cols){

	$where_clause = "";

	if(isset($vo_ch_cols)){
		$id = $vo_ch_cols->ch_id;
		$where_clause = "where `chart_id` = $id";
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
