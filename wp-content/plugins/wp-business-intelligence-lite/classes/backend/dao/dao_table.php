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


class dao_table {

var $wpdb;
var $table_name;

function dao_table($wpdb, $table_name){
	$this->wpdb = $wpdb;
	$this->table_name= $table_name;
}

function select($vo_table){

	$where_clause = "";

	if(isset($vo_table)){
		$id = $vo_table->id;
		$where_clause = "where `table_id` = $id";
	}

	$query = "SELECT `TABLE_ID`, `QUERY_ID`, `NAME`, `TITLE`, `ROWS_PER_PG`, `STYLE_ID`, `HAS_HEADER`, `HAS_FOOTER`, `TABLE_KEY`, `ENCODE_HTML` FROM ".$this->table_name." $where_clause order by name asc";
	$rows = $this->wpdb->get_results($query);	
	$vo_table = array();
	foreach($rows as $row){
		$item = new vo_table($row->TABLE_ID,$row->QUERY_ID,$row->NAME,$row->TITLE,$row->ROWS_PER_PG, $row->STYLE_ID,$row->HAS_HEADER,$row->HAS_FOOTER,$row->TABLE_KEY,$row->ENCODE_HTML);
		array_push($vo_table, $item);
	}

	return $vo_table;

}

function select_by_key($vo_table){

	$where_clause = "";

	if(isset($vo_table)){
		$id = $vo_table->table_key;
		$where_clause = "where `table_key` = '$id'";
	}

	$query = "SELECT `TABLE_ID`, `QUERY_ID`, `NAME`, `TITLE`, `ROWS_PER_PG`, `STYLE_ID`, `HAS_HEADER`, `HAS_FOOTER`, `TABLE_KEY`, `ENCODE_HTML` FROM ".$this->table_name." $where_clause order by name asc";
	$rows = $this->wpdb->get_results($query);	
	$vo_table = array();
	foreach($rows as $row){
		$item = new vo_table($row->TABLE_ID,$row->QUERY_ID,$row->NAME,$row->TITLE,$row->ROWS_PER_PG, $row->STYLE_ID,$row->HAS_HEADER,$row->HAS_FOOTER,$row->TABLE_KEY,$row->ENCODE_HTML);
		array_push($vo_table, $item);
	}

	return $vo_table;

}

function add($vo_table){

	$id = $vo_table->id;
	$query_id = $vo_table->query_id;
	$name = $vo_table->name;
	$title = $vo_table->title;
	$rows_per_pg = $vo_table->rows_per_pg;
	$style_id = $vo_table->style_id;
	$has_header = $vo_table->has_header;
	$has_footer = $vo_table->has_footer;
	$table_key = $vo_table->table_key;
	$encode_html = $vo_table->encode_html;
 
	$query = "INSERT INTO ".$this->table_name."(`QUERY_ID`, `NAME`, `TITLE`, `ROWS_PER_PG`, `STYLE_ID`, `HAS_HEADER`, `HAS_FOOTER`, `TABLE_KEY`, `ENCODE_HTML`) values ($query_id, '$name','$title',$rows_per_pg,'$style_id',$has_header,$has_footer,'$table_key',$encode_html)";

return $this->wpdb->query($query);

}

function edit($vo_table_old, $vo_table_new){
	
	$id = $vo_table_old->id;
	$query_id = $vo_table_new->query_id;
	$name = $vo_table_new->name;
	$title = $vo_table_new->title;
	$rows_per_pg = $vo_table_new->rows_per_pg;
	$style_id = $vo_table_new->style_id;
	$has_header = $vo_table_new->has_header;
	$has_footer = $vo_table_new->has_footer;
	$table_key = $vo_table_new->table_key; //Not included in edit statement
	$encode_html = $vo_table_new->encode_html;

	$query = "UPDATE ".$this->table_name." set `query_id` = $query_id, `name` = '$name', `title` = '$title', `rows_per_pg` = $rows_per_pg, `style_id` = '$style_id', `has_header` = $has_header, `has_footer` = $has_footer, `encode_html` = $encode_html where `table_id` = $id";

	return $this->wpdb->query($query);

}

function del($vo_table){

	$where_clause = "";

	if(isset($vo_table)){
		$id = $vo_table->id;
		$where_clause = "where `table_id` = $id";
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
