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


class vo_chart{

var $chart_id;
var $query_id;
var $chart_key;
var $chart_name;
var $chart_type;
var $chart_title;
var $chart_title_size;
var $chart_title_color;
var $chart_bg_color;
var $chart_width;
var $chart_width_percent;
var $chart_tooltip;
var $chart_height;
var $chart_height_percent;
var $chart_x_color;
var $chart_x_thickness;
var $chart_x_grid_color;
var $chart_x_grid_lines;
var $chart_x_labels_color;
var $chart_x_labels_size;
var $chart_x_labels_rotation;
var $chart_x_legend;
var $chart_x_legend_color;
var $chart_x_legend_size;
var $chart_x_axis_precision;
var $chart_y_axis_precision;
var $chart_y_axis_currency;
var $chart_y_color;
var $chart_y_thickness;
var $chart_y_grid_color;
var $chart_y_grid_lines;
var $chart_y_labels_color;
var $chart_y_labels_size;
var $chart_y_labels_rotation;
var $chart_y_legend;
var $chart_y_legend_color;
var $chart_y_legend_size;

function vo_chart($chart_id=NULL, $query_id=NULL, $chart_key=NULL, $chart_name=NULL, $chart_type=NULL, $chart_title=NULL, $chart_title_size=NULL, $chart_title_color=NULL, $chart_bg_color=NULL, $chart_width=NULL,$chart_width_percent=NULL, $chart_height=NULL, $chart_height_percent=NULL, $chart_x_color=NULL, $chart_x_precision=NULL, $chart_x_thickness=NULL, $chart_x_grid_color=NULL, $chart_x_grid_lines=NULL, $chart_x_labels_color=NULL, $chart_x_labels_size=NULL, $chart_x_labels_rotation=NULL, $chart_x_legend=NULL, $chart_x_legend_color=NULL, $chart_x_legend_size=NULL, $chart_y_color=NULL, $chart_y_precision=NULL, $chart_y_currency=NULL, $chart_y_thickness=NULL, $chart_y_grid_color=NULL, $chart_y_grid_lines=NULL, $chart_y_labels_color=NULL, $chart_y_labels_size=NULL, $chart_y_labels_rotation=NULL, $chart_y_legend=NULL, $chart_y_legend_color=NULL, $chart_y_legend_size=NULL){

        $this->chart_id = $chart_id;
        $this->query_id = $query_id;
        $this->chart_key = $chart_key;
        $this->chart_name = $chart_name;
        $this->chart_type = $chart_type;
        $this->chart_title = $chart_title;
        $this->chart_title_size = $chart_title_size;
        $this->chart_title_color = $chart_title_color;
        $this->chart_bg_color = $chart_bg_color;
        $this->chart_width = $chart_width;
		$this->chart_width_percent = $chart_width_percent;
        $this->chart_height = $chart_height;
		$this->chart_height_percent = $chart_height_percent;
        $this->chart_x_color = $chart_x_color;
        $this->chart_x_axis_precision = $chart_x_precision;
        $this->chart_x_thickness = $chart_x_thickness;
        $this->chart_x_grid_color = $chart_x_grid_color;
        $this->chart_x_grid_lines = $chart_x_grid_lines;
        $this->chart_x_labels_color = $chart_x_labels_color;
        $this->chart_x_labels_size = $chart_x_labels_size;
        $this->chart_x_labels_rotation = $chart_x_labels_rotation;
        $this->chart_x_legend = $chart_x_legend;
        $this->chart_x_legend_color = $chart_x_legend_color;
        $this->chart_x_legend_size = $chart_x_legend_size;
        $this->chart_y_color = $chart_y_color;
        $this->chart_y_axis_precision = $chart_y_precision;
        $this->chart_y_axis_currency = $chart_y_currency;
        $this->chart_y_thickness = $chart_y_thickness;
        $this->chart_y_grid_color = $chart_y_grid_color;
        $this->chart_y_grid_lines = $chart_y_grid_lines;
        $this->chart_y_labels_color = $chart_y_labels_color;
        $this->chart_y_labels_size = $chart_y_labels_size;
        $this->chart_y_labels_rotation = $chart_y_labels_rotation;
        $this->chart_y_legend = $chart_y_legend;
        $this->chart_y_legend_color = $chart_y_legend_color;
        $this->chart_y_legend_size = $chart_y_legend_size;

}

function set_chart_id($chart_id){$this->chart_id = $chart_id;}

function set_query_id($query_id){$this->query_id = $query_id;}

function set_chart_key($chart_key){$this->chart_key = $chart_key;}

function set_chart_name($chart_name){$this->chart_name = $chart_name;}

function set_chart_type($chart_type){$this->chart_type = $chart_type;}

function set_chart_title($chart_title){$this->chart_title = $chart_title;}

function set_chart_title_size($chart_title_size = 10){$this->chart_title_size = $chart_title_size;}

function set_chart_title_color($chart_title_color = "#000000"){$this->chart_title_color = $chart_title_color;}

function set_chart_bg_color($chart_bg_color = "#000000"){$this->chart_bg_color = $chart_bg_color;}

function set_chart_width($chart_width = 400){$this->chart_width = $chart_width;}

function set_chart_width_percent($chart_width_percent = 0){$this->chart_width_percent = $chart_width_percent;}

function set_chart_height($chart_height = 400){$this->chart_height = $chart_height;}

function set_chart_height_percent($chart_height_percent = 0){$this->chart_height_percent = $chart_height_percent;}

function set_chart_x_precision($chart_x_precision = 1){$this->chart_x_axis_precision = $chart_x_precision;}

function set_chart_x_color($chart_x_color = "#DAD5E0"){$this->chart_x_color = $chart_x_color;}

function set_chart_x_thickness($chart_x_thickness){$this->chart_x_thickness = is_null($chart_x_thickness) ? 2 : $chart_x_thickness ;}

function set_chart_x_grid_color($chart_x_grid_color = "#DAD5E0"){$this->chart_x_grid_color = is_null($chart_x_grid_color) ? "#DAD5E0" : $chart_x_grid_color ;}

function set_chart_x_grid_lines($chart_x_grid_lines = 15){$this->chart_x_grid_lines = is_null($chart_x_grid_lines) ? 15 : $chart_x_grid_lines ;}

function set_chart_x_labels_color($chart_x_labels_color = "#000000"){$this->chart_x_labels_color = is_null($chart_x_labels_color) ? "#000000" : $chart_x_labels_color ;}

function set_chart_x_labels_size($chart_x_labels_size = 10){$this->chart_x_labels_size = is_null($chart_x_labels_size) ? 10 : $chart_x_labels_size ;}

function set_chart_x_labels_rotation($chart_x_labels_rotation = 30){$this->chart_x_labels_rotation = is_null($chart_x_labels_rotation) ? 30 : $chart_x_labels_rotation ;}

function set_chart_x_legend($chart_x_legend){$this->chart_x_legend = $chart_x_legend;}

function set_chart_x_legend_color($chart_x_legend_color = "#000000"){$this->chart_x_legend_color = is_null($chart_x_legend_color) ? "#000000" : $chart_x_legend_color ;}

function set_chart_x_legend_size($chart_x_legend_size = 15){$this->chart_x_legend_size = is_null($chart_x_legend_size) ? 15 : $chart_x_legend_size ;}

function set_chart_y_precision($chart_y_precision = 1){$this->chart_y_axis_precision = is_null($chart_y_precision) ? 1 : $chart_y_precision ;}

function set_chart_y_currency($chart_y_currency = '$'){$this->chart_y_axis_currency = is_null($chart_y_currency) ? '$' : $chart_y_currency ;}

function set_chart_y_color($chart_y_color = "#DAD5E0"){$this->chart_y_color = is_null($chart_y_color) ? "#DAD5E0" : $chart_y_color ;}

function set_chart_y_thickness($chart_y_thickness = 2){$this->chart_y_thickness = is_null($chart_y_thickness) ? 2 : $chart_y_thickness ;}

function set_chart_y_grid_color($chart_y_grid_color = "#DAD5E0"){$this->chart_y_grid_color = is_null($chart_y_grid_color) ? "#DAD5E0" : $chart_y_grid_color ;}

function set_chart_y_grid_lines($chart_y_grid_lines = 15){$this->chart_y_grid_lines = is_null($chart_y_grid_lines) ? 15 : $chart_y_grid_lines ;}

function set_chart_y_labels_color($chart_y_labels_color = "#000000"){$this->chart_y_labels_color = is_null($chart_y_labels_color) ? "#000000" : $chart_y_labels_color ;}

function set_chart_y_labels_size($chart_y_labels_size = 10){$this->chart_y_labels_size = is_null($chart_y_labels_size) ? 10 : $chart_y_labels_size ;}

function set_chart_y_labels_rotation($chart_y_labels_rotation = 0){$this->chart_y_labels_rotation = is_null($chart_y_labels_rotation) ? 0 : $chart_y_labels_rotation ;}

function set_chart_y_legend($chart_y_legend){$this->chart_y_legend = $chart_y_legend;}

function set_chart_y_legend_color($chart_y_legend_color ="#000000"){$this->chart_y_legend_color = is_null($chart_y_legend_color) ? "#000000" : $chart_y_legend_color ;}

function set_chart_y_legend_size($chart_y_legend_size = 15){$this->chart_y_legend_size = is_null($chart_y_legend_size) ? 15 : $chart_y_legend_size ;}

}

?>