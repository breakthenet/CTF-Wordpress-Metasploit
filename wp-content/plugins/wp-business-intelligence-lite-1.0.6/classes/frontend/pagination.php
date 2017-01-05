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


class pagination {

var $pg_interval;
var $current_page;
var $item_start;
var $item_stop;
var $rows;
var $pagination_stats;
var $paginate_links;
var $css_class;
var $css_style;
var $css_th;
var $pg_parameter;
var $pagination_tpl_path = NULL;
var $strip_pagination_styles = true;
var $strip_pagination_links = false;

function pagination(){

}

function set_pagination_tpl_path($pagination_tpl_path){
	$this->pagination_tpl_path = $pagination_tpl_path;
	$this->tpl_pagination = new template_site();
	$this->tpl_pagination->set_filenames(array(
	'table-pagination'	=> $this->pagination_tpl_path['root-path'].$pagination_tpl_path['table-pagination']
	)
);
}

function set_pg_interval($pg_interval){
	$this->pg_interval = $pg_interval;
}

function set_strip_pagination_styles($strip_pagination_styles){
	$this->strip_pagination_styles = $strip_pagination_styles;
}

function set_strip_pagination_links($strip_pagination_links){
	$this->strip_pagination_links = $strip_pagination_links;
}

function set_pg_parameter($pg_parameter){
	$this->pg_parameter = $pg_parameter;
}

function set_css_class($css_class){
	$this->css_class = $css_class;
	$this->css_th = 'text-align:right';
}

function set_css_style($css_style){
	$this->css_style = $css_style.'-pagination';
}

function set_paginate_links($paginate_links){
	$this->paginate_links = $paginate_links;
	
	/**** Remove tag attributes to allow custom style definition ****/
	if($this->strip_pagination_styles){
		//$this->paginate_links = preg_replace('#class\=(.+?)\"#s', $this->paginate_links);
		$this->paginate_links = preg_replace('/\s*class\s*=\s*(["\']).*?\1/', '',$this->paginate_links); 
	}
	
	/**** Remove links whenever the user is testing a new table or query ****/
	if($this->strip_pagination_links){
		//$this->paginate_links = preg_replace('#class\=(.+?)\"#s', $this->paginate_links);
		$this->paginate_links = preg_replace('/\s*href\s*=\s*(["\']).*?\1/', '',$this->paginate_links); 
	}
}

function set_pagination_stats($pagination_stats){
	$this->pagination_stats = $pagination_stats;
}

function set_current_page($current_page){
	$this->current_page = $current_page;
}

function set_rows($rows){
	$this->rows = $rows;
}

function initialize(){
	$this->item_start = ($this->pg_interval*$this->current_page)-$this->pg_interval+1;
	$this->item_stop = $this->pg_interval*$this->current_page+1;
}

function get_html(){
	$html = '';
	if(($this->rows)>($this->item_stop-1) || $this->item_start != 1){
		ob_start();
	    $this->tpl_pagination->assign_vars(array(	'TABLE_PAGINATION_STYLE'	=> $this->css_style,
												'TABLE_PAGINATION_CLASS'	=> $this->css_class,
												'TABLE_PAGINATION_TH'	=> $this->css_th,
											 	'TABLE_PAGINATION_STATS'	=> (sprintf($this->pagination_stats, 
																						$this->item_start, 
																						($this->item_stop-1), 
																						($this->rows))),
												'TABLE_PAGINATION_PAGES'	=> $this->paginate_links));
		$this->tpl_pagination->pparse('table-pagination');
	    $output = ob_get_contents();
	    ob_end_clean();
		$html = $output;
	}
	
	return $html;
}

}


?>
