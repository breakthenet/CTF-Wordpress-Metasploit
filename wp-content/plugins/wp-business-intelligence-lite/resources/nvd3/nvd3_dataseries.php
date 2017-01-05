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

class nvd3_dataseries
{
    var $key = "key";
    var $values = NULL;
    var $area = NULL;
    var $color = NULL;
    var $type = NULL;
    var $name = NULL;
    var $parameters = NULL;

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
    const BAR_STACKED  			= 12;
    const DONUT 				= 13;
    const LINE 					= 14;
    const LINE_AREA				= 15;
    const PIE					= 16;
    const RADAR					= 17;
    const SCATTER				= 18;
    const SCATTER_LINE			= 19;
    const CUMULATIVE_LINE       = 20;
    const STACKED_AREA          = 21;
    const MULTI_LINE_FOCUS      = 22;
    const LINE_AND_BAR          = 23;

    function __construct($chart, $value = NULL, $series = 0)
    {
        $this->type = $chart->type;
        $this->name = $chart->name;
        if(isset( $chart->chart->elements[$series]->colour))
        {
            $this->color = $chart->chart->elements[$series]->colour;
        }


        switch($chart->type){
            case self::STACKED_AREA:
                $this->key = $value->text;
                $this->color = $value->colour;
                $this->add_stackedareachart_value($chart, $value, $series);
                break;

            case self::CUMULATIVE_LINE:
                $this->key = $value->text;
                $this->add_cumulativelinechart_value($chart, $value, $series);
                break;

            case self::LINE_AND_BAR:
                $this->key = $value->text;
                $this->add_lineandbarchart_value($chart, $value, $series);
                break;

            case self::MULTI_LINE_FOCUS:
                $this->key = $value->text;
                $this->add_multilinefocuschart_value($chart, $value, $series);
                break;

            case self::LINE:
                $this->key = $value->text;
                $this->add_linechart_value($chart, $value, $series);
                break;

            case self::BAR:
                $this->key = $value->text;
                $this->add_barchart_value($chart->x_axis_labels, $value, $series);
                break;

            case self::BAR_STACKED:
                $this->key = array();
                $this->values = array();
                $this->add_multibarchart_value($chart->x_axis_labels, $value, $series);
                break;

            case self::BAR_HORIZONTAL:
                $this->key = array();
                $this->values = array();
                $this->add_horiz_barchart_value($chart->y_axis_labels, $value, $series);
                break;

            case self::PIE:
            case self::DONUT:
                if(isset($value->text))
                {
                    $this->key = $value->text;
                }
                $this->add_piechart_value($chart->x_axis_labels, $value, $series);
                break;

            case self::SCATTER:
                $this->key = $value->text;
                $this->parameters = array(
                    'size'  =>  0.88,
                    'shape' =>  array("'circle'", "'square'", "'triangle-up'", "'cross'", "'triangle-down'")
                );

                $this->add_scatterchart_value($chart, $value, $series);
                break;
        }

    }


    function add_barchart_value($labels, $elements, $series = 0)
    {
        $i = 0;
        $temp ="";
        if(!is_null($elements->text))
        {
            $this->key = $elements->text;
        }
        foreach ($elements->values as $value)
        {
            $temp.= ' { "label" : "' . $labels->labels[$i] . '", "value" : ' . $value . '},';
            $i++;
        }

        // remove the last comma
        $this->values = substr($temp, 0, strlen($temp) - 1);

        $this->values = '[ '.$this->values.' ]';
    }


    function add_linechart_value($chart, $elements, $series = 0)
    {
        $i = 0;
        $temp ="";

        if($chart->x_axis_istime)
        {
            foreach ($elements->values as $value)
            {
               $temp.= ' { x : '. $chart->x_axis_labels->labels[$i] .', y : ' . $value .' },';
                $i++;
            }

        }else{
            foreach ($elements->values as $value)
            {
                $temp.= ' { x : "'. $chart->x_axis_labels->labels[$i] .'", y : ' . $value .' },';
                $i++;
            }

        }

        // remove the last comma
        $this->values = substr($temp, 0, strlen($temp) - 1);

        $this->values = '[ '.$this->values.' ]';
    }

    function add_piechart_value_new($labels, $elements, $series = 0)
    {
        $i = 0;
        $temp ="";
        if(!is_null($this->name))
        {
            $this->key = $this->name;
        }
        foreach ($elements->values as $value)
        {
            $temp.= ' { "label" : "' . $value->label . '", "value" : ' . $value->value . '},';
            $i++;
        }

        // remove the last comma
        $this->values = substr($temp, 0, strlen($temp) - 1);

        $this->values = '[ '.$this->values.' ]';
    }

    function add_piechart_value($labels, $elements, $series = 0)
    {
        $i = 0;
        $temp ="";
        foreach ($elements->values as $value)
        {
            if(isset($labels->labels[$i]))
            {
                $temp.= ' { "key" : "' . $labels->labels[$i] . '", y : ' . $value->value . '},';
            }
            else
            {
                $temp.= ' { "key" : "' . $value->label . '", y : ' . $value->value . '},';
            }

            $i++;
        }

        // remove the last comma
        $this->values = substr($temp, 0, strlen($temp) - 1);

        $this->values = '[ '.$this->values.' ]';
    }

    function getData($count = 0)
    {
        $data = NULL;

        switch($this->type){
            case self::LINE:
                $this->name = NULL;
                $this->type = NULL;
                $data = '[ ' .$this->toPrettyString().' ]';
                break;
            case self::BAR:
                $data = '[ ' .$this->toPrettyString().' ]';
                break;
            case self::BAR_STACKED:
            case self::BAR_HORIZONTAL:
            //$data = '[ ' .$this->toPrettyString().' ]';
            $i = 0;
            $data = '[ ';

            if(is_array($this->values))
            {
                foreach ($this->values as $value)
                {
                    $data .= '{ key: "'.$this->key[$i] . '", color: "'.$this->color[$i].'", values: [' .$value. '] },';
                    $i++;
                }
            }
            else
            {
                $data .= '{ key: "'.$this->key . '", color: "'.$this->color.'", values: ' .$this->values. ' }';
            }
            $data .=' ]';
            break;
            case self::STACKED_AREA:
            case self::CUMULATIVE_LINE:
            case self::MULTI_LINE_FOCUS:

                $i = 0;
                $data = '[ ';

                if(is_array($this->values))
                {
                    foreach ($this->values as $value)
                    {
                        $data .= '{ key: "'.$this->key[$i] . '", color: '.$this->color.', values: [' .$value. '] },';
                        $i++;
                    }
                }
                else
                {
                    $data .= '{ key: "'.$this->key . '", color: "'.$this->color.'", values: ' .$this->values. ' }';
                }
                $data .=' ]';
                break;
            case self::LINE_AND_BAR:

                $data = '[ ';

                if($count == 0)
                {
                    $data .= '{ key: "'.$this->key . '", color: "'.$this->color.'", bar: true, values: ' .$this->values. ' }';
                }
                else
                {
                    $data .= '{ key: "'.$this->key . '", color: "'.$this->color.'", values: ' .$this->values. ' }';
                }

                $data .=' ]';
                break;
            case self::PIE:
            case self::DONUT:
                $data = $this->values;
                break;
            case self::SCATTER:
                $data = 'key: "'.$this->key . '", color: "'.$this->color.'" , values:' .$this->values;
                break;
        }

        //return "nvd3Data_ph_$this->name = ".$data.';';
        return $data;
    }


    function toPrettyString()
    {
        $dataseries = json_format( $this->toString() );

        // Remove " from the data: element
        $dataseries = str_replace('\"', '"', $dataseries);
        $dataseries = str_replace('"[', '[', $dataseries);
        $dataseries = str_replace(']"', ']', $dataseries);

        return $dataseries;
    }

    function toString()
    {
        if (function_exists('json_encode'))
        {
            return json_encode($this);
        }
        else
        {
            $json = new Services_JSON();
            return $json->encode( $this );
        }
    }

}
