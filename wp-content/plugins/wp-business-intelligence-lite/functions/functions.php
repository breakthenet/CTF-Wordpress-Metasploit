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

remove_filter('the_content', 'wpautop');
add_filter( 'the_content', 'wpautop' , 9);

//Get html table definition by table key

function get_html_4_table($id){

	global $wpdb, $qy_table_databases, $qy_table_queries, $wpbi_sql, $wpbi_settings, $wpbi_url, $wpbi_dialog, $lng, $language, $template_site;

	$template_site->set_filenames(array(
		'css' 		=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['css']
		)
	);
	
	$table_id = $id;
	
	//id or key
	$search_by_key = false;
	if(!is_numeric($table_id) && strlen($table_id) == 32) {
		$search_by_key = true;
	}
	
	$test_output = ''; //Store the test output 

	//Get table metadata
	$vo_table = new vo_table($table_id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $table_id, NULL);
	$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
	$vo_table = $search_by_key ? $dao_table->select_by_key($vo_table) : $dao_table->select($vo_table);
	$vo_table = $vo_table[0];
	
	//Get cols metadata
	$selected_table = $vo_table->id;
	$vo_tb_cols = new vo_tb_cols(NULL, $selected_table, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	$dao_tb_cols = new dao_tb_cols($wpdb, $wpbi_sql['tname']['cols']);
	$vo_tb_cols = $dao_tb_cols->select($vo_tb_cols);
	
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
			$pagination->set_pg_parameter($table_id.'_paged');
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
			$my_test_rows = $my_test_db->get_results($query->stmt,'ARRAY_N');
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
	'TPL_CSS'				=> $wpbi_url['styles']['url'].$table->css_style.'.css'
	));
	
	ob_start();
	$template_site->pparse('css');
	$css_output = ob_get_contents();
	ob_end_clean();
	
	return $css_output.$test_output;
	
}

/***************************************************************************/
//Get html chart definition by chart key

function get_html_4_chart($id){

	global $wpdb, $qy_table_databases, $qy_table_queries, $wpbi_sql, $wpbi_settings, $wpbi_url, $wpbi_dialog, $lng, $language, $template_site;


	$template_site->set_filenames(array(
		'chart' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['nvd3chart']
		)
	);
	
	$chart_id = $id;
	
	//id or key
	$search_by_key = false;
	if(!is_numeric($chart_id) && strlen($chart_id) == 32) {
		$search_by_key = true;
	}

	$test_output = ''; //Store the test output 
	
	//Get chart metadata
	$selected_charts = $chart_id;
	$vo_chart = new vo_chart(NULL);		
	$vo_chart->set_chart_id($selected_charts);				
	$vo_chart->set_chart_key($selected_charts);
	$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
	$vo_chart = ($search_by_key) ? $dao_chart->select_by_key($vo_chart) : $dao_chart->select($vo_chart);
	$vo_chart = $vo_chart[0];
	
	//Get cols metadata
	$vo_ch_cols = new vo_ch_cols();
	$vo_ch_cols->set_ch_id($vo_chart->chart_id);
	$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
	$vo_ch_cols = $dao_ch_cols->select($vo_ch_cols);
	
	//Get selected query
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$tgt_query = new vo_query($vo_chart->query_id, NULL, NULL, NULL, NULL);
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
	
	//get query resultset
	$my_test_rows = $my_test_db->get_results($query->stmt,'ARRAY_N');
	
	//get columns	
	$x_label_cols = array();
	$color_cols = array();
	$tx_label_cols = array();
	$values_cols = array();
    $istime_cols = array();
    $stacked_label_cols = array();
	$stacked_label_cols_color = array();
	$col_idx=0;
	foreach($vo_ch_cols as $vo_ch_col){
		array_push($tx_label_cols, $vo_ch_col->col_label);
		array_push($color_cols, $vo_ch_col->col_color);
		if($vo_ch_col->is_label){
			array_push($x_label_cols, $col_idx);
		}
		if($vo_ch_col->is_value){
			array_push($values_cols, $col_idx);
			array_push($stacked_label_cols, $vo_ch_col->col_label);
			array_push($stacked_label_cols_color, $vo_ch_col->col_color);
		}
        if($vo_ch_col->is_time){
            array_push($istime_cols, $col_idx);
        }

        $col_idx++;
	}		
		
		//Create chart
		$wpbi_chart = new chart();
		$wpbi_chart	-> set_name($vo_chart->chart_name);
		$wpbi_chart	-> set_tooltip($vo_chart->chart_tooltip);
		$wpbi_chart	-> set_width($vo_chart->chart_width.($vo_chart->chart_width_percent ? '%' : ''));
		$wpbi_chart	-> set_height($vo_chart->chart_height.($vo_chart->chart_height_percent ? '%' : ''));
		$wpbi_chart	-> set_bg_colour($vo_chart->chart_bg_color);
		$wpbi_chart	-> set_title($vo_chart->chart_title);
		$wpbi_chart	-> set_title_color($vo_chart->chart_title_color);
		$wpbi_chart	-> set_title_size($vo_chart->chart_title_size);
		$wpbi_chart	-> set_type($vo_chart->chart_type);
		$wpbi_chart	-> set_x_axis_step_percent($vo_chart->chart_x_grid_lines);
		$wpbi_chart	-> set_y_axis_step_percent($vo_chart->chart_y_grid_lines);

		//Get values, labels, colors
		$label_color = array();
		$stacked_label_color = array();
		$row_idx = 0;
        $label_tmp_x = "";
		foreach($my_test_rows as $my_test_row){
				for($col_idx=0; $col_idx < sizeof($my_test_row); $col_idx++){
					//Colors
					$label_color[$tx_label_cols[$col_idx]] = $color_cols[$col_idx];
					if(in_array($col_idx, $values_cols)){
						$stacked_label_color[$tx_label_cols[$col_idx]] = $color_cols[$col_idx];
					}
				
					if(in_array($col_idx, $values_cols)){ //create different array of values for each selected column
						$current_value = floatval($my_test_row[$col_idx]);
						if(isset($data[$tx_label_cols[$col_idx]])){
							array_push($data[$tx_label_cols[$col_idx]], $current_value);
						} else{
							$data[$tx_label_cols[$col_idx]] = array(); 
							array_push($data[$tx_label_cols[$col_idx]], $current_value);
						}
					}
					
					if(in_array($col_idx, $values_cols)){ //create different array of values for each selected column (for stacked bar chart)
						$current_value = floatval($my_test_row[$col_idx]);
						if(isset($data_stacked[$row_idx])){
							array_push($data_stacked[$row_idx], $current_value);
						} else{
							$data_stacked[$row_idx] = array(); 
							array_push($data_stacked[$row_idx], $current_value);
						}
					}
					
					if(in_array($col_idx, $x_label_cols)){ //Concatenate selected columns 
						$label_tmp_x = 	($label_tmp_x == '') ?
										$my_test_row[$col_idx] : 
										$label_tmp_x.$wpbi_dialog['charts']['x-label']['concat-string'].($my_test_row[$col_idx]);
					}
				}
								
				if($label_tmp_x != NULL){
					$label_x[] = ($label_tmp_x); 
					$label_tmp_x = '';
				}

				$row_idx++;
		}
		
		
		
		//Assign values and labels
		switch($wpbi_chart->type){
            case chart::DONUT:
			case chart::PIE:				if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_x_axis_labels($label_x,
														$vo_chart->chart_x_labels_size, 
														$vo_chart->chart_x_labels_color);
													}
													foreach($data as $key => $value){
													//Overwrite data value for pie chart in order to show labels (via pie_value object)
													if(sizeof($label_x)>0){
														for($idx = 0; $idx < sizeof($value); $idx++){
															$value[$idx] = new pie_value($value[$idx], $label_x[$idx]);
														}
													}
													$wpbi_chart	-> set_tooltip($wpbi_dialog['charts']['pie']['tooltip']);
													$wpbi_chart	-> create_element($key, $value);
													$wpbi_chart	-> elements[$key] -> set_colours($wpbi_settings['pie-chart']['color-set']);
													}
													break;
			case chart::BAR_STACKED:		if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_x_axis_labels($label_x,
														$vo_chart->chart_x_labels_size, 
														$vo_chart->chart_x_labels_color);
													}
													$wpbi_chart-> set_y_axis_labels_color($vo_chart->chart_y_labels_color);
													$wpbi_chart-> set_y_axis_labels_size($vo_chart->chart_y_labels_size);
													foreach($data_stacked as $key => $value){

														$wpbi_chart	-> create_element('BAR_STACKED', $value);
														$wpbi_chart	-> elements['BAR_STACKED'] -> set_colours($stacked_label_color);
													}
													break;
            case chart::STACKED_AREA:
			case chart::LINE_AREA:		if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_x_axis_labels($label_x,
														$vo_chart->chart_x_labels_size, 
														$vo_chart->chart_x_labels_color);
													}
													$wpbi_chart-> set_y_axis_labels_color($vo_chart->chart_y_labels_color);
													$wpbi_chart-> set_y_axis_labels_size($vo_chart->chart_y_labels_size);
													foreach($data as $key => $value){
														$wpbi_chart	-> create_element($key, $value);
														$wpbi_chart	-> elements[$key] -> set_colour($label_color[$key]);
														$wpbi_chart	-> elements[$key] -> set_fill_colour($label_color[$key]);
														$wpbi_chart	-> elements[$key] -> set_fill_alpha( 0.5 );
													}
													break;
			case chart::RADAR:			if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_y_axis_labels($label_x,
														$vo_chart->chart_y_labels_size, 
														$vo_chart->chart_y_labels_color);
													}
													foreach($data as $key => $value){
														$wpbi_chart	-> create_element($key, $value);
														$wpbi_chart	-> elements[$key] -> set_colour($label_color[$key]);
													}
													break;
			case chart::BAR_HORIZONTAL:	if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_y_axis_labels($label_x,
														$vo_chart->chart_y_labels_size, 
														$vo_chart->chart_y_labels_color);
													}
													$wpbi_chart-> set_x_axis_labels_color($vo_chart->chart_x_labels_color);
													$wpbi_chart-> set_x_axis_labels_size($vo_chart->chart_x_labels_size);
													foreach($data as $key => $value){
														$wpbi_chart	-> create_element($key, $value);
														$wpbi_chart	-> elements[$key] -> set_colour($label_color[$key]);
													}
													break;
			default:								if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_x_axis_labels($label_x,
														$vo_chart->chart_x_labels_size, 
														$vo_chart->chart_x_labels_color, sizeof($istime_cols) > 0);
                                                        $wpbi_chart->x_axis_istime = (sizeof($istime_cols) > 0);
													} else {
													$wpbi_chart->set_x_axis_labels_color($vo_chart->chart_x_labels_color);
													$wpbi_chart->set_x_axis_labels_size($vo_chart->chart_x_labels_size);
													}
													$wpbi_chart-> set_y_axis_labels_color($vo_chart->chart_y_labels_color);
													$wpbi_chart-> set_y_axis_labels_size($vo_chart->chart_y_labels_size);
													foreach($data as $key => $value){
														$wpbi_chart	-> create_element($key, $value);
														$wpbi_chart	-> elements[$key] -> set_colour($label_color[$key]);
													}
													break;
		}
		
		//Set legends
		$wpbi_chart	-> set_y_legend($vo_chart->chart_y_legend,$vo_chart->chart_y_legend_size, $vo_chart->chart_y_legend_color);
		$wpbi_chart	-> set_x_legend($vo_chart->chart_x_legend,$vo_chart->chart_x_legend_size, $vo_chart->chart_x_legend_color);
		$wpbi_chart	-> set_x_axis_labels_rotation($vo_chart->chart_x_labels_rotation);
		$wpbi_chart	-> set_y_axis_labels_rotation($vo_chart->chart_y_labels_rotation);
		$wpbi_chart	-> set_y_axis_color($vo_chart->chart_y_color);
		$wpbi_chart	-> set_y_axis_grid_color($vo_chart->chart_y_grid_color);
		$wpbi_chart	-> set_y_axis_thickness($vo_chart->chart_y_thickness);
		$wpbi_chart	-> set_x_axis_color($vo_chart->chart_x_color);
		$wpbi_chart	-> set_x_axis_grid_color($vo_chart->chart_x_grid_color);
		$wpbi_chart	-> set_x_axis_thickness($vo_chart->chart_x_thickness);
        $wpbi_chart	-> set_x_precision($vo_chart->chart_x_axis_precision);
        $wpbi_chart	-> set_y_precision($vo_chart-> chart_y_axis_precision);
        $wpbi_chart	-> set_y_currency($vo_chart-> chart_y_axis_currency);
		
		//Main legend for stacked chart
		if($wpbi_chart->type == chart::BAR_STACKED){
			$stacked_keys = array();
			for($i=0; $i<sizeof($stacked_label_cols_color);$i++){
				array_push($stacked_keys, new bar_stack_key( $stacked_label_cols_color[$i], $stacked_label_cols[$i], 10 ));
			}
			$wpbi_chart	-> elements['BAR_STACKED']->set_keys($stacked_keys);
		}
		
		$wpbi_chart	-> build();
		
		//Import scripts		
		echo '
		<link rel="stylesheet" href="'.$wpbi_url['nvd3']['css'].'" type="text/css" />

		<script type="text/javascript" src="'.$wpbi_url['nvd3']['d3js'].'"></script>
		<script type="text/javascript" src="'.$wpbi_url['nvd3']['nvd3'].'"></script>
		';

		//Set template variables
		$template_site->assign_vars(array(
			//WPBI Chart
			'CH_NEW_CHART_NAME' 	    => $selected_charts,
			'CH_NEW_CHART_WIDTH' 		=> $wpbi_chart->width,
			'CH_NEW_CHART_HEIGHT'	    => $wpbi_chart->height,
			'CH_NEW_CHART_RESIZE'       => 'chart_resize',
			'CH_NEW_CHART_JSON' 		=> $wpbi_chart->get_json_code(),
            'CH_NEW_CHART_NVD3_CODE'    => $wpbi_chart->get_nvd3_chart_code(),
            'CH_NEW_CHART_NVD3_JSLIBS'  => $wpbi_chart->get_nvd3_chart_jslibs(),
            'CH_NEW_CHART_NVD3_DATA'    => $wpbi_chart->get_nvd3_chart_data(),
            'CH_NEW_CHART_NVD3_PLACEHOLDER' => $wpbi_chart->get_nvd3_chart_placeholder()
		)
		);
			
	ob_start();
	$template_site->pparse('chart');
	$chart_output = ob_get_contents();
	ob_end_clean();
	
	return $chart_output;
}
?>