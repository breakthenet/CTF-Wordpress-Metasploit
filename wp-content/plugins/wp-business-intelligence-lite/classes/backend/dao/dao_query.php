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


class dao_query {

var $wpdb;
var $table_name;

function dao_query($wpdb, $table_name){
	
	$this->wpdb = $wpdb;
	$this->table_name= $table_name;

}

function select($vo_query){

	$where_clause = "";

	if(isset($vo_query)){
		$id = $vo_query->id;
		$where_clause = "where `query_id` = $id";
	}

	$query = "SELECT `QUERY_ID`, `DATABASE_ID`, `QUERY_NAME`, `QUERY_STATEMENT` FROM ".$this->table_name." $where_clause order by QUERY_NAME asc";
	$rows = $this->wpdb->get_results($query);
	$vo_query = array();
	foreach($rows as $row){
		$item = new vo_query($row->QUERY_ID,$row->DATABASE_ID,$row->QUERY_NAME,$row->QUERY_STATEMENT);
		array_push($vo_query, $item);
	}

	return $vo_query;

}

function add($vo_query){

	$id = $vo_query->id;
	$db_id = $vo_query->db_id;
	$name = $vo_query->name;
	$statement = str_replace("'","''",$vo_query->statement);
 
	$query = "INSERT INTO ".$this->table_name."(`database_id`, `query_name`, `query_statement`) values ('$db_id', '$name','$statement')";

	return $this->wpdb->query($query);

}

function edit($vo_query_old, $vo_query_new){
	
	$id = $vo_query_old->id;
	$db_id = $vo_query_new->db_id;
	$name = $vo_query_new->name;
	$statement = str_replace("'","''",$vo_query_new->statement);

	$query = "UPDATE ".$this->table_name." set`database_id` = '$db_id', `query_name` = '$name', `query_statement` = '$statement' where `query_id` = $id";

	return $this->wpdb->query($query);

}

function del($vo_query){

	$where_clause = "";

	if(isset($vo_query)){
		$id = $vo_query->id;
		$where_clause = "where `query_id` = $id";
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
