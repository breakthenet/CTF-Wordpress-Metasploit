<?php

/***************************************************************************

	WP Business Intelligence
	Author: WP Business Intelligence
	Website: www.wpbusinessintelligence.com
	Contact: http://www.wpbusinessintelligence.com/contactus/

	This file is part of WP Business Intelligence.

    WP Business Intelligence is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    WP Business Intelligence is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with WP Business Intelligence; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	You can find a copy of the GPL licence here:
	http://www.gnu.org/licenses/gpl-3.0.html
	
******************************************************************************/


/*** TinyMCE ***/

//Tag
function wpbi_mce_tag( $atts, $content = null ) {

	global $wpbi_url, $template_site, $wpdb, $wpbi_sql;

//    remove_filter('the_content', 'wpautop');

  $template_site->set_filenames(array(
		'iframe' 		=> $wpbi_url['tpl']['root-path'].$wpbi_url['tpl']['iframe']
		)
	);
  
  extract( shortcode_atts( array (
    'type' => 'table',
	'id' => NULL,
	'iframe' => 'n'
  ), $atts ) );
  
  $code = '';
  
  if($type == 'table'){
	if($iframe=='y'){
		//Get Key
		$vo_table = new vo_table($id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$dao_table = new dao_table($wpdb, $wpbi_sql['tname']['tables']);
		$vo_table = $dao_table->select($vo_table);
		$vo_table = $vo_table[0];
		$table_key = $vo_table->table_key;
		//Prepare output
		$template_site->assign_vars(array(
		'IFRAME_JS_AUTOHEIGHT'	=> $wpbi_url['jquery']['iframe-auto-height'],
		'IFRAME_SRC'			=> $wpbi_url['iframe']['src'].'?t='.$table_key
		));
	
		ob_start();
		$template_site->pparse('iframe');
		$iframe_output = ob_get_contents();
		ob_end_clean();
	
		$code = $iframe_output;
	} else{
		$code = get_html_4_table($id);
	}
  } else if($type == 'chart'){
  	if($iframe=='y'){
		//Get Key
		$selected_charts = $id;
		$vo_chart = new vo_chart(NULL);		
		$vo_chart->set_chart_id($selected_charts);				
		$vo_chart->set_chart_key($selected_charts);
		$dao_chart = new dao_chart($wpdb, $wpbi_sql['tname']['charts']);
		$vo_chart = $dao_chart->select($vo_chart);
		$vo_chart = $vo_chart[0];
		$chart_key = $vo_chart->chart_key;
	
		//Prepare output
		$template_site->assign_vars(array(
		'IFRAME_JS_AUTOHEIGHT'	=> $wpbi_url['jquery']['iframe-auto-height'],
		'IFRAME_SRC'			=> $wpbi_url['iframe']['src'].'?c='.$chart_key
		));
	
		ob_start();
		$template_site->pparse('iframe');
		$iframe_output = ob_get_contents();
		ob_end_clean();
	
		$code = $iframe_output;
	} else{
		$code = get_html_4_chart($id);
	}
  } 
  
  return $code;
  
}

add_shortcode( $wpbi_settings['tinymce']['tag'], 'wpbi_mce_tag' );

//Button

add_action('init', 'wpmybusinessintelligence_button');

function wpmybusinessintelligence_button() {
 
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
 
   if ( get_user_option('rich_editing') == 'true' ) {
	 add_filter( 'mce_buttons', 'register_wpbi_button' );
     add_filter( 'mce_external_plugins', 'add_wpbi_plugin' );
   }
 
}

function register_wpbi_button( $buttons ) {
 array_push( $buttons, "|", $wpbi_settings['tinymce']['tag'] );
 return $buttons;
}

function add_wpbi_plugin( $plugin_array ) {
   //$plugin_array[$wpbi_settings['tinymce']['tag']] = $wpbi_settings['tinymce']['js'];
   return $plugin_array;
}




?>