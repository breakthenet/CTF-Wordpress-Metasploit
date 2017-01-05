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


class chart {

var $chart = NULL;
var $nvd3_chart = NULL;
var $width = 400;
var $height = 300;
var $title = '';
var $title_color = '#000000';
var $title_size = 10;
var $name = '';
var $tooltip = NULL;
var $x_axis = NULL;
var $y_axis = NULL;
var $x_axis_precision = 1;
var $y_axis_precision = 1;
var $y_axis_currency = '$';
var $y_legend = NULL;
var $x_legend = NULL;
var $x_axis_labels = NULL;
var $x_axis_thickness = 2;
var $y_axis_thickness = 2;
var $x_axis_grid_color = '#DAD5E0';
var $x_axis_labels_size = 10;
var $x_axis_labels_color = '#000000';
var $y_axis_grid_color = '#DAD5E0';
var $y_axis_labels_color = '#000000';
var $y_axis_labels_size = 10;
var $x_axis_color = '#DAD5E0';
var $y_axis_color = '#DAD5E0';
var $y_axis_labels = NULL;
var $x_axis_labels_rotation = 30;
var $y_axis_labels_rotation = 0;
var $x_axis_min_val = NULL;
var $x_axis_max_val = NULL;
var $x_axis_step = NULL;
var $x_axis_step_percent = 15;
var $x_axis_istime = false;
var $y_axis_min_val = NULL;
var $y_axis_max_val = NULL;
var $y_axis_step = NULL;
var $y_axis_step_percent = 15;
var $bg_colour = NULL;
var $type = 1;
var $elements = array();
var $element_name_font_size = 10;

var $series;
var $options;
var $placeHolder;

//Chart types
const BAR					= 1;
const BAR_FILLED			= 2;
const BAR_GLASS				= 3;
const BAR_3D				= 4;
const BAR_SKETCH			= 5;
const BAR_CYLINDER			= 6;
const BAR_CYLINDER_OUTLINE	= 7;
const BAR_ROUNDED_GLASS		= 8;
const BAR_DOME				= 9;
const BAR_ROUND_3D			= 10;
const BAR_HORIZONTAL		= 11;
const BAR_STACKED			= 12;
const DONUT 				= 13;
const LINE 					= 14;
const LINE_AREA				= 15;
const PIE					= 16;
const RADAR					= 17;
const SCATTER				= 18;
const SCATTER_LINE			= 19;
const CUMULATIVE_LINE		= 20;
const STACKED_AREA  		= 21;
const MULTI_LINE_FOCUS 		= 22;
const LINE_AND_BAR   		= 23;


//Constructor
function chart(){
	$this->chart = new open_flash_chart();
    $this->nvd3_chart = new nvd3_chart();
	$this->x_axis = new x_axis();
	$this->y_axis = new y_axis();
}

//Build the chart
function build(){

	//set chart title
	$chart_title = new title($this->title);
	$chart_title->set_style('font-size:'.$this->title_size.'px; color:'.$this->title_color.';font-weight:bold;');
	$this->chart->set_title($chart_title);
	
	//set chart bg color
	$this->chart->set_bg_colour($this->bg_colour);
	
	//set chart legend
	$this->chart->set_y_legend( $this->y_legend );
	$this->chart->set_x_legend( $this->x_legend );
	
	//add elements to chart
	foreach ($this->elements as $key => $value){
		$this->chart->add_element($value);
	}

    $this->nvd3_chart->setPlaceholder($this);
    $this->nvd3_chart->create_dataseries($this);

    //Axis definition
	switch($this->type){
		case self::BAR_HORIZONTAL:			//Increase max value for better chart's look and feel
											//$this->x_axis_max_val += $this->x_axis_step;
											
											/*** X AXIS ***/
											$this->x_axis->set_colour( $this->x_axis_color );
											$this->x_axis->set_grid_colour( $this->x_axis_grid_color );
											$this->x_axis->set_stroke($this->x_axis_thickness);
											//If labels are defined
											if($this->x_axis_labels != NULL) {
												$this->x_axis->set_range( 0, sizeof($this->x_axis_labels->labels)-1);
												$this->x_axis->set_offset( false );
												$this->x_axis_labels->rotate($this->x_axis_labels_rotation);
												$this->x_axis->set_labels( $this->x_axis_labels );
												$this->chart->set_x_axis( $this->x_axis);
											} else{ //Set default labels
												//No labels will be added; it's a trick to give style to labels assigned with set_range.
												$this->x_axis_labels = new x_axis_labels();
												$this->x_axis_labels->set_colour($this->x_axis_labels_color);
												$this->x_axis_labels->set_size($this->x_axis_labels_size);
												$this->x_axis_labels->rotate($this->x_axis_labels_rotation);
												$this->x_axis->set_labels( $this->x_axis_labels );
												//End trick
												$this->x_axis->set_range(0, $this->x_axis_max_val); 
												$this->x_axis->set_steps($this->x_axis_step);
												$this->chart->set_x_axis( $this->x_axis);
											}
											
											/*** Y AXIS ***/
											$this->y_axis->set_stroke($this->y_axis_thickness);
											$this->y_axis->set_colour( $this->y_axis_color );
											$this->y_axis->set_grid_colour( $this->y_axis_grid_color );
											//If labels are defined
											if($this->y_axis_labels != NULL) {
												$this->y_axis->set_range( 0, sizeof($this->y_axis_labels->labels)-1);
												$this->y_axis->set_offset( true ); 
												//$this->y_axis_labels->rotate($this->y_axis_labels_rotation); //*******************
												$this->y_axis->set_labels( $this->y_axis_labels );
												$this->chart->set_y_axis( $this->y_axis);
											} else{ //Set default labels
												$this->y_axis->set_range(0, $this->y_axis_max_val-1);
												$this->y_axis->set_offset( true );
												$this->chart->set_y_axis( $this->y_axis);
												$this->	y_axis->set_range( ($this->y_axis_min_val < 0) ? 
														$this->y_axis_min_val : 0, 
														$this->y_axis_max_val, $this->y_axis_step);
												$this->chart->set_y_axis( $this->y_axis);
											}
											
											break;

        case self::DONUT:
        case self::PIE:						break;
		
		case self::RADAR:					//Increase max value for better chart's look and feel
											//$this->y_axis_max_val += $this->y_axis_step;
											
											/*** Y AXIS ***/
											//overwrite axis definition
											$this->y_axis = new radar_axis($this->y_axis_max_val);
											$this->y_axis->set_spoke_labels( $this->y_axis_labels );
											$this->y_axis->set_steps($this->y_axis_step);
											$this->y_axis->set_colour( $this->y_axis_color );
											$this->y_axis->set_grid_colour( $this->y_axis_grid_color );
											$this->chart->set_radar_axis( $this->y_axis);
											$this->y_axis->set_stroke($this->y_axis_thickness);
											
											break;
		
		default:							//Increase max value for better chart's look and feel
											//$this->y_axis_max_val += $this->y_axis_step;
											//$this->y_axis_max_val += $this->y_axis_step;
											
											/*** X AXIS ***/
											$this->x_axis->set_grid_colour( $this->x_axis_grid_color );
											$this->x_axis->set_colour( $this->x_axis_color );
											//thickness and offset
											switch($this->type){
												case self::LINE:					$this->x_axis->set_offset( false ); 
																					break;
                                                case self::STACKED_AREA:
												case self::LINE_AREA:				$this->x_axis->set_offset( false ); 
																					break;
												case self::BAR_3D:					$this->x_axis->set_3d($this->x_axis_thickness);
																					break;
												case self::BAR_CYLINDER:			$this->x_axis->set_3d($this->x_axis_thickness);
																					break;
												case self::BAR_CYLINDER_OUTLINE:	$this->x_axis->set_3d($this->x_axis_thickness);
																					break;
												case self::BAR_DOME:				$this->x_axis->set_3d($this->x_axis_thickness);
																					break;
												case self::BAR_ROUND_3D:			$this->x_axis->set_3d($this->x_axis_thickness);
																					break;
												default: 							$this->x_axis->set_stroke($this->x_axis_thickness);
																					break;
											}
											
											//If labels are defined
											$this->x_axis->set_colour( $this->x_axis_color );
											if($this->x_axis_labels != NULL) {
												$this->x_axis_labels->rotate($this->x_axis_labels_rotation);
												$this->x_axis->set_labels( $this->x_axis_labels );
												$this->chart->set_x_axis( $this->x_axis);
											} else{ //Set default labels
												//No labels will be added; it's a trick to give style to labels assigned with set_range.
												$this->x_axis_labels = new x_axis_labels();
												$this->x_axis_labels->set_colour($this->x_axis_labels_color);
												$this->x_axis_labels->set_size($this->x_axis_labels_size);
												$this->x_axis_labels->rotate($this->x_axis_labels_rotation);
												$this->x_axis->set_labels( $this->x_axis_labels );
												//End trick
												$this->chart->set_x_axis( $this->x_axis);
											}
											
											/*** Y AXIS ***/
											$this->y_axis->set_stroke($this->y_axis_thickness);
											$this->y_axis->set_colour( $this->y_axis_color );
											$this->y_axis->set_grid_colour( $this->y_axis_grid_color );
											//If labels are defined
											if($this->y_axis_labels != NULL) {
												$this->y_axis->set_labels( $this->y_axis_labels );
												$this->chart->set_y_axis( $this->y_axis);
											} else{ //Set default labels
												//No labels will be added; it's a trick to give style to labels assigned with set_range.
												$this->y_axis_labels = new y_axis_labels();
												$this->y_axis_labels->set_colour($this->y_axis_labels_color);
												$this->y_axis_labels->set_size($this->y_axis_labels_size);
												$this->y_axis_labels->rotate($this->y_axis_labels_rotation);
												$this->y_axis->set_labels( $this->y_axis_labels );
												//End trick
												$this->	y_axis->set_range( ($this->y_axis_min_val < 0) ? 
														$this->y_axis_min_val : 0, 
														$this->y_axis_max_val, $this->y_axis_step);
												$this->chart->set_y_axis( $this->y_axis);
											}
											
											break;
	}


	
}


//Crate a new element basing on chart type (e.g. one or more line in the chart) 
//$name is a identifier for the element
function create_element($name, $values){
	switch($this->type){
        case self::CUMULATIVE_LINE:
        case self::MULTI_LINE_FOCUS:
        case self::LINE:					$this->elements[$name] = new line();
											break;
        case self::STACKED_AREA:
        case self::LINE_AREA:				$this->elements[$name] = new area();
											break;
		case self::BAR:						$this->elements[$name] = new bar();
											break;
		case self::BAR_FILLED:				$this->elements[$name] = new bar_filled();
											break;
		case self::BAR_GLASS:				$this->elements[$name] = new bar_glass();
											break;
		case self::BAR_3D:					$this->elements[$name] = new bar_3d();
											break;
		case self::BAR_SKETCH:				$this->elements[$name] = new bar_sketch('#81AC00', '#567300', 5);
											break;
		case self::BAR_CYLINDER:			$this->elements[$name] = new bar_cylinder();
											break;
		case self::BAR_CYLINDER_OUTLINE:	$this->elements[$name] = new bar_cylinder_outline();
											break;
		case self::BAR_ROUNDED_GLASS:		$this->elements[$name] = new bar_rounded_glass();
											break;
		case self::BAR_DOME:				$this->elements[$name] = new bar_dome();
											break;
		case self::BAR_ROUND_3D:			$this->elements[$name] = new bar_round3d();
											break;
		case self::BAR_HORIZONTAL:			$this->elements[$name] = new hbar();
											break;
		case self::BAR_STACKED:				if(!isset($this->elements[$name])){
												$this->elements[$name] = new bar_stack();
											}
											break;
		case self::DONUT:
		case self::PIE:						$this->elements[$name] = new pie();
											//hide labels if none (otherwise it shows values)
											if($this->x_axis_labels == NULL) {
												$this->elements[$name]->set_no_labels();
											}
											break;
		case self::SCATTER:					$this->elements[$name] = new scatter('#FFD600', 10);
											break;
		case self::SCATTER_LINE:			$this->elements[$name] = new scatter_line('#DB1750', 3 );
											break;
		case self::RADAR:					$this->elements[$name] = new line();
											$this->elements[$name]->loop();
											break;
		default:							$this->elements[$name] = new line();
											break;
	}
	
	//set tooltip
	if($this->tooltip != NULL){
		$this->elements[$name]->set_tooltip( $this->tooltip );
	}
	
	//Set Values
	switch($this->type){
		case self::BAR_STACKED:		//assign array data
									$this->elements[$name]->append_stack( $values );
									break;

        case self::DONUT:
		case self::PIE:				//assign array data
									$this->elements[$name]->set_values($values);
									break;
									
		case self::BAR_HORIZONTAL:	$this->x_axis_max_val = ($this->x_axis_max_val > max($values)) ? $this->x_axis_max_val : max($values);
		
		default:					//Set legend
									$this->elements[$name]->set_key( $name, $this->element_name_font_size );
									//assign array data
									$this->elements[$name]->set_values($values);
									break;
	}
	
	/*** Set axis range	 ***/
	// X AXIS Min value
	if($this->x_axis_min_val == NULL){ //First initialization
		$this->x_axis_min_val = min($values);	
	} else{ //update the value
		$this->x_axis_min_val = ($this->x_axis_min_val <=  min($values)) ? $this->x_axis_min_val : min($values);
	}
	// Y AXIS Min value
	if($this->y_axis_min_val == NULL){ //First initialization
		$this->y_axis_min_val = min($values);	
	} else{ //update the value
		$this->y_axis_min_val = ($this->y_axis_min_val <=  min($values)) ? $this->y_axis_min_val : min($values);
	}	
	// Y AXIS Max value
	switch($this->type){
		case self::BAR_STACKED:		if($this->y_axis_max_val == NULL){
										$this->y_axis_max_val = array_sum($values);	
									} else{ //update the value			
										$this->y_axis_max_val = ($this->y_axis_max_val >=  array_sum($values)) ? $this->y_axis_max_val : array_sum($values);
									}
									break;
									
		case self::BAR_HORIZONTAL:	if($this->y_axis_max_val == NULL){
										$this->y_axis_max_val = sizeof($values);	
									} else{ //update the value			
										$this->y_axis_max_val = sizeof($values);
									}
									break;
		
		default:					if($this->y_axis_max_val == NULL){
										$this->y_axis_max_val = max($values);	
									} else{ //update the value			
										$this->y_axis_max_val = ($this->y_axis_max_val >=  max($values)) ? $this->y_axis_max_val : max($values);
									}
									break;
	}
	
	//steps
    if(isset($this->x_axis_max_val))
    {
        if(!is_numeric($this->y_axis_max_val))
        {
            $this->y_axis_step = intval((($this->y_axis_max_val["value"] - $this->y_axis_min_val["value"])*$this->y_axis_step_percent)/100);
        }
        else
        {
            $this->y_axis_step = intval((($this->y_axis_max_val - $this->y_axis_min_val)*$this->y_axis_step_percent)/100);
        }
    }

    if(isset($this->x_axis_max_val))
    {
        if( !is_numeric($this->x_axis_max_val))
        {
            $this->x_axis_step = intval((($this->x_axis_max_val["value"] - $this->x_axis_min_val["value"])*$this->x_axis_step_percent)/100);
        }
        else
        {
            $this->x_axis_step = intval((($this->x_axis_max_val - $this->x_axis_min_val)*$this->x_axis_step_percent)/100);
        }
    }
	
	return $this->elements[$name];
}

//Set chart element_name_font_size 
function set_element_name_font_size($element_name_font_size){
	if(is_numeric($element_name_font_size)){ //If it's a valid format
		$element_name_font_size = (intval($element_name_font_size));
	} else{ //If not, set the default value
		$element_name_font_size = $this->element_name_font_size;
	}
	$this->element_name_font_size = $element_name_font_size;
}

//Set chart X label rotation 
function set_x_axis_labels_rotation($x_axis_labels_rotation){
	if(is_numeric($this->x_axis_labels_rotation)){
		$this->x_axis_labels_rotation = intval($x_axis_labels_rotation);
	}
}

//Set chart Y label rotation 
function set_y_axis_labels_rotation($y_axis_labels_rotation){
	if(is_numeric($this->y_axis_labels_rotation)){
		$this->y_axis_labels_rotation = intval($y_axis_labels_rotation);
	}
}

//Get chart json code
function get_json_code(){
	return $this->chart->toPrettyString();
}

function get_nvd3_chart_code()
{
    $jsCode = $this->nvd3_chart->getCode();
    return $jsCode;
}

function get_nvd3_chart_jslibs()
{
    $jsCode = $this->nvd3_chart->getJSlibs();
    return $jsCode;
}

function get_nvd3_chart_data()
{
    $nvd3Data = $this->nvd3_chart->getData();
    return $nvd3Data;
}

function get_nvd3_chart_placeholder()
{
    $ph = $this->nvd3_chart->getPlaceholder();
    return $ph;
}


//Set chart bg_colour 
function set_bg_colour($bg_colour){
	$this->bg_colour = $bg_colour;
}

//Set chart type
function set_type($type){
	$this->type = $type;
}

//Set chart x axis precision
function set_x_precision($x_precision){
    $this->x_axis_precision = $x_precision;
}

//Set chart y axis precision
function set_y_precision($y_precision){
    $this->y_axis_precision = $y_precision;
}

//Set chart y axis currency
function set_y_currency($y_currency){
    $this->y_axis_currency = $y_currency;
}

//Set chart x_axis labels color 
function set_x_axis_labels_color($x_axis_labels_color){
	$this->x_axis_labels_color=$x_axis_labels_color;
}

//Set chart y_axis labels color 
function set_y_axis_labels_color($y_axis_labels_color){
	$this->y_axis_labels_color=$y_axis_labels_color;
}

//Set chart x_axis labels size 
function set_x_axis_labels_size($x_axis_labels_size){
	$this->x_axis_labels_size=$x_axis_labels_size;
}

//Set chart y_axis labels size 
function set_y_axis_labels_size($y_axis_labels_size){
	$this->y_axis_labels_size=$y_axis_labels_size;
}

//Convert to UNIX time
function convert_to_time($labels)
{
    $unixtime = array();
    foreach($labels as $date)
    {
        $newtime = strtotime($date) * 1000;
        array_push($unixtime, $newtime);
    }
    return $unixtime;
}

//Set chart x_axis labels (x_axis object: http://teethgrinder.co.uk/open-flash-chart-2/doxygen/html/classx__axis.html)
function set_x_axis_labels($x_axis_labels, $x_axis_labels_size, $x_axis_labels_color, $is_time=false){
	$this->x_axis_labels = new x_axis_labels();
    if($is_time)
    {
        $x_axis_time_labels = $this->convert_to_time($x_axis_labels);
	    $this->x_axis_labels->set_labels($x_axis_time_labels);
    }
    else
    {
        $this->x_axis_labels->set_labels($x_axis_labels);
    }
	$this->x_axis_labels->set_colour($x_axis_labels_color);
	$this->x_axis_labels->set_size($x_axis_labels_size);
}

//Set chart y_axis labels (y_axis object: http://teethgrinder.co.uk/open-flash-chart-2/doxygen/html/classx__axis.html)
function set_y_axis_labels($y_axis_labels, $y_axis_labels_size, $y_axis_labels_color){
	switch($this->type){
		case self::RADAR:	$this->y_axis_labels = new radar_spoke_labels($y_axis_labels);
							break;
        case self::DONUT:
        case self::PIE:		//do nothing
							break;
		default:			$this->y_axis_labels = new y_axis_labels();
							$this->y_axis_labels->set_labels($y_axis_labels);
							$this->y_axis_labels->set_size($y_axis_labels_size);
							break;
	}
	$this->y_axis_labels->set_colour($y_axis_labels_color);
	
}

//Set chart width
function set_width($width){

    if(substr_compare($width, "%", -strlen("%"), strlen("%")) === 0)
    {
	    $this->width = $width;
    }
    else
    {
        $this->width = $width.'px';
    }
}

//Set chart height
function set_height($height){

    if(substr_compare($height, "%", -strlen("%"), strlen("%")) === 0)
    {
        $this->height = $height;
    }
    else
    {
        $this->height = $height.'px';
    }
}

//Set chart title
function set_title($title){
	$this->title = $title;
}

//Set chart title color
function set_title_color($title_color){
	$this->title_color = $title_color;
}

//Set chart title size
function set_title_size($title_size){
	$this->title_size = $title_size;
}

//Set chart name
function set_name($name){
	$this->name = $name;
}

//Set chart tooltip (tooltip object: http://teethgrinder.co.uk/open-flash-chart-2/doxygen/html/classtooltip.html)
function set_tooltip($tooltip){
	$this->tooltip = $tooltip;
}

//Set X axis thickness
function set_x_axis_thickness($x_axis_thickness){
	$this->x_axis_thickness = $x_axis_thickness;
}

//Set Y axis thickness
function set_y_axis_thickness($y_axis_thickness){
	$this->y_axis_thickness = $y_axis_thickness;
}

//Set X axis grid color
function set_x_axis_grid_color($x_axis_grid_color){
	$this->x_axis_grid_color = $x_axis_grid_color;
}

//Set Y axis grid color
function set_y_axis_grid_color($y_axis_grid_color){
	$this->y_axis_grid_color = $y_axis_grid_color;
}

//Set X axis  color
function set_x_axis_color($x_axis_color){
	$this->x_axis_color = $x_axis_color;
}

//Set Y axis  color
function set_y_axis_color($y_axis_color){
	$this->y_axis_color = $y_axis_color;
}

//Set y axis legend
function set_x_legend($title, $dimension, $color){
	$legend = new x_legend( $title );
	$legend->set_style( '{font-size: '.$dimension.'px; color: '.$color.'}' );
	$this->x_legend = $legend;
}

//Set y axis legend
function set_y_legend($title, $dimension, $color){
	$legend = new y_legend( $title );
	$legend->set_style( '{font-weight:bold; font-size: '.$dimension.'px; color: '.$color.'}' );
	$this->y_legend = $legend;
}

//Set X axis  step %
function set_x_axis_step_percent($x_axis_step_percent){
	$this->x_axis_step_percent = $x_axis_step_percent;
}

//Set Y axis  step %
function set_y_axis_step_percent($y_axis_step_percent){
	$this->y_axis_step_percent = $y_axis_step_percent;
}



}

?>