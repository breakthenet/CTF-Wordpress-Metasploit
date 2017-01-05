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


/***********************/
/***  SET TEMPLATE   ***/
/***********************/
$template_site->set_filenames(array(
	'header' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['header'],
	'footer' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['footer'],
	'queries-new' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['queries-new'],
	'queries-edit' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['queries-edit']
));
?>

<?php
//Strip slashes
if(isset($_POST[$wpbi_settings['parameter']['qy_statement']])){
	$_POST[$wpbi_settings['parameter']['qy_statement']] = stripslashes($_POST[$wpbi_settings['parameter']['qy_statement']]);
}
?>

<?php
/***********************/
/***   ADD ACTION    ***/
/***********************/

if($_POST[$wpbi_settings['parameter']['action']] == 'add'){
	$vo_query = new vo_query(NULL, $_POST[$wpbi_settings['parameter']['qy_db']], $_POST[$wpbi_settings['parameter']['qy_name']], $_POST[$wpbi_settings['parameter']['qy_statement']]);
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$dao_query->add($vo_query);
}

?>

<?php
/***********************/
/***  DROP ACTION    ***/
/***********************/

/*** GLOBAL ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop']){
	//Get list of queries to be deleted
	$selected_queries = $_POST['post'];
	for($conn_idx=0; $conn_idx<sizeof($selected_queries); $conn_idx++){
		$vo_query = new vo_query($selected_queries[$conn_idx], NULL, NULL, NULL);
		$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
		$dao_query->del($vo_query);
	}
}

/*** SINGLE ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop'] && isset($_GET[$wpbi_settings['parameter']['qy_id']])){
	$selected_query = $_GET[$wpbi_settings['parameter']['qy_id']];
	$vo_query = new vo_query($selected_query, NULL, NULL, NULL);
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$dao_query->del($vo_query);
}

?>

<?php
/***********************/
/***  COPY ACTION    ***/
/***********************/

/*** SINGLE ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['copy'] && isset($_GET[$wpbi_settings['parameter']['qy_id']])){
	$selected_query = $_GET[$wpbi_settings['parameter']['qy_id']];
	$vo_query = new vo_query($selected_query, NULL, NULL, NULL);
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$vo_query = $dao_query->select($vo_query);
	$vo_query = $vo_query[0];
	$vo_query->set_name($wpbi_dialog['item']['name']['copy'].$vo_query->name);
	$dao_query->add($vo_query);
	
}

?>

<?php
/***********************/
/***   TEST ACTION   ***/
/***********************/

/**** Test new query ***/
if(($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['test'] || $_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit-test']) && isset($_POST[$wpbi_settings['parameter']['qy_db']]) && isset($_POST[$wpbi_settings['parameter']['qy_statement']])){

	$test_output = ''; //Store the test output to be displayed at the bottom of the page

	if(strpos(ltrim(strtoupper($_POST[$wpbi_settings['parameter']['qy_statement']])),'SELECT')===0){ //Query has to be a select statement
	
	//Get database connection
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$tgt_database = new vo_database($_POST[$wpbi_settings['parameter']['qy_db']], NULL, NULL, NULL, NULL);
	$vo_database = $dao_database->select($tgt_database);
	$vo_database = $vo_database[0];


	
	//Create wpdb object and execute the query
	$query = new query($_POST[$wpbi_settings['parameter']['qy_statement']], $wpdb, $wpbi_sql['tname']['vars']);
	$my_test_db = new wpdb($vo_database->user,$vo_database->pass,$vo_database->name,$vo_database->host);
	$total_rows = $my_test_db->get_results($query->count_qy_results(),'ARRAY_N');
	$total_rows = intval($total_rows[0][0]); 

	if($total_rows == 0){
		$test_output = $test_output.$wpbi_dialog['msg']['query']['no-records'];
	}
	else {
	//Execute query limitng the resultset
	$my_test_rows = $my_test_db->get_results($query->limit_qy_to(0, $wpbi_settings['parameter']['page-interval']),'ARRAY_N');
	$my_test_cols = $my_test_db->get_col_info('name');
	
	//Output table
    if($total_rows > 20)
    {
	    $test_output = $test_output.sprintf($wpbi_dialog['query']['new']['test'], $total_rows, $wpbi_settings['parameter']['page-interval']);
    }
	$table = new table();
	$table->set_table_tpl_path($wpbi_url['tpl']);
	$table->set_css_class('widefat');
	$table->set_rows($my_test_rows);
	$table->set_cols($my_test_cols);
	$table->has_header(true);
	$table->has_footer(true);
	$table->encode_html(true);
	$test_output = $test_output.$table->get_html();
	}
}
else {
		$test_output = $test_output.$wpbi_dialog['msg']['error']['only-select-allowed'];
	}
}

/**** Test a saved query ***/
else if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['test'] && is_numeric($_GET[$wpbi_settings['parameter']['qy_id']])){

	$test_output = ''; //Store the test output 

	//Get selected query
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$tgt_query = new vo_query($_GET[$wpbi_settings['parameter']['qy_id']], NULL, NULL, NULL, NULL);
	$vo_query = $dao_query->select($tgt_query);
	$vo_query = $vo_query[0];
	
	//Select associated db
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$tgt_database = new vo_database($vo_query->db_id, NULL, NULL, NULL, NULL);
	$vo_database = $dao_database->select($tgt_database);
	$vo_database = $vo_database[0];
	
	//Create wpdb object and execute the query
	$my_test_db = new wpdb($vo_database->user,$vo_database->pass,$vo_database->name,$vo_database->host);
	$query = new query($vo_query->statement, $wpdb, $wpbi_sql['tname']['vars']);
	$total_rows = $my_test_db->get_results($query->count_qy_results(),'ARRAY_N');
	$total_rows = intval($total_rows[0][0]); 
	if($total_rows == 0){
		$test_output = $test_output.$wpbi_dialog['msg']['query']['no-records'];
	}
	else {

	//Page navigation
		$pagination = new pagination();
		$pagination->set_pagination_tpl_path($wpbi_url['tpl']);
		$pagination->set_pg_interval($wpbi_settings['parameter']['page-interval']);
		$pagination->set_pg_parameter('paged');
		$pagination->set_current_page(isset( $_GET[$pagination->pg_parameter] ) ? abs( (int) $_GET[$pagination->pg_parameter] ) : 1);
		$pagination->set_rows($total_rows);
		$pagination->set_css_class('widefat');
		$pagination->set_pagination_stats($wpbi_dialog['table']['pagination']['stats']);
		$pagination->set_paginate_links(
						paginate_links( array(
			    		'base' => add_query_arg( $pagination->pg_parameter, '%#%' ),
					    'format' => '',
					    'prev_text' => $wpbi_dialog['table']['pagination']['prev_text'],
			    		'next_text' => $wpbi_dialog['table']['pagination']['next_text'],
					    'total' => ceil(($pagination->rows) / $pagination->pg_interval),
					    'current' => $pagination->current_page
						))
					);
		$pagination->initialize();
		
	//END page navigation

	//Execute query limitng the resultset
	$my_test_rows = $my_test_db->get_results($query->limit_qy_to($pagination->item_start-1, $pagination->pg_interval),'ARRAY_N');
	$my_test_cols = $my_test_db->get_col_info('name');
	
	//Output table
	$table = new table();
	$table->set_table_tpl_path($wpbi_url['tpl']);
	$table->set_table_pagination($pagination->get_html());
	$table->set_css_class('widefat');
	$table->set_rows($my_test_rows);
	$table->set_cols($my_test_cols);
	$table->has_header(true);
	$table->has_footer(true);
	$table->encode_html(true);
	$test_output = $test_output.$table->get_html();

			
	}
	
	//Prepare output
	$template_site->assign_vars(array(
	/* Header */
	'PG_TITLE' 			=> $wpbi_dialog['page']['queries']['title'],
	'PG_DESCRIPTION' 	=> sprintf($wpbi_dialog['query']['saved']['test'], $vo_query->name, htmlentities($query->stmt))
	));
	
	$template_site->pparse('header');
	echo $test_output;
	$template_site->pparse('footer');

}


?>

<?php
/***********************/
/***   EDIT ACTION   ***/
/***********************/

/**** Edit query form ***/
if(($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_GET[$wpbi_settings['parameter']['qy_id']]) ) || $_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit-test']){
	$selected_query = isset($_GET[$wpbi_settings['parameter']['qy_id']]) ? $_GET[$wpbi_settings['parameter']['qy_id']] : $_POST[$wpbi_settings['parameter']['qy_id']];
	$vo_query = new vo_query($selected_query, NULL, NULL, NULL);
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$vo_query = $dao_query->select($vo_query);
	$vo_query = $vo_query[0];
	
	//Database select options
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$vo_database = $dao_database->select(NULL);
	if(sizeof($vo_database)==0){
		echo'
		<p>'.$wpbi_dialog['msg']['warning']['only-select-allowed'].'</p>
		';
	} 
	else {
		$select_options = '';
		for ($index=0;$index<sizeof($vo_database);$index++){
			$selected = '';
			//Remember the selected value
			if(((int)(isset($_POST[$wpbi_settings['parameter']['qy_db']]) ? $_POST[$wpbi_settings['parameter']['qy_db']] : $vo_query->db_id))==($vo_database[$index]->id)){$selected = 'selected';}
			$select_options = $select_options.'			
			<option '.$selected.' value="'.$vo_database[$index]->id.'">'.$vo_database[$index]->name.' ('.$vo_database[$index]->user.'@'.$vo_database[$index]->host.')</option>
			';
		}	
	}
	
	//Prepare output
	$template_site->assign_vars(array(
	/* Header */
	'PG_TITLE' 			=> $wpbi_dialog['page']['queries']['title'],
	'PG_DESCRIPTION' 	=> sprintf($wpbi_dialog['query']['saved']['edit'], $vo_query->name, htmlentities($query->stmt)),
	
	/* New query form */
	'QY_EDIT_CONNECTION' => $wpbi_dialog['field']['queries']['connection'],
	'QY_EDIT_NAME' 		=> $wpbi_dialog['field']['queries']['name'],
	'P_QY_NAME' 		=> $wpbi_settings['parameter']['qy_name'],
	'V_QY_NAME' 		=> isset($_POST[$wpbi_settings['parameter']['qy_name']]) ? $_POST[$wpbi_settings['parameter']['qy_name']] : $vo_query->name,
	'QY_EDIT_STMT' 		=> $wpbi_dialog['field']['queries']['statement'],
	'P_QY_STMT' 		=> $wpbi_settings['parameter']['qy_statement'],
	'P_QY_ID' 			=> $wpbi_settings['parameter']['qy_id'],
	'V_QY_ID' 			=> $vo_query->id,
	'V_QY_STMT' 		=> isset($_POST[$wpbi_settings['parameter']['qy_statement']]) ? $_POST[$wpbi_settings['parameter']['qy_statement']] : $vo_query->statement,
	'QY_EDIT_DB_OPTIONS'=> $select_options,
	'QY_EDIT_FORM_ACTION'=> substr((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)),  0, strpos((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)), '&')),
	'P_QY_DB' 			=> $wpbi_settings['parameter']['qy_db'],
	'P_QY_ACTION' 		=> $wpbi_settings['parameter']['action'],
	'V_EDIT_ACTION' 	=> $wpbi_settings['value']['edit'],
	'V_TEST_ACTION' 	=> $wpbi_settings['value']['edit-test'],
	'LBL_BTN_SAVE' 		=> $wpbi_dialog['label']['button']['add'],
	'LBL_BTN_TEST' 		=> $wpbi_dialog['label']['button']['test']
	)
	);
	
	//output page header and query form
	$template_site->pparse('header');
	$template_site->pparse('queries-edit');
	
	//Output new query test result (if any)
	echo $test_output;
}

/**** Edit query: save modifications ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_POST[$wpbi_settings['parameter']['qy_id']]) && isset($_POST[$wpbi_settings['parameter']['qy_db']]) && isset($_POST[$wpbi_settings['parameter']['qy_statement']]) && isset($_POST[$wpbi_settings['parameter']['qy_name']])){

	$selected_query = $_POST[$wpbi_settings['parameter']['qy_id']];
	$old_query = new vo_query($selected_query, NULL, NULL, NULL);
	$new_query = new vo_query($selected_query, $_POST[$wpbi_settings['parameter']['qy_db']], $_POST[$wpbi_settings['parameter']['qy_name']], $_POST[$wpbi_settings['parameter']['qy_statement']]);
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$dao_query->edit($old_query, $new_query);

}

?>

<?php
/***********************/
/***     DEFAULT     ***/
/***********************/

/**** Build form to create new query and display the created query ***/
if($_GET[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['test'] && $_GET[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit']  && $_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test']) {

//Database select options
$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
$vo_database = $dao_database->select(NULL);
if(sizeof($vo_database)==0){
	echo'
	<p>'.$wpbi_dialog['msg']['warning']['no-connections'].'</p>
	';
} 
else {
	$select_options = '';
	for ($index=0;$index<sizeof($vo_database);$index++){
		$selected = '';
		if(((int)$_POST[$wpbi_settings['parameter']['qy_db']])==($vo_database[$index]->id)){$selected = 'selected';}
		$select_options = $select_options.'			
		<option '.$selected.' value="'.$vo_database[$index]->id.'">'.$vo_database[$index]->name.' ('.$vo_database[$index]->user.'@'.$vo_database[$index]->host.')</option>
		';
	}	
}

//Prepare output
$template_site->assign_vars(array(
/* Header */
'PG_TITLE' 			=> $wpbi_dialog['page']['queries']['title'],
'PG_DESCRIPTION' 	=> $wpbi_dialog['page']['queries']['description'],

/* New query form */
'QY_NEW_CONNECTION' => $wpbi_dialog['field']['queries']['connection'],
'QY_NEW_NAME' 		=> $wpbi_dialog['field']['queries']['name'],
'P_QY_NAME' 		=> $wpbi_settings['parameter']['qy_name'],
'V_QY_NAME' 		=> $_POST[$wpbi_settings['parameter']['qy_name']],
'QY_NEW_STMT' 		=> $wpbi_dialog['field']['queries']['statement'],
'P_QY_STMT' 		=> $wpbi_settings['parameter']['qy_statement'],
'V_QY_STMT' 		=> $_POST[$wpbi_settings['parameter']['qy_statement']],
'QY_NEW_DB_OPTIONS'	=> $select_options,
'P_QY_DB' 			=> $wpbi_settings['parameter']['qy_db'],
'P_QY_ACTION' 		=> $wpbi_settings['parameter']['action'],
'V_ADD_ACTION' 		=> $wpbi_settings['value']['add'],
'V_TEST_ACTION' 	=> $wpbi_settings['value']['test'],
'LBL_BTN_ADD' 		=> $wpbi_dialog['label']['button']['add'],
'LBL_BTN_TEST' 		=> $wpbi_dialog['label']['button']['test']
)
);

//output page header and query form
$template_site->pparse('header');
$template_site->pparse('queries-new');

//Output new query test result (if any)
echo $test_output;

//*** Query Manager ***

//To be display only when the user is not testin a new query
if($_POST[$wpbi_settings['parameter']['action']] != 'test') {

	//Get saved queries
	$qy_queries = "
		SELECT `QUERY_ID`, `QUERY_NAME`, CONCAT(`DB_NAME`,'(',`DB_USER`,'@',`DB_HOST`,')') \"DATABASE\" , `QUERY_STATEMENT` 
		FROM ".$wpbi_sql['tname']['queries'].", ".$wpbi_sql['tname']['databases']."
		WHERE `DATABASE_ID` = `DB_ID` order by `QUERY_NAME` asc";
	$query = new query($qy_queries, $wpdb, $wpbi_sql['tname']['vars']);
	$total_rows = $wpdb->get_results($query->count_qy_results(),'ARRAY_N');
	$total_rows = intval($total_rows[0][0]);
	
	//Page navigation
    $pagination = new pagination();
    $pagination->set_pg_interval($wpbi_settings['parameter']['page-interval']);
    $pagination->set_pg_parameter('pg');
    $pagination->set_current_page(isset( $_GET[$pagination->pg_parameter] ) ? abs( (int) $_GET[$pagination->pg_parameter] ) : 1);
    $pagination->set_rows($total_rows);
    $pagination->set_css_class('widefat post fixed');
    $pagination->set_css_style('widefat-pagination.css');
    $pagination->set_pagination_tpl_path($wpbi_url['tpl']);
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
	$qy_queries_rows = $wpdb->get_results($query->limit_qy_to($pagination->item_start-1, $pagination->pg_interval),'ARRAY_N');
	
	//Output table
	$column_headers = array($wpbi_dialog['header']['queries']['name'],$wpbi_dialog['header']['queries']['database'],$wpbi_dialog['header']['queries']['statement']);
	$single_actions = array ( 	"edit"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['edit'],
	                                   				"page" 		=> $wpbi_url['slug']['queries'],
	                                   				"action" 	=> $wpbi_settings['value']['edit'],
													"parameter"	=> $wpbi_settings['parameter']['qy_id']
	                                    			),
								"copy"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['copy'],
	                                   				"page" 		=> $wpbi_url['slug']['queries'],
	                                   				"action" 	=> $wpbi_settings['value']['copy'],
													"parameter"	=> $wpbi_settings['parameter']['qy_id']
	                                    			),
								"test"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['test'],
	                                   				"page" 		=> $wpbi_url['slug']['queries'],
	                                   				"action" 	=> $wpbi_settings['value']['test'],
													"parameter"	=> $wpbi_settings['parameter']['qy_id']
	                                    			),
								"drop"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['drop'],
	                                   				"page" 		=> $wpbi_url['slug']['queries'],
	                                   				"action" 	=> $wpbi_settings['value']['drop'],
													"parameter"	=> $wpbi_settings['parameter']['qy_id']
	                                    			)
	               			);
	$global_actions = array ( 	"drop"  => array ( 	"label" 	=> $wpbi_dialog['button']['label']['drop'],
	                                   				"value" 	=> $wpbi_settings['value']['drop']
	                                    			)
	               			);
	$table_form = new table_form();
	$table_form->set_css_class('widefat post fixed');
	$table_form->set_rows($qy_queries_rows);
	$table_form->set_cols($column_headers);
	$table_form->has_header(true);
	$table_form->has_footer(true);
	$table_form->encode_html(true);
	$table_form->set_single_actions($single_actions);
	$table_form->set_global_actions($global_actions);
	$table_form->set_gobal_checkbox_id('post_all');
	$table_form->set_form_action('');
	$table_form->set_form_id('manage_queries');
	$table_form->set_form_method('post');
	
	echo $table_form->get_html();
	
} // END Condition of user testing new query

//output page footer
$template_site->pparse('footer');

} //End condition of no test
	
?>