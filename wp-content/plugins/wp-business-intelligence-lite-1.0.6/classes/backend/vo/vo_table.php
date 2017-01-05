<?php

/******************************************************************************
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


class vo_table{

var $id;
var $query_id;
var $name;
var $title;
var $rows_per_pg;
var $style_id;
var $has_header;
var $has_footer;
var $table_key;
var $encode_html;

function vo_table($id, $query_id, $name, $title, $rows_per_pg, $style_id, $has_header, $has_footer, $table_key, $encode_html){
$this->id = $id;
$this->query_id = $query_id;
$this->name = $name;
$this->title = $title;
$this->rows_per_pg = $rows_per_pg;
$this->style_id = $style_id;
$this->has_header = $has_header;
$this->has_footer = $has_footer;
$this->table_key = $table_key;
$this->encode_html = $encode_html;
}

function set_id($id){$this->id = $id;}
function set_query_id($query_id){$this->query_id = $query_id;}
function set_name($name){$this->name = $name;}
function set_title($title){$this->title = $title;}
function set_rows_per_pg($rows_per_pg){$this->rows_per_pg = $rows_per_pg;}
function set_style_id($style_id){$this->style_id = $style_id;}
function set_has_header($has_header){$this->has_header = $has_header;}
function set_has_footer($has_footer){$this->has_footer = $has_footer;}
function set_table_key($table_key){$this->table_key = $table_key;}
function set_encode_html($encode_html){$this->encode_html = $encode_html;}


}


?>
