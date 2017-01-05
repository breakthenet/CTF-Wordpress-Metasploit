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

class nvd3_chart
{
    var $nvd3chart = NULL;
    var $nvd3_utils = NULL;
    var $nvd3_js_libs = NULL;
    var $dataSeries = NULL;
    var $code = NULL;
    var $type = 1;
    var $placeholderName = "ph";

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
    const DONUT	    			= 13;
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

    public function __construct()
    {
        $this->nvd3_utils = new nvd3_utils();
    }

    public function create_dataseries($chart)
    {
        $this->type = $chart->type;

        switch($chart->type){
            case self::LINE:
                $this->nvd3chart = new nvd3_lineChart($chart);
                break;

            case self::BAR:
                $this->nvd3chart = new nvd3_discreteBarChart($chart);
                break;

            case self::BAR_STACKED:
                $this->nvd3chart = new nvd3_multiBarChart($chart);
                break;

            case self::BAR_HORIZONTAL:
                $this->nvd3chart = new nvd3_multiBarHorizontalChart($chart);
                break;

            case self::PIE:
                $this->nvd3chart = new nvd3_pieChart($chart);
                break;

            case self::DONUT:
                $this->nvd3chart = new nvd3_pieChart($chart);
                $this->nvd3chart->donut = "true";
                break;

            case self::SCATTER:
                $this->nvd3chart = new nvd3_scatterChart($chart);
                break;

            case self::CUMULATIVE_LINE:
                $this->nvd3chart = new nvd3_cumulativeLineChart($chart);
                break;

            case self::LINE_AND_BAR:
                $this->nvd3chart = new nvd3_lineAndBarChart($chart);
                break;

            case self::MULTI_LINE_FOCUS:
                $this->nvd3chart = new nvd3_multiLineFocusChart($chart);
                break;

            case self::STACKED_AREA:
                $this->nvd3chart = new nvd3_stackedAreaChart($chart);
                break;
        }

        $this->nvd3chart->setPlaceholderStyle($chart);
        $this->nvd3chart->create_dataseries($chart);

    }

    public function setPlaceholder( $chart ){

        if(isset ($this->nvd3_chart))
        {
            $this->nvd3chart->height = $chart->height;
            $this->nvd3chart->width = $chart->width;
        }

        $this->placeholderName = 'ph_'.str_replace(' ', '_', $chart->name);
    }

    public function getCode()
    {
        return $this->nvd3chart->getCode();
    }

    public function getData()
    {
        $data = "";

        switch($this->type){
            case self::LINE:
            case self::STACKED_AREA:
            case self::CUMULATIVE_LINE:
            case self::LINE_AND_BAR:
            case self::MULTI_LINE_FOCUS:
            case self::BAR:
            case self::BAR_STACKED:
            case self::BAR_HORIZONTAL:
            case self::DONUT:
            case self::PIE:
                $i = 0;
                foreach ( $this->nvd3chart->dataSeries as $key => $series )
                {
                    $data .= $series->getData($i);
                    $i++;
                }
                $data = str_replace('][', ', ', $data);
                break;

            case self::SCATTER:
                $data ='[ ';
                foreach ( $this->nvd3chart->dataSeries as $key => $series )
                {
                    $data .= '{ '.$series->getData().'},';
                }

                // remove the last comma
                $data = substr($data, 0, strlen($data) - 1);
                $data .= ' ]';
                break;
        }

        $data = "nvd3Data_$this->placeholderName = ".$data.';';

        $sanitized = $this->nvd3_utils->strip_null_fields($data);

        return $sanitized;
    }

    public function getJSlibs()
    {
        return $this->nvd3chart->getJSlibs();
    }

    public function getPlaceholder()
    {
        return $this->nvd3chart->getPlaceholder();
    }
}

?>