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
	'variables-new' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['variables-new'],
	'variables-edit' => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['variables-edit']
));
?>

<?php
/***********************/
/***   ADD ACTION    ***/
/***********************/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['add']){
	$vo_vars = new vo_vars(NULL, $_POST[$wpbi_settings['parameter']['var_name']], $_POST[$wpbi_settings['parameter']['var_value']]);
	$dao_vars = new dao_vars($wpdb, $wpbi_sql['tname']['vars']);
	$dao_vars->add($vo_vars);
}
?>

<?php
/***********************/
/***  DROP ACTION    ***/
/***********************/

/*** GLOBAL ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop']){
	//Get list of variables to be deleted
	$selected_vars = $_POST['post'];
	for($conn_idx=0; $conn_idx<sizeof($selected_vars); $conn_idx++){
		$vo_vars = new vo_vars($selected_vars[$conn_idx], NULL, NULL);
		$dao_vars = new dao_vars($wpdb, $wpbi_sql['tname']['vars']);
		$dao_vars->del($vo_vars);
	}
}

/*** SINGLE ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop'] && isset($_GET[$wpbi_settings['parameter']['var_id']])){
	$selected_var = $_GET[$wpbi_settings['parameter']['var_id']];
	$vo_vars = new vo_vars($selected_var, NULL, NULL);
	$dao_vars = new dao_vars($wpdb, $wpbi_sql['tname']['vars']);
	$dao_vars->del($vo_vars);
}

?>


<?php
/***********************/
/***   EDIT ACTION   ***/
/***********************/

/**** Edit vars form ***/
if(($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_GET[$wpbi_settings['parameter']['var_id']]) )   ){
	//Get selected var
	$var_id = isset($_GET[$wpbi_settings['parameter']['var_id']]) ? $_GET[$wpbi_settings['parameter']['var_id']] : $_POST[$wpbi_settings['parameter']['var_id']];
	$dao_vars = new dao_vars($wpdb, $wpbi_sql['tname']['vars']);
	$tgt_var = new vo_vars($var_id, NULL, NULL);
	$vo_vars = $dao_vars->select($tgt_var);
	$vo_vars = $vo_vars[0];

	//Prepare output
	$template_site->assign_vars(array(
	/* Header */
	'PG_TITLE' 			=> $wpbi_dialog['page']['variables']['title'],
	'PG_DESCRIPTION' 	=> $wpbi_dialog['action']['variables']['edit'],
	
	/* New var form */
	'VAR_EDIT_NAME' 		=> $wpbi_dialog['field']['variables']['name'],
	'VAR_EDIT_VALUE' 		=> $wpbi_dialog['field']['variables']['value'],
	'P_VAR_ID' 				=> $wpbi_settings['parameter']['var_id'],
	'V_VAR_ID' 				=> $var_id,
	'P_VAR_NAME' 			=> $wpbi_settings['parameter']['var_name'],
	'V_VAR_NAME' 			=> isset($_POST[$wpbi_settings['parameter']['var_name']]) ? $_POST[$wpbi_settings['parameter']['var_name']]: $vo_vars->var_name,
	'P_VAR_VALUE' 			=> $wpbi_settings['parameter']['var_value'],
	'V_VAR_VALUE' 			=> isset($_POST[$wpbi_settings['parameter']['var_value']]) ? $_POST[$wpbi_settings['parameter']['var_value']]: $vo_vars->var_value,
	'P_VAR_ACTION' 		=> $wpbi_settings['parameter']['action'],
	'V_EDIT_ACTION' 		=> $wpbi_settings['value']['edit'],
	'LBL_BTN_EDIT' 		=> $wpbi_dialog['label']['button']['edit'],
	'VAR_EDIT_FORM_ACTION'=> substr((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)),  0, strpos((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)), '&'))
	)
	);
	
	//output page header and database form
	$template_site->pparse('header');
	$template_site->pparse('variables-edit');
}

/**** Edit variable: save modifications ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_POST[$wpbi_settings['parameter']['var_id']]) ){

	$selected_var = $_POST[$wpbi_settings['parameter']['var_id']];
	$old_var = new vo_vars($selected_var, NULL, NULL);
	$new_var = new vo_vars($selected_var, $_POST[$wpbi_settings['parameter']['var_name']], $_POST[$wpbi_settings['parameter']['var_value']]);
	$dao_vars = new dao_vars($wpdb, $wpbi_sql['tname']['vars']);
	$dao_vars->edit($old_var, $new_var);

}


?>

<?php
/***********************/
/***     DEFAULT     ***/
/***********************/

if($_GET[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit']) {
	
	//Prepare output
	$template_site->assign_vars(array(
	/* Header */
	'PG_TITLE' 			=> $wpbi_dialog['page']['variables']['title'],
	'PG_DESCRIPTION' 	=> $wpbi_dialog['page']['variables']['description'],
	
	/* New query form */
	'VAR_NEW_NAME' 		=> $wpbi_dialog['field']['variables']['name'],
	'VAR_NEW_VALUE' 		=> $wpbi_dialog['field']['variables']['value'],
	'P_VAR_NAME' 			=> $wpbi_settings['parameter']['var_name'],
	'V_VAR_NAME' 			=> $_POST[$wpbi_settings['parameter']['var_name']],
	'P_VAR_VALUE' 			=> $wpbi_settings['parameter']['var_value'],
	'V_VAR_VALUE' 			=> $_POST[$wpbi_settings['parameter']['var_value']],
	'P_VAR_ACTION' 		=> $wpbi_settings['parameter']['action'],
	'V_ADD_ACTION' 		=> $wpbi_settings['value']['add'],
	'V_TEST_ACTION' 	=> $wpbi_settings['value']['test'],
	'LBL_BTN_ADD' 		=> $wpbi_dialog['label']['button']['add'],
	)
	);
	
	//output page header and query form
	$template_site->pparse('header');
	$template_site->pparse('variables-new');
	
	//Get saved variables
	$qy_variables = "
		SELECT * FROM ".$wpbi_sql['tname']['vars']." order by VAR_NAME asc";
	$query = new query($qy_variables, $wpdb, $wpbi_sql['tname']['vars']);
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
	$qy_variables_rows = $wpdb->get_results($query->limit_qy_to($pagination->item_start-1, $pagination->pg_interval),'ARRAY_N');
	
	//Output table
	$column_headers = array($wpbi_dialog['header']['variables']['name'],$wpbi_dialog['header']['variables']['value']);
	$single_actions = array ( 	"edit"  => array ( 	"label" 	=> "Edit",
	                                   				"page" 		=> $wpbi_url['slug']['variables'],
	                                   				"action" 	=> $wpbi_settings['value']['edit'],
													"parameter"	=> $wpbi_settings['parameter']['var_id']
	                                    			),
								"drop"  => array ( 	"label" 	=> "Drop",
	                                   				"page" 		=> $wpbi_url['slug']['variables'],
	                                   				"action" 	=> $wpbi_settings['value']['drop'],
													"parameter"	=> $wpbi_settings['parameter']['var_id']
	                                    			)
	               			);
	$global_actions = array ( 	"drop"  => array ( 	"label" 	=> "Drop",
	                                   				"value" 	=> $wpbi_settings['value']['drop']
	                                    			)
	               			);
	$table_form = new table_form();
	$table_form->set_css_class('widefat post fixed');
	$table_form->set_rows($qy_variables_rows);
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