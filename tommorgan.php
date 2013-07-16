<?php
/*
Plugin Name: Tom Morgan
Plugin URI: http://www.morganesque.com/
Description: A special plugin for websites made by Morganesque.
Version: 1.0
Author: Tom Morgan
Author URI: http://morganesque.com/
License: GPL2
*/
?>
<?php
/*  Copyright YEAR  Tom Morgan  (email : morganesque@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define('TOM_PATH', plugin_dir_path(__FILE__));
include( TOM_PATH . 'twitter-search.php');
include( TOM_PATH . 'tinymce.php');
include( TOM_PATH . 'type-portfolio.php');
include( TOM_PATH . 'menu_pages.php');
include( TOM_PATH . 'bypass-dashboard.php');
include( TOM_PATH . 'change_admin_menu.php');
// include( TOM_PATH . 'post_type_support.php');
include( TOM_PATH . 'meta-project_url.php');
include( TOM_PATH . 'meta-all_projects.php');
include( TOM_PATH . 'disable-adminbar.php');
include( TOM_PATH . 'widgets.php');
include( TOM_PATH . 'comments.php');

add_action( 'admin_menu', 'tommorgan_plugin_menu' );

function tommorgan_plugin_menu() 
{    
    $page_title = 'Morganesque';
    $menu_title = 'Morganesque';
    $capability = 'manage_options';
    $menu_slug  = 'morganesque';
    $function   = 'tommorgan_plugin_options';
    
    // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);

	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function);
}

function tommorgan_plugin_options() 
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    include( TOM_PATH .'options-page.php');
    
    $active_plugins = get_option('active_plugins');
    PreDump($active_plugins);
}

function PreDump($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function this_plugin_first() 
{
	// ensure path to this file is via main wp plugin path
	$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
	$this_plugin = plugin_basename(trim($wp_path_to_this_file));
	$active_plugins = get_option('active_plugins');
	$this_plugin_key = array_search($this_plugin, $active_plugins);
	
	if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
		array_splice($active_plugins, $this_plugin_key, 1);
		array_unshift($active_plugins, $this_plugin);
		update_option('active_plugins', $active_plugins);
	}
}
add_action("activated_plugin", "this_plugin_first");
?>