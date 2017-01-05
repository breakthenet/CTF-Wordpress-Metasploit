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

class nvd3_pieChart
{
    var $dataSeries = NULL;
    var $staggerLabels = "true";
    var $tooltips = "true";
    var $showLabels = "true";
    var $transitionDuration = "1200";
    var $height = "400px";
    var $width = "400px";
    var $placeholder = NULL;
    var $nvd3Settings = NULL;
    var $donut = "false";

    public function __construct($chart)
    {
        $this->nvd3Settings = new nvd3_settings();
        $this->placeholder = new nvd3_placeholder('ph_'.str_replace(' ', '_', $chart->name));

        //wp_enqueue_script('nvd3-legend', $this->nvd3Settings->wpbi_url['nvd3']['legend'] );
        //wp_enqueue_script('nvd3-utils', $this->nvd3Settings->wpbi_url['nvd3']['utils'] );
        wp_enqueue_script('nvd3-fisheye', $this->nvd3Settings->wpbi_url['nvd3']['fisheye'] );
        wp_enqueue_script('nvd3-pie', $this->nvd3Settings->wpbi_url['nvd3']['pie'] );
        //wp_enqueue_script('nvd3-piechart', $this->nvd3Settings->wpbi_url['nvd3']['piechart'] );
    }

    public function create_dataseries($chart)
    {
        $this->dataSeries = array();

        // For now we support a single series, but this shall become a foreach loop
        // on the number of series (queries?)

        foreach ($chart->elements as $key => $value){
            $this->dataSeries[$key] = new nvd3_dataseries($chart, $value);
        }

    }

    public function getCode()
    {
        if(substr_compare($this->width, "%", -strlen("%"), strlen("%")) === 0)
        {
            $w = substr($this->width, 0, strlen($this->width) - 1);
            $h = substr($this->height, 0, strlen($this->height) - 1);
        }
        else
        {
            $w = substr($this->width, 0, strlen($this->width) - 2);
            $h = substr($this->height, 0, strlen($this->height) - 2);
        }
        $code = "
            nv.addGraph(function() {
                var width = $w,
                height = $h;

                var chart = nv.models.pieChart()
                    .x(function(d) { return d.key })
                    .y(function(d) { return d.y })
                    .showLabels($this->showLabels)
                    .color(d3.scale.category10().range())
                    .width(width)
 .height(height).donut($this->donut);

                d3.select('#".$this->placeholder->name." svg')
                        .datum(nvd3Data_".$this->placeholder->name.")
                        .transition().duration($this->transitionDuration)
                        .attr('width', width)
                        .attr('height', height)
                        .call(chart);

                chart.dispatch.on('stateChange', function(e) { nv.log('New State:', JSON.stringify(e)); });

                return chart;
            });
            ";
        return $code;
        //return str_replace("\r\n", '', $code);
    }

    // create the CSS style for the placeholder
    public function setPlaceholderStyle($chart)
    {
        $this->width = $chart->width;
        $this->height = $chart->height;
        $phStyle = array('width : '.$chart->width, 'height : '.$chart->height);

        $this->placeholder->addStyleElement('#'.$this->placeholder->name.' svg', $phStyle);
    }

    // get the HTML for the chart placeholder
    public function getPlaceholder()
    {
        return $this->placeholder->render();
    }

    public function getJSlibs()
    {
        return '';
    }

}
