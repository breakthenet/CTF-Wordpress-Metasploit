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
	'header' 		=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['header'],
	'footer' 		=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['footer'],
	'chart' 	    => $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['chart'],
    'nvd3chart' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['nvd3chart'],
	'charts-new-1' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['charts-new-1'],
	'charts-new-2' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['charts-new-2'],
	'charts-edit-1' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['charts-edit-1'],
	'charts-edit-2' 	=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['charts-edit-2']
	)
);
?>

<?php
/***********************/
/***   ADD(SAVE) ACTION    ***/
/***********************/

if($_POST[$wpbi_settings['parameter']['action']] == 'add'){
	
	//Insert chart metadata
	$vo_chart = new vo_chart(NULL);						
	$vo_chart->set_chart_id(NULL); 
	$vo_chart->set_query_id($_POST[$wpbi_settings['parameter']['qy_id']]);
	$vo_chart->set_chart_key(md5(date('YmdHis').rand(100)));
	$vo_chart->set_chart_name($_POST[$wpbi_settings['parameter']['ch-name']]);
	$vo_chart->set_chart_type($_POST[$wpbi_settings['parameter']['ch-type']]);
	$vo_chart->set_chart_title($_POST[$wpbi_settings['parameter']['ch-title']]);
	$vo_chart->set_chart_title_size($_POST[$wpbi_settings['parameter']['ch-title-size']]);
	$vo_chart->set_chart_title_color($_POST[$wpbi_settings['parameter']['ch-title-color']]);
	$vo_chart->set_chart_bg_color($_POST[$wpbi_settings['parameter']['ch-bgcolor']]);
	$vo_chart->set_chart_width($_POST[$wpbi_settings['parameter']['ch-width']]);
	$vo_chart->set_chart_width_percent(isset($_POST[$wpbi_settings['parameter']['ch-width-percent']]) ? 1 : 0);
	$vo_chart->set_chart_height($_POST[$wpbi_settings['parameter']['ch-height']]);
	$vo_chart->set_chart_height_percent(isset($_POST[$wpbi_settings['parameter']['ch-height-percent']]) ? 1 : 0);
    $vo_chart->set_chart_x_precision($_POST[$wpbi_settings['parameter']['ch-x-precision']]);
	$vo_chart->set_chart_x_color($_POST[$wpbi_settings['parameter']['ch-x-axis-color']]);
	$vo_chart->set_chart_x_thickness($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']]);
	$vo_chart->set_chart_x_grid_color($_POST[$wpbi_settings['parameter']['ch-x-grid-color']]);
	$vo_chart->set_chart_x_grid_lines($_POST[$wpbi_settings['parameter']['ch-x-grid-step']]);
	$vo_chart->set_chart_x_labels_color($_POST[$wpbi_settings['parameter']['ch-x-label-color']]);
	$vo_chart->set_chart_x_labels_size($_POST[$wpbi_settings['parameter']['ch-x-label-size']]);
	$vo_chart->set_chart_x_labels_rotation($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']]);
	$vo_chart->set_chart_x_legend($_POST[$wpbi_settings['parameter']['ch-x-legend']]);
	$vo_chart->set_chart_x_legend_color($_POST[$wpbi_settings['parameter']['ch-x-legend-color']]);
	$vo_chart->set_chart_x_legend_size($_POST[$wpbi_settings['parameter']['ch-x-legend-size']]);
    $vo_chart->set_chart_y_precision($_POST[$wpbi_settings['parameter']['ch-y-precision']]);
    $vo_chart->set_chart_y_currency($_POST[$wpbi_settings['parameter']['ch-y-currency']]);
	$vo_chart->set_chart_y_color($_POST[$wpbi_settings['parameter']['ch-y-axis-color']]);
	$vo_chart->set_chart_y_thickness($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']]);
	$vo_chart->set_chart_y_grid_color($_POST[$wpbi_settings['parameter']['ch-y-grid-color']]);
	$vo_chart->set_chart_y_grid_lines($_POST[$wpbi_settings['parameter']['ch-y-grid-step']]);
	$vo_chart->set_chart_y_labels_color($_POST[$wpbi_settings['parameter']['ch-y-label-color']]);
	$vo_chart->set_chart_y_labels_size($_POST[$wpbi_settings['parameter']['ch-y-label-size']]);
	$vo_chart->set_chart_y_labels_rotation($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']]);
	$vo_chart->set_chart_y_legend($_POST[$wpbi_settings['parameter']['ch-y-legend']]);
	$vo_chart->set_chart_y_legend_color($_POST[$wpbi_settings['parameter']['ch-y-legend-color']]);
	$vo_chart->set_chart_y_legend_size($_POST[$wpbi_settings['parameter']['ch-y-legend-size']]);
	
	$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
	$dao_chart->add($vo_chart);
	$lastid = $wpdb->insert_id;
	
	//insert columns metadata
	for($col_idx = 0; $col_idx<sizeof($_POST[$wpbi_settings['parameter']['ch-tx-column-tf']]); $col_idx++){
		$vo_ch_cols = new vo_ch_cols();
		$vo_ch_cols->set_id(NULL);
		$vo_ch_cols->set_ch_id($lastid);
		$vo_ch_cols->set_col_label($_POST[$wpbi_settings['parameter']['ch-tx-column-tf']][$col_idx]);
		$vo_ch_cols->set_col_color($_POST['picker_column'][$col_idx]);
		$vo_ch_cols->set_is_label(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-x-column-cb']]) ? 1 : 0);
		$vo_ch_cols->set_is_value(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-v-column-cb']]) ? 1 : 0);
        $vo_ch_cols->set_is_time(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-istime-column-cb']]) ? 1 : 0);
		
		$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
		$dao_ch_cols->add($vo_ch_cols);
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
	$selected_charts = $_POST['post'];
	for($conn_idx=0; $conn_idx<sizeof($selected_charts); $conn_idx++){
		//Drop cols metadata
		$vo_ch_cols = new vo_ch_cols();
		$vo_ch_cols->set_ch_id($selected_charts[$conn_idx]);
		$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
		$dao_ch_cols->del($vo_ch_cols);
		//Drop tables metadata
		$vo_chart = new vo_chart(NULL);						
		$vo_chart->set_chart_id($selected_charts[$conn_idx]); 
		$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
		$dao_chart->del($vo_chart);
	}
}

/*** SINGLE ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['drop'] && isset($_GET[$wpbi_settings['parameter']['ch-id']])){
	//Drop cols metadata
	$selected_charts = $_GET[$wpbi_settings['parameter']['ch-id']];
	$vo_ch_cols = new vo_ch_cols();
	$vo_ch_cols->set_ch_id($selected_charts);
	$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
	$dao_ch_cols->del($vo_ch_cols);
	//Drop table metadata
	$vo_chart = new vo_chart(NULL);						
	$vo_chart->set_chart_id($selected_charts); 
	$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
	$dao_chart->del($vo_chart);
}

?>

<?php
/***********************/
/***  COPY ACTION    ***/
/***********************/

/*** SINGLE ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['copy'] && isset($_GET[$wpbi_settings['parameter']['ch-id']])){
	//Copy chart metadata
	$selected_charts = $_GET[$wpbi_settings['parameter']['ch-id']];
	$vo_chart = new vo_chart(NULL);						
	$vo_chart->set_chart_id($selected_charts); 
	$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
	$vo_chart = $dao_chart->select($vo_chart);
	$vo_chart = $vo_chart[0];
	$vo_chart->set_chart_name($wpbi_dialog['item']['name']['copy'].$vo_chart->chart_name);
	$vo_chart->set_chart_key(md5(date('YmdHis').rand(100)));
	$dao_chart->add($vo_chart);
	$lastid = $wpdb->insert_id;
	//Copy cols metadata
	$vo_ch_cols = new vo_ch_cols();
	$vo_ch_cols->set_ch_id($selected_charts);
	$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
	$vo_ch_cols = $dao_ch_cols->select($vo_ch_cols);
	foreach($vo_ch_cols as $vo_ch_col) {
		$vo_ch_col->set_ch_id($lastid);
		$dao_ch_cols->add($vo_ch_col);
	}
}

?>

<?php
/***********************/
/***   TEST ACTION   ***/
/***********************/

/**** Test new chart ***/
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
		//get query resultset
		$my_test_rows = $my_test_db->get_results($query->stmt,'ARRAY_N');
		
		//get params
		$x_label_cols = $_POST[$wpbi_settings['parameter']['ch-x-column-cb']];
		$y_label_cols = $_POST[$wpbi_settings['parameter']['ch-y-column-cb']];
		$values_cols = $_POST[$wpbi_settings['parameter']['ch-v-column-cb']];
        $istime_cols = $_POST[$wpbi_settings['parameter']['ch-istime-column-cb']];
		$tx_label_cols = $_POST[$wpbi_settings['parameter']['ch-tx-column-tf']];
		$color_cols = $_POST['picker_column'];

		$_POST[$wpbi_settings['parameter']['ch-width']] = 	is_numeric($_POST[$wpbi_settings['parameter']['ch-width']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-width']])) :
																'400';
		$_POST[$wpbi_settings['parameter']['ch-height']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-height']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-height']])) :
																'400';
        $_POST[$wpbi_settings['parameter']['ch-x-precision']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-x-precision']]) ?
                                                                abs(intval($_POST[$wpbi_settings['parameter']['ch-x-precision']])) :
                                                                '1';
        $_POST[$wpbi_settings['parameter']['ch-y-precision']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-y-precision']]) ?
                                                                abs(intval($_POST[$wpbi_settings['parameter']['ch-y-precision']])) :
                                                                '1';
        $_POST[$wpbi_settings['parameter']['ch-y-currency']] = isset($_POST[$wpbi_settings['parameter']['ch-y-currency']]) ?
                                                                $_POST[$wpbi_settings['parameter']['ch-y-currency']] :
                                                                '$';
		$_POST[$wpbi_settings['parameter']['ch-y-legend-size']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-y-legend-size']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-y-legend-size']])) :
																'15';
		$_POST[$wpbi_settings['parameter']['ch-x-legend-size']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-x-legend-size']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-x-legend-size']])) :
																'15';
		$_POST[$wpbi_settings['parameter']['ch-y-label-size']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-y-label-size']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-y-label-size']])) :
																'10';
		$_POST[$wpbi_settings['parameter']['ch-x-label-size']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-x-label-size']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-x-label-size']])) :
																'10';
		$_POST[$wpbi_settings['parameter']['ch-y-axis-thick']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']]) ?
																	abs(intval($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']])) :
																	'2';
		$_POST[$wpbi_settings['parameter']['ch-x-axis-thick']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']]) ?
																	abs(intval($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']])) :
																	'2';	
		$_POST[$wpbi_settings['parameter']['ch-x-label-rotation']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']])) :
																'30';														
		$_POST[$wpbi_settings['parameter']['ch-y-label-rotation']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']])) :
																'0';
		$_POST[$wpbi_settings['parameter']['ch-x-grid-step']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-x-grid-step']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-x-grid-step']])) :
																'15';														
		$_POST[$wpbi_settings['parameter']['ch-y-grid-step']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-y-grid-step']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-y-grid-step']])) :
																'15';
		$_POST[$wpbi_settings['parameter']['ch-title-size']] = is_numeric($_POST[$wpbi_settings['parameter']['ch-title-size']]) ?
																abs(intval($_POST[$wpbi_settings['parameter']['ch-title-size']])) :
																'15';
		//Create chart
		$wpbi_chart = new chart();

		$wpbi_chart	-> set_name('My Chart');
		$wpbi_chart	-> set_tooltip($wpbi_dialog['charts']['default']['tooltip']);
		$wpbi_chart	-> set_width($_POST[$wpbi_settings['parameter']['ch-width']].$_POST[$wpbi_settings['parameter']['ch-width-percent']]);
		$wpbi_chart	-> set_height($_POST[$wpbi_settings['parameter']['ch-height']].$_POST[$wpbi_settings['parameter']['ch-height-percent']]);
        $wpbi_chart	-> set_x_precision($_POST[$wpbi_settings['parameter']['ch-x-precision']]);
        $wpbi_chart	-> set_y_precision($_POST[$wpbi_settings['parameter']['ch-y-precision']]);
        $wpbi_chart	-> set_y_currency($_POST[$wpbi_settings['parameter']['ch-y-currency']]);
		$wpbi_chart	-> set_bg_colour($_POST[$wpbi_settings['parameter']['ch-bgcolor']]);
		$wpbi_chart	-> set_title(($_POST[$wpbi_settings['parameter']['ch-title']]));
		$wpbi_chart	-> set_title_color(($_POST[$wpbi_settings['parameter']['ch-title-color']]));
		$wpbi_chart	-> set_title_size(($_POST[$wpbi_settings['parameter']['ch-title-size']]));
        $wpbi_chart	-> set_name(($_POST[$wpbi_settings['parameter']['ch-name']]));
		$wpbi_chart	-> set_type(intval($_POST[$wpbi_settings['parameter']['ch-type']]));
		$wpbi_chart	-> set_x_axis_step_percent(intval($_POST[$wpbi_settings['parameter']['ch-x-grid-step']]));
		$wpbi_chart	-> set_y_axis_step_percent(intval($_POST[$wpbi_settings['parameter']['ch-y-grid-step']]));

		//Get values, labels, colors
		$label_color = array();
		$stacked_label_color = array();
		$row_idx = 0;
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
						$label_tmp_x = 	($label_tmp_x=='') ? 
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
														$_POST[$wpbi_settings['parameter']['ch-x-label-size']],
														$_POST[$wpbi_settings['parameter']['ch-x-label-color']]);
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
														$_POST[$wpbi_settings['parameter']['ch-x-label-size']],
														$_POST[$wpbi_settings['parameter']['ch-x-label-color']]);
													}
													$wpbi_chart-> set_y_axis_labels_color($_POST[$wpbi_settings['parameter']['ch-y-label-color']]);
													$wpbi_chart-> set_y_axis_labels_size($_POST[$wpbi_settings['parameter']['ch-y-label-size']]);
													foreach($data_stacked as $key => $value){
														$wpbi_chart	-> create_element('BAR_STACKED', $value);
														$wpbi_chart	-> elements['BAR_STACKED'] -> set_colours($stacked_label_color);
													}
													break;
            case chart::STACKED_AREA:
			case chart::LINE_AREA:		if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_x_axis_labels($label_x,
														$_POST[$wpbi_settings['parameter']['ch-x-label-size']],
														$_POST[$wpbi_settings['parameter']['ch-x-label-color']], sizeof($istime_cols) > 0);
                                                        $wpbi_chart->x_axis_istime = (sizeof($istime_cols) > 0);
													}
													$wpbi_chart-> set_y_axis_labels_color($_POST[$wpbi_settings['parameter']['ch-y-label-color']]);
													$wpbi_chart-> set_y_axis_labels_size($_POST[$wpbi_settings['parameter']['ch-y-label-size']]);
													foreach($data as $key => $value){
														$wpbi_chart	-> create_element($key, $value);
														$wpbi_chart	-> elements[$key] -> set_colour($label_color[$key]);
														$wpbi_chart	-> elements[$key] -> set_fill_colour($label_color[$key]);
														$wpbi_chart	-> elements[$key] -> set_fill_alpha( 0.5 );
													}
													break;
			case chart::RADAR:			if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_y_axis_labels($label_x,
														$_POST[$wpbi_settings['parameter']['ch-y-label-size']],
														$_POST[$wpbi_settings['parameter']['ch-y-label-color']]);
													}
													foreach($data as $key => $value){
														$wpbi_chart	-> create_element($key, $value);
														$wpbi_chart	-> elements[$key] -> set_colour($label_color[$key]);
													}
													break;
			case chart::BAR_HORIZONTAL:	if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_y_axis_labels($label_x,
														$_POST[$wpbi_settings['parameter']['ch-y-label-size']],
														$_POST[$wpbi_settings['parameter']['ch-y-label-color']]);
													}
													$wpbi_chart-> set_x_axis_labels_color($_POST[$wpbi_settings['parameter']['ch-x-label-color']]);
													$wpbi_chart-> set_x_axis_labels_size($_POST[$wpbi_settings['parameter']['ch-x-label-size']]);
													foreach($data as $key => $value){
														$wpbi_chart	-> create_element($key, $value);
														$wpbi_chart	-> elements[$key] -> set_colour($label_color[$key]);
													}
													break;
			default:								if(sizeof($label_x) > 0){
														$wpbi_chart	-> set_x_axis_labels($label_x,
														$_POST[$wpbi_settings['parameter']['ch-x-label-size']],
														$_POST[$wpbi_settings['parameter']['ch-x-label-color']], sizeof($istime_cols) > 0);
                                                        $wpbi_chart->x_axis_istime = (sizeof($istime_cols) > 0);
													} else {
													$wpbi_chart->set_x_axis_labels_color($_POST[$wpbi_settings['parameter']['ch-x-label-color']]);
													$wpbi_chart->set_x_axis_labels_size($_POST[$wpbi_settings['parameter']['ch-x-label-size']]);
													}
													$wpbi_chart-> set_y_axis_labels_color($_POST[$wpbi_settings['parameter']['ch-y-label-color']]);
													$wpbi_chart-> set_y_axis_labels_size($_POST[$wpbi_settings['parameter']['ch-y-label-size']]);
													foreach($data as $key => $value){
														$wpbi_chart	-> create_element($key, $value);
														$wpbi_chart	-> elements[$key] -> set_colour($label_color[$key]);
													}
													break;
		}
		
		//Set legends
		$wpbi_chart	-> set_y_legend($_POST[$wpbi_settings['parameter']['ch-y-legend']],
											$_POST[$wpbi_settings['parameter']['ch-y-legend-size']],
											$_POST[$wpbi_settings['parameter']['ch-y-legend-color']]);
		$wpbi_chart	-> set_x_legend($_POST[$wpbi_settings['parameter']['ch-x-legend']],
											$_POST[$wpbi_settings['parameter']['ch-x-legend-size']],
											$_POST[$wpbi_settings['parameter']['ch-x-legend-color']]);
		$wpbi_chart	-> set_x_axis_labels_rotation($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']]);
		$wpbi_chart	-> set_y_axis_labels_rotation($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']]);
		$wpbi_chart	-> set_y_axis_color($_POST[$wpbi_settings['parameter']['ch-y-axis-color']]);
		$wpbi_chart	-> set_y_axis_grid_color($_POST[$wpbi_settings['parameter']['ch-y-grid-color']]);
		$wpbi_chart	-> set_y_axis_thickness($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']]);
		$wpbi_chart	-> set_x_axis_color($_POST[$wpbi_settings['parameter']['ch-x-axis-color']]);
		$wpbi_chart	-> set_x_axis_grid_color($_POST[$wpbi_settings['parameter']['ch-x-grid-color']]);
		$wpbi_chart	-> set_x_axis_thickness($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']]);
		
		//Main legend for stacked chart
		if($wpbi_chart->type == chart::BAR_STACKED){
			$stacked_keys = array(); 
			foreach($stacked_label_color as $stacked_label_key => $stacked_label_value){
				array_push($stacked_keys, new bar_stack_key( $stacked_label_value, $stacked_label_key, 10 ));
			}
			$wpbi_chart	-> elements['BAR_STACKED']->set_keys($stacked_keys);
		}
		
		$wpbi_chart	-> build();

		//Set template variables
		$template_site->assign_vars(array(
			//WPBI Chart
            'CH_NEW_CHART_NAME' 	    => 'my_chart',
			'CH_NEW_CHART_WIDTH' 		=> $wpbi_chart->width,
			'CH_NEW_CHART_HEIGHT'	    => $wpbi_chart->height,
			'CH_NEW_CHART_RESIZE'       => 'chart_resize',
			'CH_NEW_CHART_JSON' 		=> $wpbi_chart->get_json_code(),
            'CH_NEW_CHART_NVD3_CODE'        => $wpbi_chart->get_nvd3_chart_code(),
            'CH_NEW_CHART_NVD3_JSLIBS'      => $wpbi_chart->get_nvd3_chart_jslibs(),
            'CH_NEW_CHART_NVD3_DATA'        => $wpbi_chart->get_nvd3_chart_data(),
            'CH_NEW_CHART_NVD3_PLACEHOLDER' => $wpbi_chart->get_nvd3_chart_placeholder()

		)
		);
			
	}
	
	
	
} //End test new table


/**** Test saved chart ***/
if($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['test'] && isset($_GET[$wpbi_settings['parameter']['ch-id']])){
	
	$test_output = ''; //Store the test output 
	
	//Get cols metadata
	$selected_charts = $_GET[$wpbi_settings['parameter']['ch-id']];
	$vo_ch_cols = new vo_ch_cols();
	$vo_ch_cols->set_ch_id($selected_charts);
	$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
	$vo_ch_cols = $dao_ch_cols->select($vo_ch_cols);

	//Get chart metadata
	$vo_chart = new vo_chart(NULL);						
	$vo_chart->set_chart_id($selected_charts);
	$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
	$vo_chart = $dao_chart->select($vo_chart);
	$vo_chart = $vo_chart[0];

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
        $wpbi_chart	-> set_x_precision($_POST[$wpbi_settings['parameter']['ch-x-precision']]);
        $wpbi_chart	-> set_y_precision($_POST[$wpbi_settings['parameter']['ch-y-precision']]);
        $wpbi_chart	-> set_y_currency($_POST[$wpbi_settings['parameter']['ch-y-currency']]);

		//Get values, labels, colors
		$label_color = array();
		$stacked_label_color = array();
		$row_idx = 0;
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
						$label_tmp_x = 	($label_tmp_x=='') ? 
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
		
		//Main legend for stacked chart
		if($wpbi_chart->type == chart::BAR_STACKED){
			$stacked_keys = array();
			for($i=0; $i<sizeof($stacked_label_cols_color);$i++){
				array_push($stacked_keys, new bar_stack_key( $stacked_label_cols_color[$i], $stacked_label_cols[$i], 10 ));
			}
			$wpbi_chart	-> elements['BAR_STACKED']->set_keys($stacked_keys);
		}
        //echo 'build chart \n';
		$wpbi_chart	-> build();

		//Set template variables
		$template_site->assign_vars(array(
			//WPBI Chart
			'CH_NEW_CHART_NAME' 	    => 'my_chart',
			'CH_NEW_CHART_WIDTH' 		=> $wpbi_chart->width,
			'CH_NEW_CHART_HEIGHT'	    => $wpbi_chart->height,
			'CH_NEW_CHART_RESIZE'   => 'chart_resize',
			'CH_NEW_CHART_JSON' 		=> $wpbi_chart->get_json_code(),
            'CH_NEW_CHART_NVD3_CODE'        => $wpbi_chart->get_nvd3_chart_code(),
            'CH_NEW_CHART_NVD3_JSLIBS'      => $wpbi_chart->get_nvd3_chart_jslibs(),
            'CH_NEW_CHART_NVD3_DATA'        => $wpbi_chart->get_nvd3_chart_data(),
            'CH_NEW_CHART_NVD3_PLACEHOLDER' => $wpbi_chart->get_nvd3_chart_placeholder()
		)
		);
			
			
	
	//Prepare output
	$template_site->assign_vars(array(
	
	'PG_TITLE' 			=> $wpbi_dialog['page']['charts']['title'],
	'PG_DESCRIPTION' 	=> sprintf($wpbi_dialog['chart']['saved']['test'], $vo_chart->chart_name, $query->stmt)
	));
	
	$template_site->pparse('header');
	$template_site->pparse('nvd3chart');
	$template_site->pparse('footer');
	
} //End test saved table


?>


<?php
/***********************/
/***   EDIT ACTION   ***/
/***********************/

/**** Edit query form ***/
if(($_GET[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_GET[$wpbi_settings['parameter']['ch-id']]) ) || $_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit-test']){

	//Get chart metadata
	$selected_charts = isset($_GET[$wpbi_settings['parameter']['ch-id']]) ? $_GET[$wpbi_settings['parameter']['ch-id']] : $_POST[$wpbi_settings['parameter']['ch-id']];
	$vo_chart = new vo_chart(NULL);		
	$vo_chart->set_chart_id($selected_charts);				
	$vo_chart->set_chart_key($selected_charts);
	$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
	$vo_chart = $dao_chart->select($vo_chart);
	$vo_chart = $vo_chart[0];
	
	//Get cols metadata
	$vo_ch_cols = new vo_ch_cols();
	$vo_ch_cols->set_ch_id($vo_chart->chart_id);
	$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
	$vo_ch_cols = $dao_ch_cols->select($vo_ch_cols);
	
	//get columns	
	$x_label_cols = array();
	$color_cols = array();
	$tx_label_cols = array();
	$values_cols = array();
	$col_idx=0;
	foreach($vo_ch_cols as $vo_ch_col){
		array_push($tx_label_cols, $vo_ch_col->col_label);
		array_push($color_cols, $vo_ch_col->col_color);
		if($vo_ch_col->is_label){
			array_push($x_label_cols, $col_idx);
		}
		if($vo_ch_col->is_value){
			array_push($values_cols, $col_idx);
		}
        if($vo_ch_col->is_time){
            array_push($istime_cols, $col_idx);
        }

        $col_idx++;
	}	


	//Get selected query
	$dao_query = new dao_query($wpdb, $wpbi_sql['tname']['queries']);
	$tgt_query = new vo_query($vo_chart->query_id, NULL, NULL, NULL, NULL);
	$vo_query = $dao_query->select($tgt_query);
	$vo_query = $vo_query[0];
	$current_qy = $vo_query;
	
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
	
	//create new wpdb object
	$my_test_db = new wpdb($vo_database->user,$vo_database->pass,$vo_database->name,$vo_database->host);
	$query = new query($vo_query->statement, $wpdb, $wpbi_sql['tname']['vars']);
	
	//Execute query limiting the resultset
	$my_test_rows = $my_test_db->get_results($query->limit_qy_to(0, 1),'ARRAY_N');
	$my_test_cols = $my_test_db->get_col_info('name');

	//Create picker script for each column
		$col_idx = 0;
		$picker_js = 'jQuery(function() {';
		foreach($my_test_cols as $my_test_col){
			$picker_js = $picker_js.'jQuery(\'#picker_column_'.$col_idx.'\').colorPicker();';
			$col_idx++;
		}
		$picker_js = $picker_js.'});';
		
		//color set
		$color_4_picker = new color();
		
		//build html for columns
		$col_idx = 0;
		$columns_html = '';
		foreach($my_test_cols as $my_test_col){
			if(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-x-column-cb']])){
				$x_checked = 'checked';
			} else if($_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] && $vo_ch_cols[$col_idx]->is_label){
				$x_checked = 'checked';
			}
			if(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-v-column-cb']])){
				$v_checked = 'checked';
			} else if($_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] && $vo_ch_cols[$col_idx]->is_value){
				$v_checked = 'checked';
			}
            if(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-istime-column-cb']])){
                $istime_checked = 'checked';
            } else if($_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] && $vo_ch_cols[$col_idx]->is_time){
                $istime_checked = 'checked';
            }
			$column_name = isset($_POST[$wpbi_settings['parameter']['ch-tx-column-tf']]) ? $_POST[$wpbi_settings['parameter']['ch-tx-column-tf']][$col_idx] : $vo_ch_cols[$col_idx]->col_label;
			$column_color = isset($_POST['picker_column']) ? $_POST['picker_column'][$col_idx] : $vo_ch_cols[$col_idx]->col_color;
			$columns_html = $columns_html.'
				<tr valign="top">
	              <td scope="row">'.($my_test_col).'</td>
	              <td><input type="checkbox" name="'.$wpbi_settings['parameter']['ch-x-column-cb'].'[]" value="'.$col_idx.'" '.$x_checked.' /></td>
				  <td><input type="checkbox" name="'.$wpbi_settings['parameter']['ch-v-column-cb'].'[]" value="'.$col_idx.'" '.$v_checked.' /></td>
				  <td><input id="picker_column_'.$col_idx.'" type="text" name="picker_column[]" value="'.$column_color.'" /></td>
	              <td><input type="text"  maxlength="64" id="'.$wpbi_settings['parameter']['ch-tx-column-tf'].'" name="'.$wpbi_settings['parameter']['ch-tx-column-tf'].'[]" value="'.$column_name.'" /></td>
                  <td><input type="checkbox" name="'.$wpbi_settings['parameter']['ch-istime-column-cb'].'[]" value="'.$col_idx.'" '.$istime_checked.' /></td>
	            </tr>
			';
			$x_checked = '';
			$v_checked = '';
            $istime_checked = '';
			$col_idx++;
		}
    $columns_html .= '<tr><td colspan="7">'. $wpbi_settings['parameter']['charts_help'] .'</td></tr>';
	//Parse tested chart if any
		ob_start();
		$template_site->pparse('nvd3chart');
		$test_chart_output = ob_get_contents();
		ob_end_clean();
								
		
		$template_site->assign_vars(array(
		//Header
		'PG_TITLE'			=> $wpbi_dialog['page']['charts']['title'],
		'PG_DESCRIPTION' 	=> sprintf($wpbi_dialog['chart']['saved']['edit'], $vo_chart->chart_name, htmlentities($current_qy->statement)),
		
		//Chart
		'CH_EDIT_PICKER_JS'		=> $picker_js,
		'CH_EDIT_BASIC_SETTINGS' 		=> $wpbi_dialog['form']['label']['basic-settings'],
		'CH_EDIT_NAME'			=> $wpbi_dialog['form']['label']['chart-name'],
		'P_CH_NAME'				=> $wpbi_settings['parameter']['ch-name'],
		'V_CH_NAME' 			=> isset($_POST[$wpbi_settings['parameter']['ch-name']])?$_POST[$wpbi_settings['parameter']['ch-name']]:$vo_chart->chart_name,
		'P_CH_BGCOLOR'			=> $wpbi_settings['parameter']['ch-bgcolor'],
		'V_CH_BGCOLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-bgcolor']]) ?
									$_POST[$wpbi_settings['parameter']['ch-bgcolor']] :
									$vo_chart->chart_bg_color,
		'CH_EDIT_WIDTH'			=> $wpbi_dialog['form']['label']['chart-width'],
		'V_CH_WIDTH_CHECKED'	=> 	isset($_POST[$wpbi_settings['parameter']['ch-width-percent']]) ||
									($_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] &&
									$vo_chart->chart_width_percent) ? 'checked' : '',
		'P_CH_WIDTH_PERCENT' 	=> $wpbi_settings['parameter']['ch-width-percent'],
		'P_CH_WIDTH' 			=> $wpbi_settings['parameter']['ch-width'],
		'V_CH_WIDTH' 			=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-width']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-width']])) :
									$vo_chart->chart_width,
									
		'CH_EDIT_X_AXIS_SETTINGS'			=> $wpbi_dialog['form']['label']['x-settings'],
		'CH_EDIT_Y_AXIS_SETTINGS'			=> $wpbi_dialog['form']['label']['y-settings'],
		'CH_EDIT_HEIGHT'			=> $wpbi_dialog['form']['label']['chart-height'],
        'CH_EDIT_X_PRECISION'			=> $wpbi_dialog['form']['label']['chart-x-precision'],
        'CH_EDIT_Y_PRECISION'			=> $wpbi_dialog['form']['label']['chart-y-precision'],
        'CH_EDIT_Y_CURRENCY'			=> $wpbi_dialog['form']['label']['chart-y-currency'],
		'V_CH_HEIGHT_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['ch-height-percent']]) ||
									($_POST[$wpbi_settings['parameter']['action']] != $wpbi_settings['value']['edit-test'] &&
									$vo_chart->chart_height_percent) ? 'checked' : '',
		'P_CH_HEIGHT_PERCENT' 	=> $wpbi_settings['parameter']['ch-height-percent'],
		'P_CH_HEIGHT' 			=> $wpbi_settings['parameter']['ch-height'],
        'P_CH_X_PRECISION' 			=> $wpbi_settings['parameter']['ch-x-precision'],
        'P_CH_Y_PRECISION' 			=> $wpbi_settings['parameter']['ch-y-precision'],
        'P_CH_Y_CURRENCY' 			=> $wpbi_settings['parameter']['ch-y-currency'],
		'V_CH_HEIGHT' 			=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-height']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-height']])) :
									$vo_chart->chart_height,
        'V_CH_X_PRECISION' 			=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-precision']]) ?
                                    abs(intval($_POST[$wpbi_settings['parameter']['ch-x-precision']])) :
                                    $vo_chart->chart_x_axis_precision,
        'CH_EDIT_X_LEGEND'			=> $wpbi_dialog['form']['label']['ch-x-legend'],
		'V_CH_X_LEGEND'	=> isset($_POST[$wpbi_settings['parameter']['ch-x-legend']]) ? $_POST[$wpbi_settings['parameter']['ch-x-legend']] : $vo_chart->chart_x_legend,
		'P_CH_X_LEGEND' 	=> 	$wpbi_settings['parameter']['ch-x-legend'],
		'CH_EDIT_X_LEGEND_SIZE' 			=> $wpbi_dialog['form']['label']['ch-x-legend-size'],
		'P_CH_X_LEGEND_SIZE' 	=> $wpbi_settings['parameter']['ch-x-legend-size'],
		'V_CH_X_LEGEND_SIZE' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-legend-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-legend-size']])) :
									$vo_chart->chart_x_legend_size,
		'CH_EDIT_X_AXIS_THICK' 			=> $wpbi_dialog['form']['label']['ch-x-axis-thick'],
		'P_CH_X_AXIS_THICK' 	=> $wpbi_settings['parameter']['ch-x-axis-thick'],
		'V_CH_X_AXIS_THICK' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']])) :
									$vo_chart->chart_x_thickness,
		'CH_EDIT_X_LEGEND_COLOR' 			=> $wpbi_dialog['form']['label']['ch-x-legend-color'],
		'P_CH_X_LEGEND_COLOR'			=> $wpbi_settings['parameter']['ch-x-legend-color'],
		'V_CH_X_LEGEND_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-x-legend-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-x-legend-color']] :
									$vo_chart->chart_x_legend_color,
		'CH_EDIT_X_LABEL_SIZE' 			=> $wpbi_dialog['form']['label']['ch-x-label-size'],
		'P_CH_X_LABEL_SIZE' 	=> $wpbi_settings['parameter']['ch-x-label-size'],
		'V_CH_X_LABEL_SIZE' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-label-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-label-size']])) :
									$vo_chart->chart_x_labels_size,
		'CH_EDIT_X_LABEL_ROTATION' 			=> $wpbi_dialog['form']['label']['ch-x-label-rotation'],
		'P_CH_X_LABEL_ROTATION' 	=> $wpbi_settings['parameter']['ch-x-label-rotation'],
		'V_CH_X_LABEL_ROTATION' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']])) :
									$vo_chart->chart_x_labels_rotation,
		'CH_EDIT_X_LABEL_COLOR' 			=> $wpbi_dialog['form']['label']['ch-x-label-color'],
		'P_CH_X_LABEL_COLOR'			=> $wpbi_settings['parameter']['ch-x-label-color'],
		'V_CH_X_LABEL_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-x-label-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-x-label-color']] :
									$vo_chart->chart_x_labels_color,
		'CH_EDIT_X_AXIS_COLOR' 			=> $wpbi_dialog['form']['label']['ch-x-axis-color'],
		'P_CH_X_AXIS_COLOR'			=> $wpbi_settings['parameter']['ch-x-axis-color'],
		'V_CH_X_AXIS_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-x-axis-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-x-axis-color']] :
									$vo_chart->chart_x_color,
		'CH_EDIT_X_GRID_COLOR' 			=> $wpbi_dialog['form']['label']['ch-x-grid-color'],
		'P_CH_X_GRID_COLOR'			=> $wpbi_settings['parameter']['ch-x-grid-color'],
		'V_CH_X_GRID_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-x-grid-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-x-grid-color']] :
									$vo_chart->chart_x_grid_color,
		'CH_EDIT_X_GRID_STEP' 			=> $wpbi_dialog['form']['label']['ch-x-grid-step'],
		'P_CH_X_GRID_STEP' 	=> $wpbi_settings['parameter']['ch-x-grid-step'],
		'V_CH_X_GRID_STEP' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-grid-step']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-grid-step']])) :
									$vo_chart->chart_x_grid_lines,
        'V_CH_Y_PRECISION' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-precision']]) ?
                                    abs(intval($_POST[$wpbi_settings['parameter']['ch-y-precision']])) :
                                    $vo_chart->chart_y_axis_precision,
        'V_CH_Y_CURRENCY' 		=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-currency']]) ?
                                    $_POST[$wpbi_settings['parameter']['ch-y-currency']] :
                                    $vo_chart->chart_y_axis_currency,
		'CH_EDIT_Y_LEGEND'			=> $wpbi_dialog['form']['label']['ch-y-legend'],
		'V_CH_Y_LEGEND'	=> isset($_POST[$wpbi_settings['parameter']['ch-y-legend']])?$_POST[$wpbi_settings['parameter']['ch-y-legend']]:$vo_chart->chart_y_legend,
		'P_CH_Y_LEGEND' 	=> 	$wpbi_settings['parameter']['ch-y-legend'],
		'CH_EDIT_Y_LEGEND_SIZE' 			=> $wpbi_dialog['form']['label']['ch-y-legend-size'],
		'P_CH_Y_LEGEND_SIZE' 	=> $wpbi_settings['parameter']['ch-y-legend-size'],
		'V_CH_Y_LEGEND_SIZE' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-legend-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-legend-size']])) :
									$vo_chart->chart_y_legend_size,
		'CH_EDIT_Y_LABEL_SIZE' 			=> $wpbi_dialog['form']['label']['ch-y-label-size'],
		'P_CH_Y_LABEL_SIZE' 	=> $wpbi_settings['parameter']['ch-y-label-size'],
		'V_CH_Y_LABEL_SIZE' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-label-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-label-size']])) :
									$vo_chart->chart_y_labels_size,
		'CH_EDIT_Y_LABEL_ROTATION' 			=> $wpbi_dialog['form']['label']['ch-y-label-rotation'],
		'P_CH_Y_LABEL_ROTATION' 	=> $wpbi_settings['parameter']['ch-y-label-rotation'],
		'V_CH_Y_LABEL_ROTATION' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']])) :
									$vo_chart->chart_y_labels_rotation,
		'CH_EDIT_Y_LABEL_COLOR' 			=> $wpbi_dialog['form']['label']['ch-y-label-color'],
		'P_CH_Y_LABEL_COLOR'			=> $wpbi_settings['parameter']['ch-y-label-color'],
		'V_CH_Y_LABEL_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-label-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-y-label-color']] :
									$vo_chart->chart_y_labels_color,
		'CH_EDIT_Y_LEGEND_COLOR' 			=> $wpbi_dialog['form']['label']['ch-y-legend-color'],
		'P_CH_Y_LEGEND_COLOR'			=> $wpbi_settings['parameter']['ch-y-legend-color'],
		'V_CH_Y_LEGEND_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-legend-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-y-legend-color']] :
									$vo_chart->chart_y_legend_color,
		'CH_EDIT_Y_AXIS_COLOR' 			=> $wpbi_dialog['form']['label']['ch-y-axis-color'],
		'P_CH_Y_AXIS_COLOR'			=> $wpbi_settings['parameter']['ch-y-axis-color'],
		'V_CH_Y_AXIS_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-axis-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-y-axis-color']] :
									$vo_chart->chart_y_color,
		'CH_EDIT_Y_GRID_COLOR' 			=> $wpbi_dialog['form']['label']['ch-y-grid-color'],
		'P_CH_Y_GRID_COLOR'			=> $wpbi_settings['parameter']['ch-y-grid-color'],
		'V_CH_Y_GRID_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-grid-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-y-grid-color']] :
									$vo_chart->chart_y_grid_color,
		'CH_EDIT_Y_GRID_STEP' 			=> $wpbi_dialog['form']['label']['ch-y-grid-step'],
		'P_CH_Y_GRID_STEP' 	=> $wpbi_settings['parameter']['ch-y-grid-step'],
		'V_CH_Y_GRID_STEP' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-grid-step']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-grid-step']])) :
									$vo_chart->chart_y_grid_lines,
		'CH_EDIT_Y_AXIS_THICK' 			=> $wpbi_dialog['form']['label']['ch-y-axis-thick'],
		'P_CH_Y_AXIS_THICK' 	=> $wpbi_settings['parameter']['ch-y-axis-thick'],
		'V_CH_Y_AXIS_THICK' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']])) :
									$vo_chart->chart_y_thickness,
									
		'CH_EDIT_BGCOLOR' 		=> $wpbi_dialog['form']['label']['chart-bgcolor'],
		
		'CH_EDIT_TITLE' 			=> $wpbi_dialog['form']['label']['chart-title'],
		'P_CH_TITLE' 			=> $wpbi_settings['parameter']['ch-title'],
		'V_CH_TITLE' 			=> isset($_POST[$wpbi_settings['parameter']['ch-title']])?$_POST[$wpbi_settings['parameter']['ch-title']]:$vo_chart->chart_title,
		
		'CH_EDIT_TITLE_COLOR' 			=> $wpbi_dialog['form']['label']['chart-title-color'],
		'P_CH_TITLE_COLOR' 			=> $wpbi_settings['parameter']['ch-title-color'],
		'V_CH_TITLE_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-title-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-title-color']] :
									$vo_chart->chart_title_color,
		
		'CH_EDIT_TITLE_SIZE' 			=> $wpbi_dialog['form']['label']['chart-title-size'],
		'P_CH_TITLE_SIZE' 			=> $wpbi_settings['parameter']['ch-title-size'],
		'V_CH_TITLE_SIZE' 			=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-title-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-title-size']])) :
									$vo_chart->chart_title_size,
		
		'CH_EDIT_TYPE' 			=> $wpbi_dialog['form']['label']['chart-type'],
		'SELECTED_'.(isset($_POST[$wpbi_settings['parameter']['ch-type']])?$_POST[$wpbi_settings['parameter']['ch-type']]:$vo_chart->chart_type)						=> 'selected',
		'P_CH_TYPE'			=> $wpbi_settings['parameter']['ch-type'] ,
		'P_CH_TX_COLUMN_TF' 	=> $wpbi_settings['parameter']['ch-tx-column-tf'],
		'CH_EDIT_COLUMNS' 		=> $wpbi_dialog['form']['label']['chart-col'],
		'CH_EDIT_COL_VALUE' 		=> $wpbi_dialog['form']['label']['chart-col-value'],
		'CH_EDIT_COL_LABEL' 			=> $wpbi_dialog['form']['label']['chart-col-label'],
		'CH_EDIT_COL_COLOR' 			=> $wpbi_dialog['form']['label']['chart-col-color'],
		'CH_EDIT_COL_RENAME' 		=> $wpbi_dialog['form']['label']['chart-col-rename'],
        'CH_EDIT_COL_ISTIME' 		=> $wpbi_dialog['form']['label']['chart-col-istime'],
		'LBL_BTN_EDIT' 			=> $wpbi_dialog['button']['label']['save'],
		'LBL_BTN_TEST' 			=> $wpbi_dialog['button']['label']['test'],
		'P_CH_QY' 				=> $wpbi_settings['parameter']['qy_id'],
		'P_CH_TX_COLUMN_TF' 	=> $wpbi_settings['parameter']['ch-tx-column-tf'],
		'V_CH_QY' 				=> isset($_POST[$wpbi_settings['parameter']['qy_id']])?$_POST[$wpbi_settings['parameter']['qy_id']]:$vo_chart->query_id,
		'P_CH_ID' 				=> $wpbi_settings['parameter']['ch-id'],
		'V_CH_ID' 				=> isset($_POST[$wpbi_settings['parameter']['ch_id']])?$_POST[$wpbi_settings['parameter']['ch-id']]:$vo_chart->chart_id,
		'P_CH_ACTION' 			=> $wpbi_settings['parameter']['action'],
		'V_EDIT_ACTION' 			=> $wpbi_settings['value']['edit'],
		'V_TEST_ACTION' 		=> $wpbi_settings['value']['edit-test'],
		'CH_TEST_RESULT'		=> $test_output,
		'CH_EDIT_STYLE_DEFAULT_OPT' => $wpbi_dialog['form']['option']['table-style-default'],
		'CH_EDIT_TYPE_LINE' 			=> $wpbi_dialog['charts']['type']['line'],
		'CH_EDIT_TYPE_LINE_AREA' 			=> $wpbi_dialog['charts']['type']['line-area'],
		'CH_EDIT_TYPE_BAR' 			=> $wpbi_dialog['charts']['type']['bar'],
		'CH_EDIT_TYPE_BAR_FILLED' 			=> $wpbi_dialog['charts']['type']['bar-filled'],
		'CH_EDIT_TYPE_BAR_GLASS' 			=> $wpbi_dialog['charts']['type']['bar-glass'],
		'CH_EDIT_TYPE_BAR_3D' 			=> $wpbi_dialog['charts']['type']['bar-3d'],
		'CH_EDIT_TYPE_BAR_SKETCH' 			=> $wpbi_dialog['charts']['type']['bar-sketch'],
		'CH_EDIT_TYPE_BAR_CYLINDER' 			=> $wpbi_dialog['charts']['type']['bar-cylinder'],
		'CH_EDIT_TYPE_BAR_CYLINDER_OUTLINE' 			=> $wpbi_dialog['charts']['type']['bar-cylinder-outline'],
		'CH_EDIT_TYPE_BAR_ROUNDED_GLASS' 			=> $wpbi_dialog['charts']['type']['bar-rounded-glass'],
		'CH_EDIT_TYPE_BAR_DOME' 			=> $wpbi_dialog['charts']['type']['bar-dome'],
		'CH_EDIT_TYPE_BAR_ROUND_3D' 			=> $wpbi_dialog['charts']['type']['bar-round-3d'],
		'CH_EDIT_TYPE_BAR_HORIZONTAL' 			=> $wpbi_dialog['charts']['type']['bar-horizontal'],
		'CH_EDIT_TYPE_BAR_STACKED' 			=> $wpbi_dialog['charts']['type']['bar-stacked'],
		//'CH_EDIT_TYPE_CANDLE' 			=> $wpbi_dialog['charts']['type']['candle'],
		'CH_EDIT_TYPE_PIE' 			=> $wpbi_dialog['charts']['type']['pie'],
        'CH_EDIT_TYPE_DONUT' 			=> $wpbi_dialog['charts']['type']['donut'],
		'CH_EDIT_TYPE_SCATTER' 			=> $wpbi_dialog['charts']['type']['scatter'],
		'CH_EDIT_TYPE_SCATTER_LINE' 			=> $wpbi_dialog['charts']['type']['scatter-line'],
        'CH_EDIT_TYPE_CUMULATIVE_LINE' 			=> $wpbi_dialog['charts']['type']['cumulative-line'],
        'CH_EDIT_TYPE_LINE_AND_BAR' 			=> $wpbi_dialog['charts']['type']['line-and-bar'],
        'CH_EDIT_TYPE_MULTI_LINE_FOCUS' 			=> $wpbi_dialog['charts']['type']['multi-line-focus'],
        'CH_EDIT_TYPE_STACKED_AREA' 			=> $wpbi_dialog['charts']['type']['stacked-area'],
		'CH_EDIT_TYPE_RADAR' 			=> $wpbi_dialog['charts']['type']['radar'],
		'CH_EDIT_COLUMNS_OPTIONS'=> $columns_html,
		'CH_EDIT_CHART_TEST' => $test_chart_output,
		'CH_EDIT_FORM_ACTION'=> substr((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)),  0, strpos((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)), '&')),
	
		)); 
		
	
	
	//Parse tpl
	$template_site->pparse('header');
	$template_site->pparse('charts-edit-2');


	
}

/**** Edit chart: save modifications ***/
if($_POST[$wpbi_settings['parameter']['action']] == $wpbi_settings['value']['edit'] && isset($_POST[$wpbi_settings['parameter']['ch-id']])){

	//set chart metadata
	$vo_new_chart = new vo_chart(NULL);	
	$vo_new_chart->set_chart_id($_POST[$wpbi_settings['parameter']['ch-id']]);
	$vo_new_chart->set_query_id($_POST[$wpbi_settings['parameter']['qy_id']]);
	$vo_new_chart->set_chart_key(md5(date('YmdHis').rand(100)));
	$vo_new_chart->set_chart_name($_POST[$wpbi_settings['parameter']['ch-name']]);
	$vo_new_chart->set_chart_type($_POST[$wpbi_settings['parameter']['ch-type']]);
	$vo_new_chart->set_chart_title($_POST[$wpbi_settings['parameter']['ch-title']]);
	$vo_new_chart->set_chart_title_size($_POST[$wpbi_settings['parameter']['ch-title-size']]);
	$vo_new_chart->set_chart_title_color($_POST[$wpbi_settings['parameter']['ch-title-color']]);
	$vo_new_chart->set_chart_bg_color($_POST[$wpbi_settings['parameter']['ch-bgcolor']]);
	$vo_new_chart->set_chart_width($_POST[$wpbi_settings['parameter']['ch-width']]);
	$vo_new_chart->set_chart_width_percent(isset($_POST[$wpbi_settings['parameter']['ch-width-percent']]) ? 1 : 0);
	$vo_new_chart->set_chart_height($_POST[$wpbi_settings['parameter']['ch-height']]);
	$vo_new_chart->set_chart_height_percent(isset($_POST[$wpbi_settings['parameter']['ch-height-percent']]) ? 1 : 0);
	$vo_new_chart->set_chart_x_color($_POST[$wpbi_settings['parameter']['ch-x-axis-color']]);
    $vo_new_chart->set_chart_x_precision($_POST[$wpbi_settings['parameter']['ch-x-precision']]);
	$vo_new_chart->set_chart_x_thickness($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']]);
	$vo_new_chart->set_chart_x_grid_color($_POST[$wpbi_settings['parameter']['ch-x-grid-color']]);
	$vo_new_chart->set_chart_x_grid_lines($_POST[$wpbi_settings['parameter']['ch-x-grid-step']]);
	$vo_new_chart->set_chart_x_labels_color($_POST[$wpbi_settings['parameter']['ch-x-label-color']]);
	$vo_new_chart->set_chart_x_labels_size($_POST[$wpbi_settings['parameter']['ch-x-label-size']]);
	$vo_new_chart->set_chart_x_labels_rotation($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']]);
	$vo_new_chart->set_chart_x_legend($_POST[$wpbi_settings['parameter']['ch-x-legend']]);
	$vo_new_chart->set_chart_x_legend_color($_POST[$wpbi_settings['parameter']['ch-x-legend-color']]);
	$vo_new_chart->set_chart_x_legend_size($_POST[$wpbi_settings['parameter']['ch-x-legend-size']]);
	$vo_new_chart->set_chart_y_color($_POST[$wpbi_settings['parameter']['ch-y-axis-color']]);
    $vo_new_chart->set_chart_y_precision($_POST[$wpbi_settings['parameter']['ch-y-precision']]);
    $vo_new_chart->set_chart_y_currency($_POST[$wpbi_settings['parameter']['ch-y-currency']]);
	$vo_new_chart->set_chart_y_thickness($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']]);
	$vo_new_chart->set_chart_y_grid_color($_POST[$wpbi_settings['parameter']['ch-y-grid-color']]);
	$vo_new_chart->set_chart_y_grid_lines($_POST[$wpbi_settings['parameter']['ch-y-grid-step']]);
	$vo_new_chart->set_chart_y_labels_color($_POST[$wpbi_settings['parameter']['ch-y-label-color']]);
	$vo_new_chart->set_chart_y_labels_size($_POST[$wpbi_settings['parameter']['ch-y-label-size']]);
	$vo_new_chart->set_chart_y_labels_rotation($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']]);
	$vo_new_chart->set_chart_y_legend($_POST[$wpbi_settings['parameter']['ch-y-legend']]);
	$vo_new_chart->set_chart_y_legend_color($_POST[$wpbi_settings['parameter']['ch-y-legend-color']]);
	$vo_new_chart->set_chart_y_legend_size($_POST[$wpbi_settings['parameter']['ch-y-legend-size']]);

	$vo_old_chart = new vo_chart(NULL);
	$vo_old_chart->set_chart_id($_POST[$wpbi_settings['parameter']['ch-id']]);
	
	$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
	$dao_chart->edit($vo_old_chart, $vo_new_chart);
	
	//Drop cols metadata
	$selected_charts = $_POST[$wpbi_settings['parameter']['ch-id']];
	$vo_ch_cols = new vo_ch_cols(NULL, $selected_charts, NULL, NULL, NULL, NULL);
	$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
	$dao_ch_cols->del($vo_ch_cols);
	
	//insert columns metadata
	for($col_idx = 0; $col_idx<sizeof($_POST[$wpbi_settings['parameter']['ch-tx-column-tf']]); $col_idx++){
		$vo_ch_cols = new vo_ch_cols();
		$vo_ch_cols->set_id(NULL);
		$vo_ch_cols->set_ch_id($_POST[$wpbi_settings['parameter']['ch-id']]);
		$vo_ch_cols->set_col_label($_POST[$wpbi_settings['parameter']['ch-tx-column-tf']][$col_idx]);
		$vo_ch_cols->set_col_color($_POST['picker_column'][$col_idx]);
		$vo_ch_cols->set_is_label(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-x-column-cb']]) ? 1 : 0);
		$vo_ch_cols->set_is_value(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-v-column-cb']]) ? 1 : 0);
        $vo_ch_cols->set_is_time(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-istime-column-cb']]) ? 1 : 0);

		$dao_ch_cols = new dao_ch_cols($wpdb, $wpbi_sql['tname']['chart-cols']);
		$dao_ch_cols->add($vo_ch_cols);
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
		'PG_TITLE'			=> $wpbi_dialog['page']['charts']['title'],
		'PG_DESCRIPTION' 	=> $wpbi_dialog['page']['charts']['description'],
	
		/* New view form 1 */
		'CH_NEW_QUERY' 		=> $wpbi_dialog['field']['tables']['query'],
		'CH_NEW_QY_OPTIONS'	=> $select_options,
		'CH_NEW_FORM_ACTION'=> substr((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)),  0, strpos((substr(strrchr($_SERVER['REQUEST_URI'], '/'), 1)), '&')),
		'P_CH_ACTION' 		=> $wpbi_settings['parameter']['action'],
		'V_SET_ACTION' 		=> $wpbi_settings['value']['set'],
		'P_CH_QY' 			=> $wpbi_settings['parameter']['qy_id'],
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
		
		//Create picker script for each column
		$col_idx = 0;
		$picker_js = 'jQuery(function() {';
		foreach($my_test_cols as $my_test_col){
			$picker_js = $picker_js.'jQuery(\'#picker_column_'.$col_idx.'\').colorPicker();';
			$col_idx++;
		}
		$picker_js = $picker_js.'});';
		
		//color set
		$color_4_picker = new color();
		
		//build html for columns
		$col_idx = 0;
		$columns_html = '';
		foreach($my_test_cols as $my_test_col){
			if(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-x-column-cb']])){$x_checked = 'checked';}
			if(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-v-column-cb']])){$v_checked = 'checked';}
            if(in_array($col_idx, $_POST[$wpbi_settings['parameter']['ch-istime-column-cb']])){$istime_checked = 'checked';}
			$column_name = isset($_POST[$wpbi_settings['parameter']['ch-tx-column-tf']]) ? $_POST[$wpbi_settings['parameter']['ch-tx-column-tf']][$col_idx] : $my_test_col;
			$column_color = isset($_POST['picker_column']) ? $_POST['picker_column'][$col_idx] : $color_4_picker->get_color($col_idx);
			$columns_html = $columns_html.'
				<tr valign="top">
	              <td scope="row">'.($my_test_col).'</td>
	              <td><input type="checkbox" name="'.$wpbi_settings['parameter']['ch-x-column-cb'].'[]" value="'.$col_idx.'" '.$x_checked.' /></td>
				  <td><input type="checkbox" name="'.$wpbi_settings['parameter']['ch-v-column-cb'].'[]" value="'.$col_idx.'" '.$v_checked.' /></td>
				  <td><input id="picker_column_'.$col_idx.'" type="text" name="picker_column[]" value="'.$column_color.'" /></td>
	              <td><input type="text"  maxlength="64" id="'.$wpbi_settings['parameter']['ch-tx-column-tf'].'" name="'.$wpbi_settings['parameter']['ch-tx-column-tf'].'[]" value="'.$column_name.'" /></td>
	              <td><input type="checkbox" name="'.$wpbi_settings['parameter']['ch-istime-column-cb'].'[]" value="'.$col_idx.'" '.$istime_checked.' /></td>
	            </tr>
			';
			$x_checked = '';
			$v_checked = '';
            $istime_checked = '';
			$col_idx++;
		}
        $columns_html .= '<tr><td colspan="7">'. $wpbi_settings['parameter']['charts_help'] .'</td></tr>';
		
		//Parse tested chart if any
		ob_start();
		$template_site->pparse('nvd3chart');
		$test_chart_output = ob_get_contents();
		ob_end_clean();
		
		$template_site->assign_vars(array(
	
		/* New view form 2 */
		'TPL_CSS'				=> $wpbi_url['styles']['url'].$_POST[$wpbi_settings['parameter']['tb-style']],
		'CH_NEW_PICKER_JS'		=> $picker_js,
		'CH_NEW_BASIC_SETTINGS' 		=> $wpbi_dialog['form']['label']['basic-settings'],
		'CH_NEW_NAME'			=> $wpbi_dialog['form']['label']['chart-name'],
		'P_CH_NAME'				=> $wpbi_settings['parameter']['ch-name'],
		'V_CH_NAME' 			=> $_POST[$wpbi_settings['parameter']['ch-name']],
		'P_CH_BGCOLOR'			=> $wpbi_settings['parameter']['ch-bgcolor'],
		'V_CH_BGCOLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-bgcolor']]) ?
									$_POST[$wpbi_settings['parameter']['ch-bgcolor']] :
									'#FFFFFF',
		'CH_NEW_WIDTH'			=> $wpbi_dialog['form']['label']['chart-width'],
		'V_CH_WIDTH_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['ch-width-percent']]) ? 'checked' : '',
		'P_CH_WIDTH_PERCENT' 	=> $wpbi_settings['parameter']['ch-width-percent'],
		'P_CH_WIDTH' 			=> $wpbi_settings['parameter']['ch-width'],
		'V_CH_WIDTH' 			=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-width']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-width']])) :
									'400',
									
		'CH_NEW_X_AXIS_SETTINGS'			=> $wpbi_dialog['form']['label']['x-settings'],
		'CH_NEW_Y_AXIS_SETTINGS'			=> $wpbi_dialog['form']['label']['y-settings'],
		'CH_NEW_HEIGHT'			=> $wpbi_dialog['form']['label']['chart-height'],
        'CH_NEW_X_PRECISION'			=> $wpbi_dialog['form']['label']['chart-x-precision'],
        'CH_NEW_Y_PRECISION'			=> $wpbi_dialog['form']['label']['chart-y-precision'],
        'CH_NEW_Y_CURRENCY'			=> $wpbi_dialog['form']['label']['chart-y-currency'],
		'V_CH_HEIGHT_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['ch-height-percent']]) ? 'checked' : '',
		'P_CH_HEIGHT_PERCENT' 	=> $wpbi_settings['parameter']['ch-height-percent'],
		'P_CH_HEIGHT' 			=> $wpbi_settings['parameter']['ch-height'],
        'P_CH_X_PRECISION' 			=> $wpbi_settings['parameter']['ch-x-precision'],
        'P_CH_Y_PRECISION' 			=> $wpbi_settings['parameter']['ch-y-precision'],
        'P_CH_Y_CURRENCY' 			=> $wpbi_settings['parameter']['ch-y-currency'],
		'V_CH_HEIGHT' 			=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-height']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-height']])) :
									'400',
        'V_CH_X_PRECISION' 	    => 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-precision']]) ?
                                    abs(intval($_POST[$wpbi_settings['parameter']['ch-x-precision']])) :
                                    '1',
		'CH_NEW_X_LEGEND'			=> $wpbi_dialog['form']['label']['ch-x-legend'],
		'V_CH_X_LEGEND'	=> $_POST[$wpbi_settings['parameter']['ch-x-legend']],
		'P_CH_X_LEGEND' 	=> 	$wpbi_settings['parameter']['ch-x-legend'],
		'CH_NEW_X_LEGEND_SIZE' 			=> $wpbi_dialog['form']['label']['ch-x-legend-size'],
		'P_CH_X_LEGEND_SIZE' 	=> $wpbi_settings['parameter']['ch-x-legend-size'],
		'V_CH_X_LEGEND_SIZE' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-legend-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-legend-size']])) :
									'15',
		'CH_NEW_X_AXIS_THICK' 			=> $wpbi_dialog['form']['label']['ch-x-axis-thick'],
		'P_CH_X_AXIS_THICK' 	=> $wpbi_settings['parameter']['ch-x-axis-thick'],
		'V_CH_X_AXIS_THICK' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-axis-thick']])) :
									'2',
		'CH_NEW_X_LEGEND_COLOR' 		=> $wpbi_dialog['form']['label']['ch-x-legend-color'],
		'P_CH_X_LEGEND_COLOR'			=> $wpbi_settings['parameter']['ch-x-legend-color'],
		'V_CH_X_LEGEND_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-x-legend-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-x-legend-color']] :
									'#000000',
		'CH_NEW_X_LABEL_SIZE' 	=> $wpbi_dialog['form']['label']['ch-x-label-size'],
		'P_CH_X_LABEL_SIZE' 	=> $wpbi_settings['parameter']['ch-x-label-size'],
		'V_CH_X_LABEL_SIZE' 	=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-label-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-label-size']])) :
									'10',
		'CH_NEW_X_LABEL_ROTATION' 	=> $wpbi_dialog['form']['label']['ch-x-label-rotation'],
		'P_CH_X_LABEL_ROTATION' 	=> $wpbi_settings['parameter']['ch-x-label-rotation'],
		'V_CH_X_LABEL_ROTATION' 	=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-label-rotation']])) :
									'30',
		'CH_NEW_X_LABEL_COLOR' 			=> $wpbi_dialog['form']['label']['ch-x-label-color'],
		'P_CH_X_LABEL_COLOR'			=> $wpbi_settings['parameter']['ch-x-label-color'],
		'V_CH_X_LABEL_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-x-label-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-x-label-color']] :
									'#000000',
		'CH_NEW_X_AXIS_COLOR' 			=> $wpbi_dialog['form']['label']['ch-x-axis-color'],
		'P_CH_X_AXIS_COLOR'			=> $wpbi_settings['parameter']['ch-x-axis-color'],
		'V_CH_X_AXIS_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-x-axis-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-x-axis-color']] :
									'#DAD5E0',
		'CH_NEW_X_GRID_COLOR' 			=> $wpbi_dialog['form']['label']['ch-x-grid-color'],
		'P_CH_X_GRID_COLOR'			=> $wpbi_settings['parameter']['ch-x-grid-color'],
		'V_CH_X_GRID_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-x-grid-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-x-grid-color']] :
									'#DAD5E0',
		'CH_NEW_X_GRID_STEP' 			=> $wpbi_dialog['form']['label']['ch-x-grid-step'],
		'P_CH_X_GRID_STEP' 	=> $wpbi_settings['parameter']['ch-x-grid-step'],
		'V_CH_X_GRID_STEP' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-x-grid-step']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-x-grid-step']])) :
									'15',
        'V_CH_Y_PRECISION' 	    => 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-precision']]) ?
                                    abs(intval($_POST[$wpbi_settings['parameter']['ch-y-precision']])) :
                                    '1',
        'V_CH_Y_CURRENCY' 	    => 	isset($_POST[$wpbi_settings['parameter']['ch-y-currency']]) ?
                                    $_POST[$wpbi_settings['parameter']['ch-y-currency']] :
                                    "$",
		'CH_NEW_Y_LEGEND'			=> $wpbi_dialog['form']['label']['ch-y-legend'],
		'V_CH_Y_LEGEND'	=> $_POST[$wpbi_settings['parameter']['ch-y-legend']],
		'P_CH_Y_LEGEND' 	=> 	$wpbi_settings['parameter']['ch-y-legend'],
		'CH_NEW_Y_LEGEND_SIZE' 			=> $wpbi_dialog['form']['label']['ch-y-legend-size'],
		'P_CH_Y_LEGEND_SIZE' 	=> $wpbi_settings['parameter']['ch-y-legend-size'],
		'V_CH_Y_LEGEND_SIZE' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-legend-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-legend-size']])) :
									'15',
		'CH_NEW_Y_LABEL_SIZE' 			=> $wpbi_dialog['form']['label']['ch-y-label-size'],
		'P_CH_Y_LABEL_SIZE' 	=> $wpbi_settings['parameter']['ch-y-label-size'],
		'V_CH_Y_LABEL_SIZE' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-label-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-label-size']])) :
									'10',
		'CH_NEW_Y_LABEL_ROTATION' 			=> $wpbi_dialog['form']['label']['ch-y-label-rotation'],
		'P_CH_Y_LABEL_ROTATION' 	=> $wpbi_settings['parameter']['ch-y-label-rotation'],
		'V_CH_Y_LABEL_ROTATION' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-label-rotation']])) :
									'0',
		'CH_NEW_Y_LABEL_COLOR' 			=> $wpbi_dialog['form']['label']['ch-y-label-color'],
		'P_CH_Y_LABEL_COLOR'			=> $wpbi_settings['parameter']['ch-y-label-color'],
		'V_CH_Y_LABEL_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-label-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-y-label-color']] :
									'#000000',
		'CH_NEW_Y_LEGEND_COLOR' 			=> $wpbi_dialog['form']['label']['ch-y-legend-color'],
		'P_CH_Y_LEGEND_COLOR'			=> $wpbi_settings['parameter']['ch-y-legend-color'],
		'V_CH_Y_LEGEND_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-legend-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-y-legend-color']] :
									'#000000',
		'CH_NEW_Y_AXIS_COLOR' 			=> $wpbi_dialog['form']['label']['ch-y-axis-color'],
		'P_CH_Y_AXIS_COLOR'			=> $wpbi_settings['parameter']['ch-y-axis-color'],
		'V_CH_Y_AXIS_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-axis-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-y-axis-color']] :
									'#DAD5E0',
		'CH_NEW_Y_GRID_COLOR' 			=> $wpbi_dialog['form']['label']['ch-y-grid-color'],
		'P_CH_Y_GRID_COLOR'			=> $wpbi_settings['parameter']['ch-y-grid-color'],
		'V_CH_Y_GRID_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-y-grid-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-y-grid-color']] :
									'#DAD5E0',
		'CH_NEW_Y_GRID_STEP' 			=> $wpbi_dialog['form']['label']['ch-y-grid-step'],
		'P_CH_Y_GRID_STEP' 	=> $wpbi_settings['parameter']['ch-y-grid-step'],
		'V_CH_Y_GRID_STEP' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-grid-step']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-grid-step']])) :
									'15',
		'CH_NEW_Y_AXIS_THICK' 			=> $wpbi_dialog['form']['label']['ch-y-axis-thick'],
		'P_CH_Y_AXIS_THICK' 	=> $wpbi_settings['parameter']['ch-y-axis-thick'],
		'V_CH_Y_AXIS_THICK' 		=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-y-axis-thick']])) :
									'2',
									
		'CH_NEW_BGCOLOR' 		=> $wpbi_dialog['form']['label']['chart-bgcolor'],
		
		'CH_NEW_TITLE' 			=> $wpbi_dialog['form']['label']['chart-title'],
		'P_CH_TITLE' 			=> $wpbi_settings['parameter']['ch-title'],
		'V_CH_TITLE' 			=> $_POST[$wpbi_settings['parameter']['ch-title']],
		
		'CH_NEW_TITLE_COLOR' 			=> $wpbi_dialog['form']['label']['chart-title-color'],
		'P_CH_TITLE_COLOR' 			=> $wpbi_settings['parameter']['ch-title-color'],
		'V_CH_TITLE_COLOR' 			=> 	isset($_POST[$wpbi_settings['parameter']['ch-title-color']]) ?
									$_POST[$wpbi_settings['parameter']['ch-title-color']] :
									'#000000',
		
		'CH_NEW_TITLE_SIZE' 			=> $wpbi_dialog['form']['label']['chart-title-size'],
		'P_CH_TITLE_SIZE' 			=> $wpbi_settings['parameter']['ch-title-size'],
		'V_CH_TITLE_SIZE' 			=> 	is_numeric($_POST[$wpbi_settings['parameter']['ch-title-size']]) ?
									abs(intval($_POST[$wpbi_settings['parameter']['ch-title-size']])) :
									'10',
		
		'CH_NEW_TYPE' 			=> $wpbi_dialog['form']['label']['chart-type'],
		'SELECTED_'.$_POST[$wpbi_settings['parameter']['ch-type']]						=> 'selected',
		'P_CH_TYPE'			=> $wpbi_settings['parameter']['ch-type'] ,
		'CH_NEW_HEADER' 		=> $wpbi_dialog['form']['label']['table-header'],
		'P_CH_HEADER' 			=> $wpbi_settings['parameter']['tb-header'],
		'V_CH_HEADER' 			=> $_POST[$wpbi_settings['parameter']['tb-header']],
		'V_CH_HEADER_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['tb-header']]) ? 'checked' : '',
		'CH_NEW_FOOTER' 		=> $wpbi_dialog['form']['label']['table-footer'],
		'P_CH_FOOTER'			=> $wpbi_settings['parameter']['tb-footer'],
		'V_CH_FOOTER'			=> $_POST[$wpbi_settings['parameter']['tb-header']],
		'V_CH_FOOTER_CHECKED'	=> isset($_POST[$wpbi_settings['parameter']['tb-footer']]) ? 'checked' : '',
		'CH_NEW_ROWS_PER_PG' 	=> $wpbi_dialog['form']['label']['table-rows-pg']	,
		'P_CH_ROWS_PER_PG' 		=> $wpbi_settings['parameter']['tb-row-pg'],
		'V_CH_ROWS_PER_PG' 		=> is_numeric($_POST[$wpbi_settings['parameter']['tb-row-pg']]) ? abs(intval($_POST[$wpbi_settings['parameter']['tb-row-pg']])) : $wpbi_settings['parameter']['page-interval'],
		'CH_NEW_COLUMNS' 		=> $wpbi_dialog['form']['label']['chart-col'],
		'CH_NEW_COL_VALUE' 		=> $wpbi_dialog['form']['label']['chart-col-value'],
		'CH_NEW_COL_LABEL' 			=> $wpbi_dialog['form']['label']['chart-col-label'],
		'CH_NEW_COL_COLOR' 			=> $wpbi_dialog['form']['label']['chart-col-color'],
		'CH_NEW_COL_RENAME' 		=> $wpbi_dialog['form']['label']['chart-col-rename'],
        'CH_NEW_COL_ISTIME' 		=> $wpbi_dialog['form']['label']['chart-col-istime'],
		'LBL_BTN_ADD' 			=> $wpbi_dialog['button']['label']['save'],
		'LBL_BTN_TEST' 			=> $wpbi_dialog['button']['label']['test'],
		'P_CH_QY' 				=> $wpbi_settings['parameter']['qy_id'],
		'V_CH_QY' 				=> $_POST[$wpbi_settings['parameter']['qy_id']],
		'P_CH_ACTION' 			=> $wpbi_settings['parameter']['action'],
		'V_ADD_ACTION' 			=> $wpbi_settings['value']['add'],
		'V_TEST_ACTION' 		=> $wpbi_settings['value']['test'],
		'CH_TEST_RESULT'		=> $test_output,
		'CH_NEW_STYLE_DEFAULT_OPT' => $wpbi_dialog['form']['option']['table-style-default'],
		'CH_NEW_TYPE_LINE' 			=> $wpbi_dialog['charts']['type']['line'],
		'CH_NEW_TYPE_LINE_AREA' 			=> $wpbi_dialog['charts']['type']['line-area'],
		'CH_NEW_TYPE_BAR' 			=> $wpbi_dialog['charts']['type']['bar'],
		'CH_NEW_TYPE_BAR_FILLED' 			=> $wpbi_dialog['charts']['type']['bar-filled'],
		'CH_NEW_TYPE_BAR_GLASS' 			=> $wpbi_dialog['charts']['type']['bar-glass'],
		'CH_NEW_TYPE_BAR_3D' 			=> $wpbi_dialog['charts']['type']['bar-3d'],
		'CH_NEW_TYPE_BAR_SKETCH' 			=> $wpbi_dialog['charts']['type']['bar-sketch'],
		'CH_NEW_TYPE_BAR_CYLINDER' 			=> $wpbi_dialog['charts']['type']['bar-cylinder'],
		'CH_NEW_TYPE_BAR_CYLINDER_OUTLINE' 			=> $wpbi_dialog['charts']['type']['bar-cylinder-outline'],
		'CH_NEW_TYPE_BAR_ROUNDED_GLASS' 			=> $wpbi_dialog['charts']['type']['bar-rounded-glass'],
		'CH_NEW_TYPE_BAR_DOME' 			=> $wpbi_dialog['charts']['type']['bar-dome'],
		//'CH_NEW_TYPE_BAR_ROUND_3D' 			=> $wpbi_dialog['charts']['type']['bar-round-3d'],
		'CH_NEW_TYPE_BAR_HORIZONTAL' 			=> $wpbi_dialog['charts']['type']['bar-horizontal'],
		'CH_NEW_TYPE_BAR_STACKED' 			=> $wpbi_dialog['charts']['type']['bar-stacked'],
		//'CH_NEW_TYPE_CANDLE' 			=> $wpbi_dialog['charts']['type']['candle'],
		'CH_NEW_TYPE_PIE' 			=> $wpbi_dialog['charts']['type']['pie'],
        'CH_NEW_TYPE_DONUT' 			=> $wpbi_dialog['charts']['type']['donut'],
		'CH_NEW_TYPE_SCATTER' 			=> $wpbi_dialog['charts']['type']['scatter'],
		'CH_NEW_TYPE_SCATTER_LINE' 			=> $wpbi_dialog['charts']['type']['scatter-line'],
        'CH_NEW_TYPE_CUMULATIVE_LINE' 			=> $wpbi_dialog['charts']['type']['cumulative-line'],
        'CH_NEW_TYPE_LINE_AND_BAR' 			=> $wpbi_dialog['charts']['type']['line-and-bar'],
        'CH_NEW_TYPE_MULTI_LINE_FOCUS' 			=> $wpbi_dialog['charts']['type']['multi-line-focus'],
        'CH_NEW_TYPE_STACKED_AREA' 			=> $wpbi_dialog['charts']['type']['stacked-area'],
		'CH_NEW_TYPE_RADAR' 			=> $wpbi_dialog['charts']['type']['radar'],
		'CH_NEW_COLUMNS_OPTIONS'=> $columns_html,
		'CH_NEW_CHART_TEST' => $test_chart_output
	
		));
		
		//Store output
		ob_start();
		$template_site->pparse('charts-new-2');
		$set_output = ob_get_contents();
		ob_end_clean();
	} //End set action
	
	//Parse tpl
	$template_site->pparse('header');
	$template_site->pparse('charts-new-1');
	echo $set_output;
	
	//To be displayed only when the user is not testing a new chart
	if($_POST[$wpbi_settings['parameter']['action']] != 'test') {
	
		//Get saved queries
		$wpbi_chart = new chart();       

		$qy_charts = "
			SELECT `CHART_ID`, 
			`CHART_NAME`, 
			case
			WHEN CHART_TYPE = ".chart::BAR." 					THEN '".$wpbi_dialog['charts']['type']['bar']."'
			WHEN CHART_TYPE = ".chart::BAR_FILLED." 				THEN '".$wpbi_dialog['charts']['type']['bar-filled']."'
			WHEN CHART_TYPE = ".chart::BAR_GLASS." 				THEN '".$wpbi_dialog['charts']['type']['bar-glass']."'
			WHEN CHART_TYPE = ".chart::BAR_3D." 					THEN '".$wpbi_dialog['charts']['type']['bar-3d']."'
			WHEN CHART_TYPE = ".chart::BAR_SKETCH." 				THEN '".$wpbi_dialog['charts']['type']['bar-sketch']."'
			WHEN CHART_TYPE = ".chart::BAR_CYLINDER." 			THEN '".$wpbi_dialog['charts']['type']['bar-cylinder']."'
			WHEN CHART_TYPE = ".chart::BAR_CYLINDER_OUTLINE."	THEN '".$wpbi_dialog['charts']['type']['bar-cylinder-outline']."'
			WHEN CHART_TYPE = ".chart::BAR_ROUNDED_GLASS."		THEN '".$wpbi_dialog['charts']['type']['bar-rounded-glass']."'
			WHEN CHART_TYPE = ".chart::BAR_DOME." 				THEN '".$wpbi_dialog['charts']['type']['bar-dome']."'
			WHEN CHART_TYPE = ".chart::BAR_ROUND_3D." 			THEN '".$wpbi_dialog['charts']['type']['bar-round-3d']."'
			WHEN CHART_TYPE = ".chart::BAR_HORIZONTAL."			THEN '".$wpbi_dialog['charts']['type']['bar-horizontal']."'
			WHEN CHART_TYPE = ".chart::BAR_STACKED." 			THEN '".$wpbi_dialog['charts']['type']['bar-stacked']."'
			WHEN CHART_TYPE = ".chart::LINE ." 					THEN '".$wpbi_dialog['charts']['type']['line']."'
			WHEN CHART_TYPE = ".chart::LINE_AREA." 				THEN '".$wpbi_dialog['charts']['type']['line-area']."'
			WHEN CHART_TYPE = ".chart::PIE." 					THEN '".$wpbi_dialog['charts']['type']['pie']."'
			WHEN CHART_TYPE = ".chart::DONUT." 					THEN '".$wpbi_dialog['charts']['type']['donut']."'
			WHEN CHART_TYPE = ".chart::RADAR." 					THEN '".$wpbi_dialog['charts']['type']['radar']."'
			WHEN CHART_TYPE = ".chart::SCATTER." 				THEN '".$wpbi_dialog['charts']['type']['scatter']."'
			WHEN CHART_TYPE = ".chart::SCATTER_LINE." 			THEN '".$wpbi_dialog['charts']['type']['scatter-line']."'
			WHEN CHART_TYPE = ".chart::CUMULATIVE_LINE."    	THEN '".$wpbi_dialog['charts']['type']['cumulative-line']."'
			WHEN CHART_TYPE = ".chart::LINE_AND_BAR."       	THEN '".$wpbi_dialog['charts']['type']['line-and-bar']."'
			WHEN CHART_TYPE = ".chart::MULTI_LINE_FOCUS."    	THEN '".$wpbi_dialog['charts']['type']['multi-line-focus']."'
			WHEN CHART_TYPE = ".chart::STACKED_AREA." 			THEN '".$wpbi_dialog['charts']['type']['stacked-area']."'
			ELSE 'Unknown'
			END CHART_TYPE, 
			`QUERY_NAME`, 
			`QUERY_STATEMENT` 
			FROM `".$wpbi_sql['tname']['charts']."`, `".$wpbi_sql['tname']['queries']."`
			WHERE `".$wpbi_sql['tname']['charts']."`.`QUERY_ID` = `".$wpbi_sql['tname']['queries']."`.`QUERY_ID`
			ORDER BY CHART_NAME ASC";
		$query = new query($qy_charts, $wpdb, $wpbi_sql['tname']['vars']);
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
		$qy_charts_rows = $wpdb->get_results($query->limit_qy_to($pagination->item_start-1, $pagination->pg_interval),'ARRAY_N');
		
		//Output table
		$column_headers = array($wpbi_dialog['header']['charts']['name'],$wpbi_dialog['header']['charts']['type'] ,$wpbi_dialog['header']['charts']['query'],$wpbi_dialog['header']['queries']['statement']);
		$single_actions = array ( 	"edit"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['edit'],
		                                   				"page" 		=> $wpbi_url['slug']['charts'],
		                                   				"action" 	=> $wpbi_settings['value']['edit'],
														"parameter"	=> $wpbi_settings['parameter']['ch-id']
		                                    			),
									"copy"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['copy'],
		                                   				"page" 		=> $wpbi_url['slug']['charts'],
		                                   				"action" 	=> $wpbi_settings['value']['copy'],
														"parameter"	=> $wpbi_settings['parameter']['ch-id']
		                                    			),
									"test"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['test'],
		                                   				"page" 		=> $wpbi_url['slug']['charts'],
		                                   				"action" 	=> $wpbi_settings['value']['test'],
														"parameter"	=> $wpbi_settings['parameter']['ch-id']
		                                    			),
									"drop"  => array ( 	"label" 	=> $wpbi_dialog['action']['label']['drop'],
		                                   				"page" 		=> $wpbi_url['slug']['charts'],
		                                   				"action" 	=> $wpbi_settings['value']['drop'],
														"parameter"	=> $wpbi_settings['parameter']['ch-id']
		                                    			)
		               			);
		$global_actions = array ( 	"drop"  => array ( 	"label" 	=> $wpbi_dialog['button']['label']['drop'],
		                                   				"value" 	=> $wpbi_settings['value']['drop']
		                                    			)
		               			);
		$table_form = new table_form();
		$table_form->set_css_class('widefat post fixed');
		$table_form->set_rows($qy_charts_rows);
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
			
	} // END Condition of user testing new chart
	
	
	//Print footer
	$template_site->pparse('footer');

} //End condition to display the new table form

?>