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
	'header' 		=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['header'],
	'footer' 		=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['footer'],
	'css' 		=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['css'],
	'tables-new-1' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['tables-new-1'],
	'tables-new-2' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['tables-new-2'],
	'tables-edit-1' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['tables-edit-1'],
	'tables-edit-2' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['tables-edit-2']
	)
);
?>

<?php
/***********************/
/***   ADD ACTION    ***/
/***********************/

if($_POST[$wpbi_settings['parameter']['action']] == 'add'){
	
	//Insert table metadata
	$vo_table = new vo_table(	NULL, 
								$_POST[$wpbi_settings['parameter']['qy_id']],
								$_POST[$wpbi_settings['parameter']['tb-name']],
								$_POST[$wpbi_settings['parameter']['tb-title']],
								is_numeric($_POST[$wpbi_settings['parameter']['tb-row-pg']]) ? abs(intval($_POST[$wpbi_settings['parameter']['tb-row-pg']])) : $wpbi_settings['parameter']['page-interval'],
								$_POST[$wpbi_settings['parameter']['tb-style']],
								isset($_POST[$wpbi_settings['parameter']['tb-header']]) ? 1 : 0,
								isset($_POST[$wpbi_settings['parameter']['tb-footer']]) ? 1 : 0,
								md5(date('YmdHis').rand(100)), 
								isset($_POST[$wpbi_settings['parameter']['tb-html-values']]) ? 1 : 0
							);
	$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
	$dao_table->add($vo_table);
	$lastid = $wpdb->insert_id;
	
	//insert columns metadata
	for($col_idx = 0; $col_idx<sizeof($_POST[$wpbi_settings['parameter']['tb-tx-column-tf']]); $col_idx++){
		$vo_tb_cols = new vo_tb_cols(	NULL, 
									$lastid, 
									$_POST[$wpbi_settings['parameter']['tb-tx-column-tf']][$col_idx],
									in_array($col_idx, $_POST[$wpbi_settings['parameter']['tb-cb-column-tf']]) ? 1 : 0
								);
		$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
		$dao_tb_cols->add($vo_tb_cols);
	}
}

?>

<?php
/***********************/
/***  DROP ACTION    ***/
/***********************/

/*** GLOBAL ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop']){
	//Get list of tables to be deleted
	$selected_tables = $_POST['post'];
	for($conn_idx=0; $conn_idx<sizeof($selected_tables); $conn_idx++){
		//Drop cols metadata
		$vo_tb_cols = new vo_tb_cols(NULL, $selected_tables[$conn_idx], NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
		$dao_tb_cols->del($vo_tb_cols);
		//Drop tables metadata
		$vo_table= new vo_table($selected_tables[$conn_idx], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
		$dao_table->del($vo_table);
	}
}

/*** SINGLE ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop'] && isset($_GET[$wpbi_settings['parameter']['tb-id']])){
	//Drop cols metadata
	$selected_tables = $_GET[$wpbi_settings['parameter']['tb-id']];
	$vo_tb_cols = new vo_tb_cols(NULL, $selected_tables, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
	$dao_tb_cols->del($vo_tb_cols);
	//Drop table metadata
	$vo_table = new vo_table($selected_tables, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
	$dao_table->del($vo_table);
}

?>

<?php
/***********************/
/***  COPY ACTION    ***/
/***********************/

/*** SINGLE ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['copy'] && isset($_GET[$wpbi_settings['parameter']['tb-id']])){
	//Copy table metadata
	$selected_tables = $_GET[$wpbi_settings['parameter']['tb-id']];
	$vo_table = new vo_table(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);						
	$vo_table->set_id($selected_tables); 
	$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
	$vo_table = $dao_table->select($vo_table);
	$vo_table = $vo_table[0];
	$vo_table->set_name($wpbi_dialog['item']['name']['copy'].$vo_table->name);
	$vo_table->set_table_key(md5(date('YmdHis').rand(100)));
	$dao_table->add($vo_table);
	$lastid = $wpdb->insert_id;
	//Copy table metadata
	$vo_tb_cols = new vo_tb_cols(NULL, NULL, NULL, NULL);
	$vo_tb_cols->set_tb_id($selected_tables);
	$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
	$vo_tb_cols = $dao_tb_cols->select($vo_tb_cols);
	foreach($vo_tb_cols as $vo_tb_col) {
		$vo_tb_col->set_tb_id($lastid);
		$dao_tb_cols->add($vo_tb_col);
	}
}

?>

<?php
/***********************/
/***   TEST ACTION   ***/
/***********************/

/**** Test new table ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['test'] || $_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit-test']){
	$_POST[$wpbi_settings['parameter']['tb-row-pg']] = is_numeric($_POST[$wpbi_settings['parameter']['tb-row-pg']]) ?
															abs(intval($_POST[$wpbi_settings['parameter']['tb-row-pg']])) :
															$wpbi_settings['parameter']['page-interval'];
	$test_output = ''; //Store the test output 

	//Get selected query
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$tgt_query = new vo_query($_POST[$wpbi_settings['parameter']['qy_id']], NULL, NULL, NULL, NULL);
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
		//Add page navigation if requested
		if( isset($_POST[$wpbi_settings['parameter']['tb-row-pg']]) && is_numeric($_POST[$wpbi_settings['parameter']['tb-row-pg']]) && intval($_POST[$wpbi_settings['parameter']['tb-row-pg']]) != 0 ) {
			//Page navigation
			$pagination = new pagination();
			$pagination->set_pagination_tpl_path($wpbi_url['tpl']);
			$pagination->set_pg_interval(abs(intval($_POST[$wpbi_settings['parameter']['tb-row-pg']])));
			$pagination->set_pg_parameter('paged');
			$pagination->set_current_page(isset( $_GET[$pagination->pg_parameter] ) ? abs( (int) $_GET[$pagination->pg_parameter] ) : 1);
			$pagination->set_rows($total_rows);
			$pagination->set_strip_pagination_links(true);
			//$pagination->set_css_class('widefat post fixed');
			$pagination->set_css_style(basename($_POST[$wpbi_settings['parameter']['tb-style']],'.css'));
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
			$pagination_html = $pagination->get_html();
			//END page navigation
	
			//Execute query limitng the resultset
			$my_test_rows = $my_test_db->get_results($query->limit_qy_to($pagination->item_start-1, $pagination->pg_interval),'ARRAY_N');
		}
		else {
			$my_test_rows = $my_test_db->get_results($vo_query->statement,'ARRAY_N');
		}
		//get columns
		$my_test_cols = $_POST[$wpbi_settings['parameter']['tb-tx-column-tf']];
	
		//Output table
		$table = new table();
		$table->set_table_tpl_path($wpbi_url['tpl']);
		$table->set_table_pagination($pagination_html);
		//$table->set_css_class('widefat post fixed');
		$table->set_css_style(basename($_POST[$wpbi_settings['parameter']['tb-style']],'.css'));
		$table->set_rows($my_test_rows);
		$table->set_cols($my_test_cols);
		$table->set_visible_cols($_POST[$wpbi_settings['parameter']['tb-cb-column-tf']]);
		$table->set_title($_POST[$wpbi_settings['parameter']['tb-title']]);
		$table->has_header(isset($_POST[$wpbi_settings['parameter']['tb-header']]));
		$table->has_footer(isset($_POST[$wpbi_settings['parameter']['tb-footer']]));
		$table->encode_html(!isset($_POST[$wpbi_settings['parameter']['tb-html-values']]));
		$test_output = $test_output.$table->get_html();
			
	}
	
} //End test new table


/**** Test saved table ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['test'] && isset($_GET[$wpbi_settings['parameter']['tb-id']])){
	
	$test_output = ''; //Store the test output 
	
	//Get cols metadata
	$selected_tables = $_GET[$wpbi_settings['parameter']['tb-id']];
	$vo_tb_cols = new vo_tb_cols(NULL, $selected_tables, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
	$vo_tb_cols = $dao_tb_cols->select($vo_tb_cols);

	//Get table metadata
	$vo_table = new vo_table($selected_tables, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
	$vo_table = $dao_table->select($vo_table);
	$vo_table = $vo_table[0];

	//Get selected query
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$tgt_query = new vo_query($vo_table->query_id, NULL, NULL, NULL, NULL);
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
		//Add page navigation if requested
		if( $vo_table->rows_per_pg > 0 ) { 
			//Page navigation
			$pagination = new pagination();
			$pagination->set_pagination_tpl_path($wpbi_url['tpl']);
			$pagination->set_pg_interval($vo_table->rows_per_pg);
			$pagination->set_pg_parameter('paged');
			$pagination->set_current_page(isset( $_GET[$pagination->pg_parameter] ) ? abs( (int) $_GET[$pagination->pg_parameter] ) : 1);
			$pagination->set_rows($total_rows);
			//$pagination->set_css_class('widefat post fixed');
			$pagination->set_css_style(basename($vo_table->style_id,'.css'));
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
			$pagination_html = $pagination->get_html();
			//END page navigation
	
			//Execute query limitng the resultset
			$my_test_rows = $my_test_db->get_results($query->limit_qy_to($pagination->item_start-1, $pagination->pg_interval),'ARRAY_N');
		}
		else {
			$my_test_rows = $my_test_db->get_results($vo_query->statement,'ARRAY_N');
		}
		//get columns		
		$my_test_cols = array();
		$my_test_cols_visible = array();
		$col_idx=0;
		foreach($vo_tb_cols as $vo_tb_col){
			array_push($my_test_cols, $vo_tb_col->col_label);
			if($vo_tb_col->is_visible){
				array_push($my_test_cols_visible, $col_idx);
			}
			$col_idx++;
		}

		//Output table
		$table = new table();
		$table->set_table_tpl_path($wpbi_url['tpl']);
		$table->set_table_pagination($pagination_html);
		//$table->set_css_class('widefat post fixed');
		$table->set_css_style(basename($vo_table->style_id,'.css'));
		$table->set_rows($my_test_rows);
		$table->set_cols($my_test_cols);
		$table->set_visible_cols($my_test_cols_visible);
		$table->set_title($vo_table->title);
		$table->has_header($vo_table->has_header);
		$table->has_footer($vo_table->has_footer);
		$table->encode_html(!($vo_table->encode_html));
		$test_output = $test_output.$table->get_html();
	
			
	}
	
	//Prepare output
	$template_site->assign_vars(array(
	/*Style*/
	'TPL_CSS'				=> $wpbi_url['styles']['url'].(isset($table->css_style) ?
								$table->css_style : 
								$_POST[$wpbi_settings['parameter']['tb-style']]).'.css',
	
	/* Header */
	'PG_TITLE' 			=> $wpbi_dialog['page']['tables']['title'],
	'PG_DESCRIPTION' 	=> sprintf($wpbi_dialog['table']['saved']['test'], $vo_table->name, htmlentities($query->stmt))
	));
	
	$template_site->pparse('css');
	$template_site->pparse('header');
	echo $test_output;
	$template_site->pparse('footer');
	
} //End test saved table


?>

<?php
/***********************/
/***   EDIT ACTION   ***/
/***********************/

/**** Edit query form ***/
if(($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_GET[$wpbi_settings['parameter']['tb-id']]) ) || $_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit-test']){

	//Get cols metadata
	$selected_tables = isset($_GET[$wpbi_settings['parameter']['tb-id']]) ? $_GET[$wpbi_settings['parameter']['tb-id']] : $_POST[$wpbi_settings['parameter']['tb-id']];
	$vo_tb_cols = new vo_tb_cols(NULL, $selected_tables, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
	$vo_tb_cols = $dao_tb_cols->select($vo_tb_cols);
	
	//get column info		
	$my_test_cols_labels = array();
	$my_test_cols_visible = array();
	$col_idx=0;
	foreach($vo_tb_cols as $vo_tb_col){
		array_push($my_test_cols_labels, $vo_tb_col->col_label);
		if($vo_tb_col->is_visible){
			array_push($my_test_cols_visible, $col_idx);
		}
		$col_idx++;
	}

	//Get table metadata
	$vo_table = new vo_table($selected_tables, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
	$vo_table = $dao_table->select($vo_table);
	$vo_table = $vo_table[0];

	//Get selected query
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$tgt_query = new vo_query($vo_table->query_id, NULL, NULL, NULL, NULL);
	$vo_query = $dao_query->select($tgt_query);
	$vo_query = $vo_query[0];
	$current_qy = $vo_query;
	
	//Select associated db
	$dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
	$tgt_database = new vo_database($vo_query->db_id, NULL, NULL, NULL, NULL);
	$vo_database = $dao_database->select($tgt_database);
	$vo_database = $vo_database[0];
	
	//create new wpdb object
	$my_test_db = new wpdb($vo_database->user,$vo_database->pass,$vo_database->name,$vo_database->host);
	$query = new query($vo_query->statement, $wpdb, $wpbi_sql['tname']['vars']);
	
	//Execute query limitng the resultset
	$my_test_rows = $my_test_db->get_results($query->limit_qy_to(0, 1),'ARRAY_N');
	$my_test_cols = $my_test_db->get_col_info('name');

	//build html for columns
	$col_idx = 0;
	$columns_html = '';
	$checked = '';
	foreach($my_test_cols as $my_test_col){
		if(	isset($_POST[$wpbi_settings['parameter']['tb-cb-column-tf']])){
				if(in_array($col_idx, $_POST[$wpbi_settings['parameter']['tb-cb-column-tf']])){
					$checked = 'checked';				
				}
			}
		else if($vo_tb_cols[$col_idx]->is_visible==1){
					$checked = 'checked';
			}
		else {$checked = '';}
		$column_name = isset($_POST[$wpbi_settings['parameter']['tb-tx-column-tf']]) ? $_POST[$wpbi_settings['parameter']['tb-tx-column-tf']][$col_idx] : $my_test_cols_labels[$col_idx];
		$columns_html = $columns_html.'
			<tr valign="top">
              <td scope="row">'.($my_test_col).'</td>
              <td><input type="checkbox" name="'.$wpbi_settings['parameter']['tb-cb-column-tf'].'[]" value="'.$col_idx.'" '.$checked.' /></td>
              <td><input type="text"  maxlength="64" id="'.$wpbi_settings['parameter']['tb-tx-column-tf'].'" name="'.$wpbi_settings['parameter']['tb-tx-column-tf'].'[]" value="'.$column_name.'" /></td>
            </tr>
		';
		$checked = '';
		$col_idx++;
	}
	
	//Styles
		$styles = new styles();
		$styles->set_rootdir($wpbi_url['styles']['directory']);
		$styles_lst = $styles->get_styles(); 
		$style_options = '';
		for($stl=0; $stl<sizeof($styles_lst);$stl++){
			$checked = ''; 
			if(((!isset($_POST[$wpbi_settings['parameter']['tb-style']]) ?
								$vo_table->style_id : 
								$_POST[$wpbi_settings['parameter']['tb-style']])) == $styles_lst[$stl]){$checked = 'selected';}
			$style_options = $style_options.'<option '.$checked.' value="'.$styles_lst[$stl].'">'.basename($styles_lst[$stl],'.css').'</option>';
		} 
		
	$template_site->assign_vars(array(
	
		/*Style*/
		'TPL_CSS'				=> $wpbi_url['styles']['url'].(!isset($_POST[$wpbi_settings['parameter']['tb-style']]) ?
								$vo_table->css_style : 
								$_POST[$wpbi_settings['parameter']['tb-style']]),
		
		//Header
		'PG_TITLE'			=> $wpbi_dialog['page']['tables']['title'],
		'PG_DESCRIPTION' 	=> sprintf($wpbi_dialog['table']['saved']['edit'], $vo_table->name, htmlentities($current_qy->statement)),
	
		/* New view form 2 */
		'VW_EDIT_STYLE_OPTIONS'	=> $style_options,
		'VW_EDIT_SETTINGS' 		=> $wpbi_dialog['form']['label']['settings'],
		'VW_EDIT_VALUES' 		=> $wpbi_dialog['form']['label']['values'],
		'VW_EDIT_NAME'			=> $wpbi_dialog['form']['label']['table-name'],
		'P_VW_NAME'				=> $wpbi_settings['parameter']['tb-name'],
		'V_VW_NAME' 			=> 	isset($_POST[$wpbi_settings['parameter']['tb-name']]) ?
									$_POST[$wpbi_settings['parameter']['tb-name']] :
									$vo_table->name,
		'VW_EDIT_TITLE' 		=> $wpbi_dialog['form']['label']['table-title'],
		'P_VW_TITLE' 			=> 	$wpbi_settings['parameter']['tb-title'],
		'V_VW_TITLE' 			=> isset($_POST[$wpbi_settings['parameter']['tb-title']]) ?
									$_POST[$wpbi_settings['parameter']['tb-title']] :
									$vo_table->title,
		'VW_EDIT_STYLE' 			=> $wpbi_dialog['form']['label']['table-style'],
		'P_VW_STYLE'			=> $wpbi_settings['parameter']['tb-style'] ,
		'VW_EDIT_HEADER' 		=> $wpbi_dialog['form']['label']['table-header'],
		'P_VW_HEADER' 			=> $wpbi_settings['parameter']['tb-header'],
		'V_VW_HEADER' 			=> isset($_POST[$wpbi_settings['parameter']['tb-header']]),
		'V_VW_HEADER_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['tb-header']]) ||
									($_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] && $vo_table->has_header)
									? 'checked' : '',
		'VW_EDIT_FOOTER' 		=> $wpbi_dialog['form']['label']['table-footer'],
		'P_VW_FOOTER'			=> $wpbi_settings['parameter']['tb-footer'],
		'V_VW_FOOTER'			=> $_POST[$wpbi_settings['parameter']['tb-header']],
		'V_VW_FOOTER_CHECKED'	=> (isset($_POST[$wpbi_settings['parameter']['tb-footer']])) ||
									($_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] && $vo_table->has_footer)
									 ? 'checked' : '',
		'VW_EDIT_HTML_VALUES' 		=> $wpbi_dialog['form']['label']['table-html-values'],
		'P_VW_HTML_VALUES'			=> $wpbi_settings['parameter']['tb-html-values'],
		'V_VW_HTML_VALUES'			=> $_POST[$wpbi_settings['parameter']['tb-html-values']],
		'V_VW_HTML_VALUES_CHECKED'	=> (isset($_POST[$wpbi_settings['parameter']['tb-html-values']])) ||
								($_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] && $vo_table->encode_html)
									 ? 'checked' : '',
		'VW_EDIT_ROWS_PER_PG' 	=> $wpbi_dialog['form']['label']['table-rows-pg']	,
		'P_VW_ROWS_PER_PG' 		=> $wpbi_settings['parameter']['tb-row-pg'],
		'V_VW_ROWS_PER_PG' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['tb-row-pg']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['tb-row-pg']])) :
									$vo_table->rows_per_pg,
		'P_VW_TX_COLUMN_TF' 		=>	$wpbi_settings['parameter']['tb-tx-column-tf'],
		'VW_EDIT_COLUMNS' 		=> $wpbi_dialog['form']['label']['table-col'],
		'VW_EDIT_COL_VISIBLE' 	=> $wpbi_dialog['form']['label']['table-col-visible'],
		'VW_EDIT_COL_LABEL' 		=> $wpbi_dialog['form']['label']['table-col-label'],
        'VW_EDIT_COL_ISTIME' 		=> $wpbi_dialog['form']['label']['table-col-istime'],
		'LBL_BTN_ADD' 			=> $wpbi_dialog['button']['label']['save'],
		'LBL_BTN_TEST' 			=> $wpbi_dialog['button']['label']['test'],
		'P_VW_QY' 				=> $wpbi_settings['parameter']['qy_id'],
		'V_VW_QY' 				=> $vo_table->query_id,
		'P_VW_ID' 				=> $wpbi_settings['parameter']['tb-id'],
		'V_VW_ID' 				=> $vo_table->id,
		'P_VW_ACTION' 			=> $wpbi_settings['parameter']['action'],
		'V_EDIT_ACTION' 			=> $wpbi_settings['value']['edit'],
		'V_TEST_ACTION' 		=> $wpbi_settings['value']['edit-test'],
		'VW_TEST_RESULT'		=> $test_output,
		'VW_EDIT_STYLE_DEFAULT_OPT' => $wpbi_dialog['form']['option']['table-style-default'],
		'VW_EDIT_FORM_ACTION'=> substr((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)),  0, strpos((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)), '&')),
		'VW_EDIT_COLUMNS_OPTIONS'=> $columns_html
	
		));

    wp_enqueue_script('datatables-jquery', $wpbi_url['datatables']['jquerymin'] );
	
	//Parse tpl
	$template_site->pparse('css');
	$template_site->pparse('header');
	$template_site->pparse('tables-edit-2');

	
}

/**** Edit table: save modifications ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_POST[$wpbi_settings['parameter']['tb-id']])){

	//Insert table metadata
	$vo_new_table = new vo_table(	NULL, 
								$_POST[$wpbi_settings['parameter']['qy_id']],
								$_POST[$wpbi_settings['parameter']['tb-name']],
								$_POST[$wpbi_settings['parameter']['tb-title']],
								is_numeric($_POST[$wpbi_settings['parameter']['tb-row-pg']]) ? abs(intval($_POST[$wpbi_settings['parameter']['tb-row-pg']])) : $wpbi_settings['parameter']['page-interval'],
								$_POST[$wpbi_settings['parameter']['tb-style']],
								isset($_POST[$wpbi_settings['parameter']['tb-header']]) ? 1 : 0,
								isset($_POST[$wpbi_settings['parameter']['tb-footer']]) ? 1 : 0,
								NULL, 
								isset($_POST[$wpbi_settings['parameter']['tb-html-values']]) ? 1 : 0
							);
	$vo_old_table = new vo_table($_POST[$wpbi_settings['parameter']['tb-id']], NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
	$dao_table->edit($vo_old_table, $vo_new_table);
	
	//Drop cols metadata
	$selected_tables = $_POST[$wpbi_settings['parameter']['tb-id']];
	$vo_tb_cols = new vo_tb_cols(NULL, $selected_tables, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
	$dao_tb_cols->del($vo_tb_cols);
	
	//insert columns metadata
	for($col_idx = 0; $col_idx<sizeof($_POST[$wpbi_settings['parameter']['tb-tx-column-tf']]); $col_idx++){
		$vo_tb_cols = new vo_tb_cols(	NULL, 
									$selected_tables, 
									$_POST[$wpbi_settings['parameter']['tb-tx-column-tf']][$col_idx],
									in_array($col_idx, $_POST[$wpbi_settings['parameter']['tb-cb-column-tf']]) ? 1 : 0
								);
		$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
		$dao_tb_cols->add($vo_tb_cols);
	}

}

?>

<?php
/***********************/
/***     DEFAULT     ***/
/***********************/

/**** Build form to create table and display the created tables ***/
if(	$_GET[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['test'] &&
	$_GET[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit'] &&
	$_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] &&
	$_GET[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test']) {
	
	//Queries select options
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$vo_query = $dao_query->select(NULL);
	if(sizeof($vo_query)==0){
		echo'
		<p>'.$wpbi_dialog['msg']['warning']['no-queries'].'</p>
		';
	} 
	else {
		$select_options = '';
		for ($index=0;$index<sizeof($vo_query);$index++){
			$selected = '';
			if(((int)$_POST[$wpbi_settings['parameter']['qy_id']])==($vo_query[$index]->id)){$selected = 'selected';}
			$select_options = $select_options.'			
			<option '.$selected.' value="'.$vo_query[$index]->id.'">'.$vo_query[$index]->name.'</option>
			';
		}	
	}
	
	$template_site->assign_vars(array(
	
		//Header
		'PG_TITLE'			=> $wpbi_dialog['page']['tables']['title'],
		'PG_DESCRIPTION' 	=> $wpbi_dialog['page']['tables']['description'],
	
		/* New view form 1 */
		'VW_NEW_QUERY' 		=> $wpbi_dialog['field']['tables']['query'],
		'VW_NEW_QY_OPTIONS'	=> $select_options,
		'VW_NEW_FORM_ACTION'=> substr((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)),  0, strpos((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)), '&')),
		'P_VW_ACTION' 		=> $wpbi_settings['parameter']['action'],
		'V_SET_ACTION' 		=> $wpbi_settings['value']['set'],
		'P_VW_QY' 			=> $wpbi_settings['parameter']['qy_id'],
		'LBL_BTN_SET' 		=> $wpbi_dialog['button']['label']['set']
	
	)
	);

/***********************/
/***   SET ACTION    ***/
/***********************/

	if(($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['set'] || $_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['test']) && isset($_POST[$wpbi_settings['parameter']['qy_id']])){
	
		//Get selected query
		$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
		$tgt_query = new vo_query($_POST[$wpbi_settings['parameter']['qy_id']], NULL, NULL, NULL, NULL);
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
	
		//Execute query limitng the resultset
		$my_test_rows = $my_test_db->get_results($query->limit_qy_to(0, 1),'ARRAY_N');
		$my_test_cols = $my_test_db->get_col_info('name');
	
		//build html for columns
		$col_idx = 0;
		$columns_html = '';
		$checked = '';
		foreach($my_test_cols as $my_test_col){
			if(!isset($_POST[$wpbi_settings['parameter']['tb-cb-column-tf']]) || in_array($col_idx, $_POST[$wpbi_settings['parameter']['tb-cb-column-tf']])){$checked = 'checked';}
			$column_name = isset($_POST[$wpbi_settings['parameter']['tb-tx-column-tf']]) ? $_POST[$wpbi_settings['parameter']['tb-tx-column-tf']][$col_idx] : $my_test_col;
			$columns_html = $columns_html.'
				<tr valign="top">
	              <td scope="row">'.($my_test_col).'</td>
	              <td><input type="checkbox" name="'.$wpbi_settings['parameter']['tb-cb-column-tf'].'[]" value="'.$col_idx.'" '.$checked.' /></td>
	              <td><input type="text"  maxlength="64" id="'.$wpbi_settings['parameter']['tb-tx-column-tf'].'" name="'.$wpbi_settings['parameter']['tb-tx-column-tf'].'[]" value="'.$column_name.'" /></td>
	            </tr>
			';
			$checked = '';
			$col_idx++;
		}
		
		//Styles
		$styles = new styles();
		$styles->set_rootdir($wpbi_url['styles']['directory']);
		$styles_lst = $styles->get_styles(); 
		$style_options = '';
		for($stl=0; $stl<sizeof($styles_lst);$stl++){
			$checked = ''; 
			if($_POST[$wpbi_settings['parameter']['tb-style']] == $styles_lst[$stl]){$checked = 'selected';}
			$style_options = $style_options.'<option '.$checked.' value="'.$styles_lst[$stl].'">'.basename($styles_lst[$stl],'.css').'</option>';
		} 		
		
		$template_site->assign_vars(array(
	
		/* New view form 2 */
		'TPL_CSS'				=> $wpbi_url['styles']['url'].$_POST[$wpbi_settings['parameter']['tb-style']],
		'VW_NEW_STYLE_OPTIONS'	=> $style_options,
		'VW_NEW_SETTINGS' 		=> $wpbi_dialog['form']['label']['settings'],
		'VW_NEW_VALUES' 		=> $wpbi_dialog['form']['label']['values'],
		'VW_NEW_NAME'			=> $wpbi_dialog['form']['label']['table-name'],
		'P_VW_NAME'				=> $wpbi_settings['parameter']['tb-name'],
		'V_VW_NAME' 			=> $_POST[$wpbi_settings['parameter']['tb-name']],
		'VW_NEW_TITLE' 			=> $wpbi_dialog['form']['label']['table-title'],
		'P_VW_TITLE' 			=> $wpbi_settings['parameter']['tb-title'],
		'V_VW_TITLE' 			=> $_POST[$wpbi_settings['parameter']['tb-title']],
		'VW_NEW_STYLE' 			=> $wpbi_dialog['form']['label']['table-style'],
		'P_VW_STYLE'			=> $wpbi_settings['parameter']['tb-style'] ,
		'VW_NEW_HEADER' 		=> $wpbi_dialog['form']['label']['table-header'],
		'P_VW_HEADER' 			=> $wpbi_settings['parameter']['tb-header'],
		'V_VW_HEADER' 			=> $_POST[$wpbi_settings['parameter']['tb-header']],
		'V_VW_HEADER_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['tb-header']]) ? 'checked' : '',
		'VW_NEW_FOOTER' 		=> $wpbi_dialog['form']['label']['table-footer'],
		'P_VW_FOOTER'			=> $wpbi_settings['parameter']['tb-footer'],
		'V_VW_FOOTER'			=> $_POST[$wpbi_settings['parameter']['tb-footer']],
		'V_VW_FOOTER_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['tb-footer']]) ? 'checked' : '',
		'VW_NEW_HTML_VALUES' 		=> $wpbi_dialog['form']['label']['table-html-values'],
		'P_VW_HTML_VALUES'			=> $wpbi_settings['parameter']['tb-html-values'],
		'V_VW_HTML_VALUES'			=> $_POST[$wpbi_settings['parameter']['tb-html-values']],
		'V_VW_HTML_VALUES_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['tb-html-values']]) ? 'checked' : '',
		'VW_NEW_ROWS_PER_PG' 	=> $wpbi_dialog['form']['label']['table-rows-pg']	,
		'P_VW_ROWS_PER_PG' 		=> $wpbi_settings['parameter']['tb-row-pg'],
		'V_VW_ROWS_PER_PG' 		=> is_numeric($_POST[$wpbi_settings['parameter']['tb-row-pg']]) ? abs(intval($_POST[$wpbi_settings['parameter']['tb-row-pg']])) : $wpbi_settings['parameter']['page-interval'],
		'P_VW_TX_COLUMN_TF' 		=>	$wpbi_settings['parameter']['tb-tx-column-tf'],
		'VW_NEW_COLUMNS' 		=> $wpbi_dialog['form']['label']['table-col'],
		'VW_NEW_COL_VISIBLE' 	=> $wpbi_dialog['form']['label']['table-col-visible'],
		'VW_NEW_COL_LABEL' 		=> $wpbi_dialog['form']['label']['table-col-label'],
        'VW_EDIT_COL_ISTIME' 	=> $wpbi_dialog['form']['label']['table-col-istime'],
		'LBL_BTN_ADD' 			=> $wpbi_dialog['button']['label']['save'],
		'LBL_BTN_TEST' 			=> $wpbi_dialog['button']['label']['test'],
		'P_VW_QY' 				=> $wpbi_settings['parameter']['qy_id'],
		'V_VW_QY' 				=> $_POST[$wpbi_settings['parameter']['qy_id']],
		'P_VW_ACTION' 			=> $wpbi_settings['parameter']['action'],
		'V_ADD_ACTION' 			=> $wpbi_settings['value']['add'],
		'V_TEST_ACTION' 		=> $wpbi_settings['value']['test'],
		'VW_TEST_RESULT'		=> $test_output,
		'VW_NEW_STYLE_DEFAULT_OPT' => $wpbi_dialog['form']['option']['table-style-default'],
		'VW_NEW_COLUMNS_OPTIONS'=> $columns_html
	
		));

        wp_enqueue_script('datatables-jquery', $wpbi_url['datatables']['jquerymin'] );
		
		//Store output
		ob_start();
		$template_site->pparse('tables-new-2');
		$set_output = ob_get_contents();
		ob_end_clean();
	} //End set action
	
	//Parse tpl
	$template_site->pparse('css');
	$template_site->pparse('header');
	$template_site->pparse('tables-new-1');
	echo $set_output;
	
	//To be display only when the user is not testin a new query
	if($_POST[$wpbi_settings['parameter']['action']] != 'test') {
	
		//Get saved queries
		$qy_tables = "
			SELECT `TABLE_ID`, `NAME`, `QUERY_NAME`, `QUERY_STATEMENT` 
			FROM `".$wpbi_sql['tname']['tables']."`, `".$wpbi_sql['tname']['queries']."`
			WHERE `".$wpbi_sql['tname']['tables']."`.`QUERY_ID` = `".$wpbi_sql['tname']['queries']."`.`QUERY_ID`
			ORDER BY NAME ASC";
		$query = new query($qy_tables, $wpdb, $wpbi_sql['tname']['vars']);
		$total_rows = $wpdb->get_results($query->count_qy_results(),'ARRAY_N');
		$total_rows = intval($total_rows[0][0]);
		
		//Page navigation
			$pagination = new pagination();
			$pagination->set_pagination_tpl_path($wpbi_url['tpl']);
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
		$qy_tables_rows = $wpdb->get_results($query->limit_qy_to($pagination->item_start-1, $pagination->pg_interval),'ARRAY_N');
		
		//Output table
		$column_headers = array($wpbi_dialog['header']['tables']['name'],$wpbi_dialog['header']['tables']['query'],$wpbi_dialog['header']['queries']['statement']);
		$single_actions = array ( 	"edit"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['edit'],
		                                   				"page" 		=> $wpbi_url['slug']['tables'],
		                                   				"action" 	=> $wpbi_settings['value']['edit'],
														"parameter"	=> $wpbi_settings['parameter']['tb-id']
		                                    			),
									"copy"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['copy'],
		                                   				"page" 		=> $wpbi_url['slug']['tables'],
		                                   				"action" 	=> $wpbi_settings['value']['copy'],
														"parameter"	=> $wpbi_settings['parameter']['tb-id']
		                                    			),
									"test"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['test'],
		                                   				"page" 		=> $wpbi_url['slug']['tables'],
		                                   				"action" 	=> $wpbi_settings['value']['test'],
														"parameter"	=> $wpbi_settings['parameter']['tb-id']
		                                    			),
									"drop"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['drop'],
		                                   				"page" 		=> $wpbi_url['slug']['tables'],
		                                   				"action" 	=> $wpbi_settings['value']['drop'],
														"parameter"	=> $wpbi_settings['parameter']['tb-id']
		                                    			)
		               			);
		$global_actions = array ( 	"drop"  => array ( 	"label" 	=> $wpbi_dialog['button']['label']['drop'],
		                                   				"value" 	=> $wpbi_settings['value']['drop']
		                                    			)
		               			);
		$table_form = new table_form();
		$table_form->set_css_class('widefat post fixed');
		$table_form->set_rows($qy_tables_rows);
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
		
		echo '<p>'.$table_form->get_html().'</p>';
		
	} // END Condition of user testing new query
	
	
	//Print footer
	$template_site->pparse('footer');

} //End condition to display the new rable form

?>