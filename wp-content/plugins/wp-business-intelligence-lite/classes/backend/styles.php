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


class styles {

var $rootdir;

function styles(){

}

function set_rootdir($rootdir){
	$this->rootdir = $rootdir;
}

function get_styles(){
	// create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir($this->rootdir);

    // open directory and walk through the filenames
    while ($file = readdir($handler)) {

      // if file isn't this directory or its parent, add it to the results
	  $path_info = pathinfo($file); 
      if ($file != "." && $file != ".." && strtolower($path_info['extension'])=='css') {
        $results[] = basename($file); 
      }

    }
	
	sort($results);

    // tidy up: close the handler
    closedir($handler);

    // done!
    return $results;
}

}

?>