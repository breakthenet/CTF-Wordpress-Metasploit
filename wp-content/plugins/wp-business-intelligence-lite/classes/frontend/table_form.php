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


class table_form {

var $cols;
var $rows;
var $css_class;
var $has_header = false;
var $has_footer = false;
var $encode_html = false;
var $form_action;
var $form_id;
var $form_method;
var $gobal_checkbox_id;
var $single_actions = array();
var $global_actions = array();
var $action_param_name = 'action';
var $checkbox_id = 'post';

function table_form(){

}

function set_checkbox_id($checkbox_id){
	$this->checkbox_id = $checkbox_id;
}

function set_action_param_name($action_param_name){
	$this->action_param_name = $action_param_name;
}

function set_global_actions($global_actions){
	$this->global_actions = $global_actions;
}

function set_single_actions($single_actions){
	$this->single_actions = $single_actions;
}

function set_gobal_checkbox_id($gobal_checkbox_id){
	$this->gobal_checkbox_id = $gobal_checkbox_id;
}

function set_form_action($form_action){
	$this->form_action = $form_action;
}

function set_form_id($form_id){
	$this->form_id = $form_id;
}

function set_form_method($form_method){
	$this->form_method = $form_method;
}

function has_header($has_header){
	$this->has_header = $has_header;
}

function has_footer($has_footer){
	$this->has_footer = $has_footer;
}

function encode_html($encode_html){
	$this->encode_html = $encode_html;
}

function set_cols($cols){
	$this->cols = $cols;
}

function set_css_class($css_class){
	$this->css_class = $css_class;
}

function set_rows($rows){
	$this->rows = $rows;
}

//The first column has to be a unique ID; The second column a significant name for the record itself
function get_html(){
	$html = '<form method="'.$this->form_method.'" id="'.$this->form_id.'" action="'.$this->form_action.'">';
	$html = $html.'<table class="'.$this->css_class.'"  cellspacing="0">';
	
	//Header
	if(isset($this->cols) && $this->has_header){
		$html = $html.'			
			<thead>
				<tr>
					<th width="50">
						<input type="checkbox" id="header_'.$this->gobal_checkbox_id.'" name="header_'.$this->gobal_checkbox_id.'" onclick="jQuery(\'input[type=checkbox]\').attr(\'checked\', jQuery(\'#header_'.$this->gobal_checkbox_id.'\').is(\':checked\')) "/></th>
			';
		foreach($this->cols as $col){
			$html = $html. '<th>'.($col).'</th>';
		}
		$html = $html. '
			</tr>
		</thead>
		';
	}
	
	//Footer
	if(isset($this->cols) && $this->has_footer){
		$html = $html.'			
			<tfoot>
				<tr>
					<th width="50">
			    		<input type="checkbox" id="footer_'.$this->gobal_checkbox_id.'" name="footer_'.$this->gobal_checkbox_id.'" onclick="jQuery(\'input[type=checkbox]\').attr(\'checked\', jQuery(\'#footer_'.$this->gobal_checkbox_id.'\').is(\':checked\')) "/></th>
			';
		foreach($this->cols as $col){
			$html = $html. '<th>'.($col).'</th>';
		}
		$html = $html. '
			</tr>
		</tfoot>
		';
	}
	
	//body
	$html = $html. '<tbody>';		
		foreach($this->rows as $row){
				$html = $html. '<tr class="" valign="top">';
					for($col_idx=0; $col_idx < sizeof($row); $col_idx++){
						$value = $row[$col_idx];
						if($this->encode_html){
							$value = htmlentities($row[$col_idx]);
						}
						if($col_idx==0){
							$html = $html. '<th><input type="checkbox" name="'.$this->checkbox_id.'[]" value="'.$value.'"></th>';
						}
						else if($col_idx==1){
							$html = $html. '
							<td>
								<div class="row-title"><a>'.$value.'</a></div>';
								$html = $html. '<div class="row-actions">';
									foreach($this->single_actions as $single_action){
										$html = $html. '<span class="'.$single_action['action'].'"><a href="?page='.$single_action['page'].'&'.$this->action_param_name.'='.$single_action['action'].'&'.$single_action['parameter'].'='.$row[0].'">'.$single_action['label'].'</a></span> | ';
									}
								if(sizeof($this->single_actions)>0){
									$html = substr($html,0,strlen($html)-2); //delete last pipe
								}
							$html = $html. '</div>';								
							$html = $html. '</td>';
						}
						else{
							$html = $html. '<td>'.$value.'</td>';
						}
					}
				$html = $html. '</tr>';
		}		
		
	$html = $html. '</tbody>';
	$html = $html. '</table>';
	$html = $html. '
	<p class="submit">
	<input type="hidden" id="'.$this->action_param_name.'" name="'.$this->action_param_name.'" value="">';
	foreach($this->global_actions as $global_action){
		$html = $html. '<input type="submit" class="button-primary" value="'.$global_action['label'].'" onmousedown="jQuery(\'input[name='.$this->action_param_name.']\').attr(\'value\', \''.$global_action['value'].'\')" />';
	}
	$html = $html. '
	</p>
	</form>
	';
	
	return $html;
}

}


?>
