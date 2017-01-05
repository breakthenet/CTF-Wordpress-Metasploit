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


class dao_tb_cols {

var $wpdb;
var $table_name;

function dao_tb_cols($wpdb, $table_name){
	$this->wpdb = $wpdb;
	$this->table_name= $table_name;
}

function select($vo_tb_cols){

	$where_clause = "";

	if(isset($vo_tb_cols)){
		$id = $vo_tb_cols->tb_id;
		$where_clause = "where `tb_id` = $id";
	}

	$query = "SELECT `COL_ID`, `TB_ID`, `COL_LABEL`, `IS_VISIBLE` FROM ".$this->table_name." $where_clause order by COL_ID asc";
	$rows = $this->wpdb->get_results($query);	
	$vo_tb_cols = array();
	foreach($rows as $row){
		$item = new vo_tb_cols($row->COL_ID,$row->TB_ID,$row->COL_LABEL,$row->IS_VISIBLE);
		array_push($vo_tb_cols, $item);
	}

	return $vo_tb_cols;

}

function add($vo_tb_cols){

	$id = $vo_tb_cols->id;
	$tb_id = $vo_tb_cols->tb_id;
	$col_label = $vo_tb_cols->col_label;
	$is_visible = $vo_tb_cols->is_visible;

	$query = "INSERT INTO ".$this->table_name."(`tb_id`, `col_label`,`is_visible`) values ($tb_id, '$col_label',$is_visible)";

	return $this->wpdb->query($query);

}

function edit($vo_tb_cols_old, $vo_tb_cols_new){
	
	$id = $vo_tb_cols_old->id;
	$tb_id = $vo_tb_cols_new->tb_id;
	$col_label = $vo_tb_cols_new->col_label;
	$is_visible = $vo_tb_cols_new->is_visible;

	$query = "UPDATE ".$this->table_name." set `tb_id` = $tb_id, `col_label` = '$col_label', `is_visible` = $is_visible where `col_id` = $id";

	return $this->wpdb->query($query);

}

function del($vo_tb_cols){

	$where_clause = "";

	if(isset($vo_tb_cols)){
		$id = $vo_tb_cols->tb_id;
		$where_clause = "where `tb_id` = $id";
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
