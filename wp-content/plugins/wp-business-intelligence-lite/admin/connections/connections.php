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


/***********************/
/***  SET TEMPLATE   ***/
/***********************/
$template_site->set_filenames(array(
	'header' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['header'],
	'footer' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['footer'],
	'connections-new' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['connections-new'],
	'connections-edit' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['connections-edit']
));
?>

<?php
/***********************/
/***   ADD ACTION    ***/
/***********************/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['add']){
	$vo_database = new vo_database(NULL, $_POST[$wpbi_settings['parameter']['db_name']], $_POST[$wpbi_settings['parameter']['db_host']], $_POST[$wpbi_settings['parameter']['db_user']], $_POST[$wpbi_settings['parameter']['db_pass']]);
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$dao_database->add($vo_database);
    //wls_simple_log("WPBI", " New connection added");
}
?>

<?php
/***********************/
/***  DROP ACTION    ***/
/***********************/

/*** GLOBAL ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop']){
	//Get list of connections to be deleted
	$selected_queries = $_POST['post'];
	for($conn_idx=0; $conn_idx<sizeof($selected_queries); $conn_idx++){
		$vo_database = new vo_database($selected_queries[$conn_idx], NULL, NULL, NULL, NULL);
		$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
		$dao_database->del($vo_database);
	}
}

/*** SINGLE ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop'] && isset($_GET[$wpbi_settings['parameter']['db_id']])){
	$selected_query = $_GET[$wpbi_settings['parameter']['db_id']];
	$vo_database = new vo_database($selected_query, NULL, NULL, NULL, NULL);
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$dao_database->del($vo_database);
}

?>

<?php
/***********************/
/***   TEST ACTION   ***/
/***********************/

/**** Test a new connection ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['test'] || $_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit-test']){
	$test_is_ok = mysql_connect($_POST[$wpbi_settings['parameter']['db_host']], $_POST[$wpbi_settings['parameter']['db_user']], $_POST[$wpbi_settings['parameter']['db_pass']]);// &&  mysql_select_db($_POST[$wpbi_settings['parameter']['db_name']]);
	$test_result = '';
	if($test_is_ok){
		$test_result = $wpbi_dialog['msg']['ok']['connection-working'];
	} else {
		$test_result = $wpbi_dialog['msg']['error']['connection-error'];
	}

}
/**** Test a saved connection ***/
else if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['test'] && is_numeric($_GET[$wpbi_settings['parameter']['db_id']])){
	//Get selected db
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$tgt_database = new vo_database($_GET[$wpbi_settings['parameter']['db_id']], NULL, NULL, NULL, NULL);
	$vo_database = $dao_database->select($tgt_database);
	$vo_database = $vo_database[0];
	
	$test_is_ok = mysql_connect($vo_database->host, $vo_database->user, $vo_database->pass);
	$test_result = '';
	if($test_is_ok){
		$test_result = $wpbi_dialog['msg']['ok']['connection-working'];
	} else {
		$test_result = $wpbi_dialog['msg']['error']['connection-error'].$vo_database->host.$vo_database->user.$vo_database->pass;
	}
	echo '
	<script>
		jQuery(document).ready(function() {
			alert("'.strip_tags($test_result).'");
		});
	</script>
	';
	$test_result = '';
}
?>

<?php
/***********************/
/***   EDIT ACTION   ***/
/***********************/

/**** Edit db form ***/
if(($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_GET[$wpbi_settings['parameter']['db_id']]) )   || $_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit-test']){
	//Get selected db
	$db_id = isset($_GET[$wpbi_settings['parameter']['db_id']]) ? $_GET[$wpbi_settings['parameter']['db_id']] : $_POST[$wpbi_settings['parameter']['db_id']];
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$tgt_database = new vo_database($db_id, NULL, NULL, NULL, NULL);
	$vo_database = $dao_database->select($tgt_database);
	$vo_database = $vo_database[0];
	
	//Prepare output
	$template_site->assign_vars(array(
	/* Header */
	'PG_TITLE' 			=> $wpbi_dialog['page']['connections']['title'],
	'PG_DESCRIPTION' 	=> $wpbi_dialog['action']['connections']['edit'],
	
	/* New db form */
	'CONN_EDIT_NAME' 		=> $wpbi_dialog['field']['connections']['name'],
	'CONN_EDIT_HOST' 		=> $wpbi_dialog['field']['connections']['host'],
	'CONN_EDIT_USER' 		=> $wpbi_dialog['field']['connections']['user'],
	'CONN_EDIT_PASS' 		=> $wpbi_dialog['field']['connections']['pass'],
	'P_DB_ID' 				=> $wpbi_settings['parameter']['db_id'],
	'V_DB_ID' 				=> $vo_database->id,
	'P_CONN_NAME' 			=> $wpbi_settings['parameter']['db_name'],
	'V_CONN_NAME' 			=> isset($_POST[$wpbi_settings['parameter']['db_name']]) ? $_POST[$wpbi_settings['parameter']['db_name']]: $vo_database->name,
	'P_CONN_HOST' 			=> $wpbi_settings['parameter']['db_host'],
	'V_CONN_HOST' 			=> isset($_POST[$wpbi_settings['parameter']['db_host']]) ? $_POST[$wpbi_settings['parameter']['db_host']]: $vo_database->host,
	'P_CONN_USER' 			=> $wpbi_settings['parameter']['db_user'],
	'V_CONN_USER' 			=> isset($_POST[$wpbi_settings['parameter']['db_user']]) ? $_POST[$wpbi_settings['parameter']['db_user']]: $vo_database->user,
	'P_CONN_PASS' 			=> $wpbi_settings['parameter']['db_pass'],
	'V_CONN_PASS' 			=> isset($_POST[$wpbi_settings['parameter']['db_pass']]) ? $_POST[$wpbi_settings['parameter']['db_pass']]: $vo_database->pass,
	'P_CONN_ACTION' 		=> $wpbi_settings['parameter']['action'],
	'V_EDIT_ACTION' 		=> $wpbi_settings['value']['edit'],
	'V_TEST_ACTION' 	=> $wpbi_settings['value']['edit-test'],
	'LBL_BTN_ADD' 		=> $wpbi_dialog['label']['button']['add'],
	'LBL_BTN_TEST' 		=> $wpbi_dialog['label']['button']['test'],
	'CONN_EDIT_FORM_ACTION'=> substr((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)),  0, strpos((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)), '&')),
	'CONN_TEST_RESULT'	=> $test_result
	)
	);
	
	//output page header and database form
	$template_site->pparse('header');
	$template_site->pparse('connections-edit');
}

/**** Edit database: save modifications ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_POST[$wpbi_settings['parameter']['db_id']]) && isset($_POST[$wpbi_settings['parameter']['db_host']]) && isset($_POST[$wpbi_settings['parameter']['db_name']]) && isset($_POST[$wpbi_settings['parameter']['db_user']]) && isset($_POST[$wpbi_settings['parameter']['db_pass']])){

	$selected_db = $_POST[$wpbi_settings['parameter']['db_id']];
	$old_db = new vo_database($selected_db, NULL, NULL, NULL, NULL);
	$new_db = new vo_database($selected_db, $_POST[$wpbi_settings['parameter']['db_name']], $_POST[$wpbi_settings['parameter']['db_host']], $_POST[$wpbi_settings['parameter']['db_user']], $_POST[$wpbi_settings['parameter']['db_pass']]);
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$dao_database->edit($old_db, $new_db);

}

?>

<?php
/***********************/
/***     DEFAULT     ***/
/***********************/

if($_GET[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit'] && $_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test']) {
	
	//Prepare output
	$template_site->assign_vars(array(
	/* Header */
	'PG_TITLE' 			=> $wpbi_dialog['page']['connections']['title'],
	'PG_DESCRIPTION' 	=> $wpbi_dialog['page']['connections']['description'],
	
	/* New query form */
	'CONN_NEW_NAME' 		=> $wpbi_dialog['field']['connections']['name'],
	'CONN_NEW_HOST' 		=> $wpbi_dialog['field']['connections']['host'],
	'CONN_NEW_USER' 		=> $wpbi_dialog['field']['connections']['user'],
	'CONN_NEW_PASS' 		=> $wpbi_dialog['field']['connections']['pass'],
	'P_CONN_NAME' 			=> $wpbi_settings['parameter']['db_name'],
	'V_CONN_NAME' 			=> $_POST[$wpbi_settings['parameter']['db_name']],
	'P_CONN_HOST' 			=> $wpbi_settings['parameter']['db_host'],
	'V_CONN_HOST' 			=> $_POST[$wpbi_settings['parameter']['db_host']],
	'P_CONN_USER' 			=> $wpbi_settings['parameter']['db_user'],
	'V_CONN_USER' 			=> $_POST[$wpbi_settings['parameter']['db_user']],
	'P_CONN_PASS' 			=> $wpbi_settings['parameter']['db_pass'],
	'V_CONN_PASS' 			=> $_POST[$wpbi_settings['parameter']['db_pass']],
	'P_CONN_ACTION' 		=> $wpbi_settings['parameter']['action'],
	'V_ADD_ACTION' 		=> $wpbi_settings['value']['add'],
	'V_TEST_ACTION' 	=> $wpbi_settings['value']['test'],
	'LBL_BTN_ADD' 		=> $wpbi_dialog['label']['button']['add'],
	'LBL_BTN_TEST' 		=> $wpbi_dialog['label']['button']['test'],
	'CONN_TEST_RESULT'	=> $test_result
	)
	);
	
	//output page header and query form
	$template_site->pparse('header');
	$template_site->pparse('connections-new');
	
	//Get saved connections
	$qy_databases = "
		SELECT `DB_ID` , CONCAT(  `DB_NAME` ,  '(',  `DB_USER` ,  '@',  `DB_HOST` ,  ')' )  \"DATABASE\",   `DB_NAME` ,  `DB_HOST` ,  `DB_USER`   
		FROM ".$wpbi_sql['tname']['databases']." order by CONCAT(  `DB_NAME` ,  '(',  `DB_USER` ,  '@',  `DB_HOST` ,  ')' ) asc";

	$query = new query($qy_databases, $wpdb, $wpbi_sql['tname']['vars']);
	$total_rows = $wpdb->get_results($query->count_qy_results(),'ARRAY_N');
	$total_rows = intval($total_rows[0][0]);
	
	//Page navigation
		$pagination = new pagination();
		$pagination->set_pg_interval($wpbi_settings['parameter']['page-interval']);
		$pagination->set_pg_parameter('pg');
		$pagination->set_current_page(isset( $_GET[$pagination->pg_parameter] ) ? abs( (int) $_GET[$pagination->pg_parameter] ) : 1);
		$pagination->set_rows($total_rows);
		$pagination->set_css_class('widefat post fixed');
		$pagination->set_pagination_stats($wpbi_dialog['table']['pagination']['stats']);
		$pagination->set_paginate_links(
						paginate_links( array(
			    		'base' => add_query_arg( $pagination->pg_parameter, '%#%' ),
					    'format' => '',
					    'prev_text' => __($wpbi_dialog['table']['pagination']['prev_text']),
			    		'next_text' => __($wpbi_dialog['table']['pagination']['next_text']),
					    'total' => ceil(($pagination->rows) / $pagination->pg_interval),
					    'current' => $pagination->current_page
						))
					);
		$pagination->initialize();

		echo $pagination->get_html();
	//END page navigation
	
	//Execute query limitng the resultset
	$qy_databases_rows = $wpdb->get_results($query->limit_qy_to($pagination->item_start-1, $pagination->pg_interval),'ARRAY_N');
	
	//Output table
	$column_headers = array($wpbi_dialog['header']['connections']['alias'],$wpbi_dialog['header']['connections']['name'],$wpbi_dialog['header']['connections']['host'], $wpbi_dialog['header']['connections']['user']);
	$single_actions = array ( 	"edit"  => array ( 	"label" 	=> "Edit",
	                                   				"page" 		=> $wpbi_url['slug']['connections'],
	                                   				"action" 	=> $wpbi_settings['value']['edit'],
													"parameter"	=> $wpbi_settings['parameter']['db_id']
	                                    			),
								"test"  => array ( 	"label" 	=> "Test",
	                                   				"page" 		=> $wpbi_url['slug']['connections'],
	                                   				"action" 	=> $wpbi_settings['value']['test'],
													"parameter"	=> $wpbi_settings['parameter']['db_id']
	                                    			),
								"drop"  => array ( 	"label" 	=> "Drop",
	                                   				"page" 		=> $wpbi_url['slug']['connections'],
	                                   				"action" 	=> $wpbi_settings['value']['drop'],
													"parameter"	=> $wpbi_settings['parameter']['db_id']
	                                    			)
	               			);
	$global_actions = array ( 	"drop"  => array ( 	"label" 	=> "Drop",
	                                   				"value" 	=> $wpbi_settings['value']['drop']
	                                    			)
	               			);
	$table_form = new table_form();
	$table_form->set_css_class('widefat post fixed');
	$table_form->set_rows($qy_databases_rows);
	$table_form->set_cols($column_headers);
	$table_form->has_header(true);
	$table_form->has_footer(true);
	$table_form->encode_html(true);
	$table_form->set_single_actions($single_actions);
	$table_form->set_global_actions($global_actions);
	$table_form->set_gobal_checkbox_id('post_all');
	$table_form->set_form_action(substr((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)),  0, strpos((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)), '&')));
	$table_form->set_form_id('manage_queries');
	$table_form->set_form_method('post');
	
	echo $table_form->get_html();

} //End condition about edit action

//output page footer
$template_site->pparse('footer');

?>