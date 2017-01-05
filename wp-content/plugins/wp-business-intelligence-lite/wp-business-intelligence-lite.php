<?php
/*
Plugin Name: WP Business Intelligence Lite
Plugin URI: http://www.wpbusinessintelligence.com
Description: WP Business Intelligence Lite lets you create and insert dynamic charts into any post or page. You just have to connect to a database and run your SQL queries to retrieve the desired data.
Version: 1.0.6
Author: WP Business Intelligence
Author URI: http://www.wpbusinessintelligence.com/who-we-are
License: GPL3
*/ 

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
    along with WP Business Intelligence; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	You can find a copy of the GPL licence here:
	http://www.gnu.org/licenses/gpl-3.0.html
	
******************************************************************************/
$filepath = realpath (dirname(__FILE__));
//includes

include_once($filepath.'/includes.php');
include_once($filepath.'/tinymce/tinymce.php');

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo "No direct calls allowed.";
	exit;
}

//Language setting
$language = 'en';

//Initialize template
$template_site = new template_site();

add_action( 'wp_head', 'wpbi_plugin_scripts');

// Hook for adding admin menus
add_action('admin_menu', 'wpbi_menu');

// Hook to initialize DB
add_action( 'admin_init', 'wpbi_admin_init' );

function wpbi_admin_init() {

    global $wpbi_url;

    wpbi_initWPDBconnection();

    wp_register_script( 'jquery-alphanumeric', $wpbi_url['jquery']['alphanumeric']);
    wp_register_script( 'colorpicker-colorpicker', $wpbi_url['colorpicker']['colorpicker']);
    wp_register_script( 'nvd3-d3js', $wpbi_url['nvd3']['d3js']);
    wp_register_script( 'nvd3-nvd3', $wpbi_url['nvd3']['nvd3'], array('nvd3-d3js'));

}

function wpbi_getWPDBcredentials()
{
    global $wpdb, $wpbi_settings, $wpbi_sql;

    $credentials = array();
    $wp_config_file = "";

    if ( file_exists( ABSPATH . 'wp-config.php') ) {

        /** The config file resides in ABSPATH */
        $wp_config_file = ABSPATH . 'wp-config.php' ;

    } elseif ( file_exists( dirname(ABSPATH) . '/wp-config.php' ) && ! file_exists( dirname(ABSPATH) . '/wp-settings.php' ) ) {

        /** The config file resides one level above ABSPATH but is not part of another install */
        $wp_config_file = dirname(ABSPATH) . '/wp-config.php';
    }

    $wp_config_file_content = file_get_contents($wp_config_file);

    preg_match("/^.*DB_NAME.*\$/m", $wp_config_file_content, $dbname);
    preg_match("/^.*DB_USER.*\$/m", $wp_config_file_content, $dbuser);
    preg_match("/^.*DB_PASSWORD.*\$/m", $wp_config_file_content, $dbpwd);
    preg_match("/^.*DB_HOST.*\$/m", $wp_config_file_content, $dbhost);

    if (preg_match_all("/(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:'(?:\\\'|[^'])+'))/is", $dbname[0], $found))
    {
        $credentials[0] = str_replace("'", "", $found[0][1]);
    }

    if (preg_match_all("/(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:'(?:\\\'|[^'])+'))/is", $dbuser[0], $found))
    {
        $credentials[1] = str_replace("'", "", $found[0][1]);
    }

    if (preg_match_all("/(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:'(?:\\\'|[^'])+'))/is", $dbpwd[0], $found))
    {
        $credentials[2] = str_replace("'", "", $found[0][1]);
    }

    if (preg_match_all("/(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:'(?:\\\'|[^'])+'))/is", $dbhost[0], $found))
    {
        $credentials[3] = str_replace("'", "", $found[0][1]);
    }

    return $credentials;
}

// initialize the DB connection list with the connection to the WP Database
function wpbi_initWPDBconnection()
{
    global $wpdb, $wpbi_settings, $wpbi_sql;

    $wpbi_query = "SELECT * FROM " . $wpbi_sql['tname']['databases'];

    // test if at least one DB connection already exists
    if(!$wpdb->query($wpbi_query))
    {
        $wpbi_credentials = wpbi_getWPDBcredentials();

        $vo_database = new vo_database(NULL, $wpbi_credentials[0], $wpbi_credentials[3], $wpbi_credentials[1], $wpbi_credentials[2]);
        $dao_database = new dao_database($wpdb, $wpbi_sql['tname']['databases']);
        $dao_database->add($vo_database);
    }
}


// Update DB tables when necessary

function apply_db_updates(){
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    //necessary for upgrade from 1.0.5 to 1.0.6
    $sql = "ALTER TABLE wp_wpbi_charts ADD COLUMN CHART_Y_CURRENCY varchar(11) NOT NULL AFTER CHART_Y_PRECISION;";
    dbDelta($sql);
}


// Create the menu box wpbi (Connections, Queries, Charts)
function wpbi_menu() {
	
	global $wpdb, $qy_table_databases, $qy_table_queries, $qy_table_views, $qy_tb_cols, $qy_ch_cols, $qy_chart_views, $qy_table_vars, $wpbi_sql, $wpbi_settings,  $wpbi_url, $wpbi_dialog, $qy_fk, $lng, $language, $template_site, $filepath;
	
	//Show sql errors in debug mode
	if($wpbi_settings['parameter']['debug']){
		$wpdb->show_errors();
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
	} else{
		error_reporting(E_ERROR );
	}
	
	//Check tables existence and create in case they don't exist

	$wpdb->query($qy_table_databases);
	$wpdb->query($qy_table_queries);
  	$wpdb->query($qy_table_views);
	$wpdb->query($qy_tb_cols);
	$wpdb->query($qy_chart_views);
	$wpdb->query($qy_ch_cols);
	$wpdb->query($qy_table_vars);
	//$wpdb->query($qy_fk);

    apply_db_updates();

    // Add a new top-level menu (ill-advised):
    add_menu_page('WP BI', 'WP Business Intelligence', 'manage_options', $wpbi_url['slug']['preferences'], 'wpbi_page', plugins_url('wp-business-intelligence-lite/images/chart-icon.png'), '110');

    // Add a second submenu to the custom top-level menu:
    add_submenu_page('wpbi', __($wpbi_dialog['page']['queries']['title'],'wpbi-menu'), __($wpbi_dialog['page']['queries']['title'],'wpbi-menu'), 'manage_options', $wpbi_url['slug']['queries'], 'queries_page');
	
	// Add a third submenu to the custom top-level menu:
    add_submenu_page('wpbi', __($wpbi_dialog['page']['charts']['title'],'wpbi-menu'), __($wpbi_dialog['page']['charts']['title'],'wpbi-menu'), 'manage_options', $wpbi_url['slug']['charts'], 'charts_page');

	// Add a fourth submenu to the custom top-level menu:
    add_submenu_page('wpbi', __($wpbi_dialog['page']['tables']['title'],'wpbi-menu'), __($wpbi_dialog['page']['tables']['title'],'wpbi-menu'), 'manage_options', $wpbi_url['slug']['tables'], 'tables_page');

    // Using registered $page handle to hook script load
    //add_action('admin_print_scripts', 'wpbi_plugin_admin_scripts');

}

function wpbi_plugin_scripts() {

    global $wpbi_url;

    wp_register_script( 'jquery-alphanumeric', $wpbi_url['jquery']['alphanumeric']);
    wp_register_script( 'colorpicker-colorpicker', $wpbi_url['colorpicker']['colorpicker']);
    wp_register_script( 'nvd3-d3js', $wpbi_url['nvd3']['d3js']);
    wp_register_script( 'nvd3-nvd3', $wpbi_url['nvd3']['nvd3'], array('nvd3-d3js'));

}

// analytics_page() displays the page content for the plugin settings first level page
function wpbi_page() {
	global $wpdb, $qy_table_databases, $qy_table_queries, $wpbi_sql, $wpbi_settings, $wpbi_url, $wpbi_dialog, $lng, $language, $template_site;
	
	//include the related administration page
    include_once($wpbi_url['page']['preferences']);
}

// queries_page() displays the page content for the Queries admin page
function queries_page() {
	global $wpdb, $qy_table_databases, $qy_table_queries, $wpbi_sql, $wpbi_settings, $wpbi_url, $wpbi_dialog, $lng, $language, $template_site;

    wp_enqueue_script( 'jquery-alphanumeric');

	//include the related administration page
    include_once($wpbi_url['page']['queries']);
}

// tables_page() displays the page content for the Tables admin page
function tables_page() {
	global $wpdb, $qy_table_databases, $qy_table_queries, $wpbi_sql, $wpbi_settings, $wpbi_url, $wpbi_dialog, $lng, $language, $template_site;

    wp_enqueue_script('jquery-alphanumeric');

	//include the related administration page
    include_once($wpbi_url['page']['tables']);
}

// queries_page() displays the page content for the Charts admin page
function charts_page() {
	global $wpdb, $qy_table_databases, $qy_table_queries, $wpbi_sql, $wpbi_settings, $wpbi_url, $wpbi_dialog, $lng, $language, $template_site;
	//Include scripts

    wp_enqueue_style('colorpicker-css', $wpbi_url['colorpicker']['css']);
    wp_enqueue_style('nvd3-css', $wpbi_url['nvd3']['css']);

    wp_enqueue_script( 'jquery-alphanumeric');
    wp_enqueue_script( 'colorpicker-colorpicker');
    wp_enqueue_script( 'nvd3-d3js');
    wp_enqueue_script( 'nvd3-nvd3');

	//include the related administration page
	include_once($wpbi_url['page']['charts']);
}

?>