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


class dao_database {

var $wpdb;
var $table_name;
var $encryption_key;
var $wpbi_crypt;

const AES_KEY_SIZE	= 256;
const PWD_PADDING	= 256;

function dao_database($wpdb, $table_name){
	global $wpbi_settings;
	$this->wpdb = $wpdb;
	$this->table_name= $table_name;
	$this->encryption_key = $wpbi_settings['parameter']['encryption-key'];
    $this->wpbi_crypt = new wpbi_AesCtr();
}

function wpbi_pad($pwd)
{
    return str_pad($pwd, self::PWD_PADDING, $this->encryption_key, STR_PAD_RIGHT);
}

function wpbi_unpad($pwd)
{
    $pos = strpos($pwd, $this->encryption_key);
    $unpadded = substr($pwd, 0, $pos);
    return $unpadded;
}

    function select($vo_database){

	$where_clause = "";

	if(isset($vo_database)){
		$id = $vo_database->id;
		$where_clause = "where `db_id` = $id";
	}

	if(!isset($this->encryption_key) || $this->encryption_key==''){ //No Encryption
		$query = "SELECT `DB_ID`, `DB_NAME`, `DB_HOST`, `DB_USER`, `DB_PASS` FROM ".$this->table_name." $where_clause order by db_name asc";
        $rows = $this->wpdb->get_results($query);
	} else{ //Encryption
		//$query = "SELECT `DB_ID`, `DB_NAME`, `DB_HOST`, `DB_USER`, AES_DECRYPT(`DB_PASS`,'".$this->encryption_key."') DB_PASS FROM ".$this->table_name." $where_clause order by db_name asc";
        $query = "SELECT `DB_ID`, `DB_NAME`, `DB_HOST`, `DB_USER`, `DB_PASS` FROM ".$this->table_name." $where_clause order by db_name asc";
        $rows = $this->wpdb->get_results($query);

        $encrypted_pass = $rows[0]->DB_PASS;

        $decrypted_pass = $this->wpbi_crypt->decrypt($encrypted_pass, $this->encryption_key, self::AES_KEY_SIZE);
        $decrypted_pass = $this->wpbi_unpad($decrypted_pass);
        //$decrypted_pass = wpbi_crypt($encrypted_pass);

        $rows[0]->DB_PASS = $decrypted_pass;
	} 

	$vo_database = array();
	foreach($rows as $row){
		$item = new vo_database($row->DB_ID,$row->DB_NAME,$row->DB_HOST,$row->DB_USER,$row->DB_PASS);
		array_push($vo_database, $item);
	}

	return $vo_database;

}

function add($vo_database){

    //wls_simple_log("WPBI", "dao_database_add");
	$id = $vo_database->id;
	$name = $vo_database->name;
	$host = $vo_database->host;
	$user = $vo_database->user;
	$pass = $vo_database->pass;
 	
	if(!isset($this->encryption_key) || $this->encryption_key==''){ //No Encryption
		$query = "INSERT INTO ".$this->table_name."(`db_name`, `db_host`,`db_user`, `db_pass`) values ('$name', '$host','$user','$pass')";
	} else { //Encryption

        $encrypted_pass = $this->wpbi_crypt->encrypt($this->wpbi_pad($pass), $this->encryption_key, self::AES_KEY_SIZE);
        $query = "INSERT INTO ".$this->table_name."(`db_name`, `db_host`,`db_user`, `db_pass`) values ('$name', '$host','$user', '$encrypted_pass')";
        //wls_simple_log("WPBI", "New DB connection query created");
	}

	return $this->wpdb->query($query);

}

function edit($vo_database_old, $vo_database_new){
	
	$id = $vo_database_old->id;
	$name = $vo_database_new->name;
	$host = $vo_database_new->host;
	$user = $vo_database_new->user;
	$pass = $vo_database_new->pass;
	
	if(!isset($this->encryption_key) || $this->encryption_key==''){ //No Encryption
		$query = "UPDATE ".$this->table_name." set `db_name` = '$name', `db_host` = '$host', `db_user` = '$user', `db_pass` = '$pass' where `db_id` = $id";
	} else { //Encryption
        //$encrypted_pass = wpbi_crypt($pass);
        $encrypted_pass = $this->wpbi_crypt->encrypt($this->wpbi_pad($pass), $this->encryption_key, self::AES_KEY_SIZE);
		//$query = "UPDATE ".$this->table_name." set `db_name` = '$name', `db_host` = '$host', `db_user` = '$user', `db_pass` = AES_ENCRYPT('$pass','".$this->encryption_key."') where `db_id` = $id";
        $query = "UPDATE ".$this->table_name." set `db_name` = '$name', `db_host` = '$host', `db_user` = '$user', `db_pass` = '$encrypted_pass' where `db_id` = $id";
	}

	return $this->wpdb->query($query);

}

function del($vo_database){

	$where_clause = "";

	if(isset($vo_database)){
		$id = $vo_database->id;
		$where_clause = "where `db_id` = $id";
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
