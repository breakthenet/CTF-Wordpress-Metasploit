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

class nvd3_settings
{
    var $wpbi_url = NULL;
    var $wpbi_config = NULL;

    public function __construct()
    {
        $this->wpbi_url = array(
            "nvd3" => array(
                "css"               =>	plugins_url('/js/src/nv.d3.css', __FILE__),
                "nvd3"              =>	plugins_url('/js/nv.d3.min.js', __FILE__),
                "d3js"              =>	plugins_url('/js/lib/d3.v2.js', __FILE__),
                "fisheye"           => 	plugins_url('/js/lib/fisheye.js', __FILE__),
                "tooltip"           =>	plugins_url('/js/src/tooltip.js', __FILE__),
                "utils"             =>	plugins_url('/js/src/utils.js', __FILE__),
                "axis"         	    =>	plugins_url('/js/src/models/axis.js', __FILE__),
                "legend"            =>	plugins_url('/js/src/models/legend.js', __FILE__),
                "distribution"      =>	plugins_url('/js/src/models/distribution.js', __FILE__),
                "historical"      =>	plugins_url('/js/src/models/historical.js', __FILE__),
                "historicalbar"      =>	plugins_url('/js/src/models/historicalbar.js', __FILE__),
                "scatter"	        =>	plugins_url('/js/src/models/scatter.js', __FILE__),
                "scatterchart"      =>	plugins_url('/js/src/models/scatterChart.js', __FILE__),
                "discretebar"       =>	plugins_url('/js/src/models/discreteBar.js', __FILE__),
                "discretebarchart"	=>	plugins_url('/js/src/models/discreteBarChart.js', __FILE__),
                "multibar"          =>	plugins_url('/js/src/models/multiBar.js', __FILE__),
                "multibarchart"	    =>	plugins_url('/js/src/models/multiBarChart.js', __FILE__),
                "multibarhorizontal"          =>	plugins_url('/js/src/models/multiBarHorizontal.js', __FILE__),
                "multibarhorizontalchart"	    =>	plugins_url('/js/src/models/multiBarHorizontalChart.js', __FILE__),
                "line"              =>	plugins_url('/js/src/models/line.js', __FILE__),
                "linechart"	        =>	plugins_url('/js/src/models/lineChart.js', __FILE__),
                "cumulativelinechart"	        =>	plugins_url('/js/src/models/cumulativeLineChart.js', __FILE__),
                "lineandbarchart"	        =>	plugins_url('/js/src/models/linePlusBarChart.js', __FILE__),
                "lineandbar"	        =>	plugins_url('/js/src/models/linePlusBar.js', __FILE__),
                "crossfilter"	        =>	plugins_url('/js/lib/crossfilter.js', __FILE__),
                "multilinefocuschart"	        =>	plugins_url('/js/src/models/lineWithFocusChart.js', __FILE__),
                "stackedareachart"	        =>	plugins_url('/js/src/models/stackedAreaChart.js', __FILE__),
                "stackedarea"	        =>	plugins_url('/js/src/models/stackedArea.js', __FILE__),
                "pie"               =>	plugins_url('/js/src/models/pie.js', __FILE__),
                "piechart"	        =>	plugins_url('/js/src/models/pieChart.js', __FILE__)
                )
            );

        $wpbi_config = array();
    }

}
