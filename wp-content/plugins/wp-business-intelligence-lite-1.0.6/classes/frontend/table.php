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

class table {

var $cols;
var $rows;
var $css_class;
var $css_style;
var $has_header = false;
var $has_footer = false;
var $encode_html = false;
var $visible_cols = NULL;
var $title = NULL;
var $table_tpl_path = NULL;
var $table_pagination = NULL;

function table(){

}

function set_title($title){
	$this->title = $title;
}

function set_table_pagination($table_pagination){
	$this->table_pagination = $table_pagination;
}

function set_table_tpl_path($table_tpl_path){
	$this->table_tpl_path = $table_tpl_path;
	$this->tpl_table = new template_site();
	$this->tpl_table->set_filenames(array(
	'table' 			=> $this->table_tpl_path['root-path'].$table_tpl_path['table'],
	'table-title' 		=> $this->table_tpl_path['root-path'].$table_tpl_path['table-title'],
	'table-header' 		=> $this->table_tpl_path['root-path'].$table_tpl_path['table-header'],
	'table-footer' 		=> $this->table_tpl_path['root-path'].$table_tpl_path['table-footer'],
	'table-body-row' 		=> $this->table_tpl_path['root-path'].$table_tpl_path['table-body-row'],
	'table-body-row-col' 	=> $this->table_tpl_path['root-path'].$table_tpl_path['table-body-row-col']
	)
);
}

function set_visible_cols($visible_cols){
	$this->visible_cols = $visible_cols;
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

function set_css_style($css_style){
	$this->css_style = $css_style;
}

function set_rows($rows){
	$this->rows = $rows;
}

function get_html(){

    global $wpbi_url;

	//Title
	$title = '';
	if(!is_null($this->title) && strlen($this->title)!=0){
		ob_start();
	    $this->tpl_table->assign_vars(array('TABLE_TITLE_TEXT'	=> $this->title, 'TABLE_TITLE_STYLE'	=> $this->css_style.'-title'));
		$this->tpl_table->pparse('table-title');
	    $output = ob_get_contents();
	    ob_end_clean();
		$title = $output;
	}
			
	//Header
	$table_header = '';
	$col_idx = 0;
	if(isset($this->cols) && $this->has_header){
		foreach($this->cols as $col){
			if(is_null($this->visible_cols) || in_array($col_idx, $this->visible_cols)){
				ob_start();
			    $this->tpl_table->assign_vars(array('TABLE_HEADER_COLUMN_NAME'	=> $col));
				$this->tpl_table->pparse('table-header');
			    $output = ob_get_contents();
			    ob_end_clean();
				$table_header = $table_header.$output;
			}
			$col_idx++;
		}
	}
	
	//Footer
	$table_footer = '';
	$col_idx = 0;
	if(isset($this->cols) && $this->has_footer){
		foreach($this->cols as $col){
			if(is_null($this->visible_cols) || in_array($col_idx, $this->visible_cols)){
				ob_start();
			    $this->tpl_table->assign_vars(array('TABLE_FOOTER_COLUMN_NAME'	=> $col));
				$this->tpl_table->pparse('table-footer');
			    $output = ob_get_contents();
			    ob_end_clean();
				$table_footer = $table_footer.$output;
			}
			$col_idx++;
		}
	}
	
	//body
	$table_body = '';	
	$table_body_row = '';
	$table_body_row_col = '';	
		foreach($this->rows as $row){
					for($col_idx=0; $col_idx < sizeof($row); $col_idx++){
						if(is_null($this->visible_cols) || in_array($col_idx, $this->visible_cols)){	    
							$value = $row[$col_idx];
							if($this->encode_html){
								$value = htmlentities($row[$col_idx]);
							}
							ob_start();
						    $this->tpl_table->assign_vars(array('TABLE_BODY_ROW_COL'	=> $value));
							$this->tpl_table->pparse('table-body-row-col');
							$output = ob_get_contents();
						    ob_end_clean();
							$table_body_row_col = $table_body_row_col.$output;
						}
					}
				ob_start();
			    $this->tpl_table->assign_vars(array('TABLE_BODY_ROW'	=> $table_body_row_col));
				$this->tpl_table->pparse('table-body-row');
				$output = ob_get_contents();
			    ob_end_clean();
				$table_body_row = $table_body_row.$output;
				$table_body_row_col = '';
		}

    wp_enqueue_script('datatables-jquery', $wpbi_url['datatables']['jquerymin'] );
	
	//Table
	ob_start();
	$this->tpl_table->assign_vars(array(
	'TABLE_TITLE'	=> $title,
	'TABLE_PAGINATION'	=> ($this->table_pagination == NULL) ? '' : $this->table_pagination,
	'TABLE_STYLE'	=> $this->css_style,
	'TABLE_CLASS'	=> $this->css_class,
	'TABLE_HEADER' 	=> $table_header,
	'TABLE_FOOTER' 	=> $table_footer,
	'TABLE_BODY' 	=> $table_body_row
	));
	$this->tpl_table->pparse('table');
	$output = ob_get_contents();
    ob_end_clean();
	
	return $output;
}

}


?>
