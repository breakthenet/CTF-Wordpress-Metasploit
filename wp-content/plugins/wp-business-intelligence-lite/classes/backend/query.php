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

class query {

var $stmt;
var $wpdb;
var $table_name;
var $qy_limited = "select * from (%s) t limit %s, %s";
var $qy_count = "select count(*) from (%s) t";

function query($stmt, $wpdb, $table_name){
	$this->wpdb = $wpdb;
	$this->table_name= $table_name;

    //Parse for WP variables and replace with actual values
    $statement = $this->parse_variables($stmt);
	
	//Initializes variables 
	$dao_vars = new dao_vars($this->wpdb, $this->table_name);
	$vo_vars = $dao_vars->select();
	foreach($vo_vars as $vo_var){		
		if(isset($_GET[$vo_var->var_name])) { ${$vo_var->var_name} = $_GET[$vo_var->var_name]; }
		else if(isset($_POST[$vo_var->var_name])) { ${$vo_var->var_name} = $_POST[$vo_var->var_name]; }
		else{ ${$vo_var->var_name} = $vo_var->var_value; } //set the default value

        $statement = str_replace('$'.$vo_var->var_name, ${$vo_var->var_name}, $statement);
	}
	
	$this->stmt = $statement;
}
    // parse the SQL query and replace WP variables if present
function parse_variables($stmt){

    $new_stmt = $stmt;
    $token = "";

    if(strpos($stmt, '{{{') === false)
    {
        return $stmt;
    }
    else
    {
        while(!(strpos($new_stmt, '{{{') === false))
        {
            $token = $this->extract_unit($new_stmt, '{{{', '}}}');
            switch ($token){
                case 'user_ID':
                    $new_stmt = str_replace('{{{'.$token.'}}}', $GLOBALS['user_ID'], $new_stmt);
                break;
                case 'user_login':
                    $new_stmt = str_replace('{{{'.$token.'}}}', $GLOBALS['user_login'], $new_stmt);
                    break;
                case 'user_email':
                    $new_stmt = str_replace('{{{'.$token.'}}}', $GLOBALS['user_email'], $new_stmt);
                    break;
                case 'page_id':
                    $new_stmt = str_replace('{{{'.$token.'}}}', $GLOBALS['page_id'], $new_stmt);
                    break;
            }
        }
    }

    return $new_stmt;
}

// used to extract WP keywords from the SQL query

function extract_unit($string, $start, $end){

   $pos = stripos($string, $start);

   $str = substr($string, $pos);

   $str_two = substr($str, strlen($start));

   $second_pos = stripos($str_two, $end);

   $str_three = substr($str_two, 0, $second_pos);

   $unit = trim($str_three); // remove whitespaces

   return $unit;
}


    function limit_qy_to($start, $stop){
	return sprintf($this->qy_limited,$this->stmt,$start,$stop);
}

function count_qy_results(){
	return sprintf($this->qy_count,$this->stmt);
}


}


?>
