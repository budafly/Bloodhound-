<?php


/**
 * Upon theme activation
 */
if ( !function_exists( 'bloodhound_theme_activation' ) ) {
	function bloodhound_theme_activation() {
		$defaults = array(
			'bloodhound_add_post_to_one_page' => 0,
			'bloodhound_add_post' => array(
				'page-color'  => '#FFFFFF',
				'style'       => 'solid',
				'nav-icon'    => '',
				'title-color' => '#333333',
			),
			'bloodhound_one_page_nav' => array(
				'ignore-sticky' => '1',
			),
			'bloodhound_splash' => array(
				'logo' => get_stylesheet_directory().'/images/defaults/logo-splash.png',
			),
		);
	}
}
add_action('switch_theme', 'bloodhound_theme_activation');

add_theme_support('post-thumbnails', array( 'page', 'post', 'team_member' ) );

register_nav_menu( 'primary', 'Bloodhound Menu' );

add_action('wp_enqueue_scripts', 'bloodhound_enqueue_scripts');

require_once( TEMPLATEPATH . '/includes/admin/theme-options/theme-options.php' );

add_action( 'admin_menu', array( Bloodhound_Theme_Options_Class::get_instance(), 'theme_page_init' ) );

add_action( 'admin_enqueue_scripts', 'bloodhound_enqueue_admin_scripts' );


$portfolio = new PremiseCPT( array(
	'post_type' => 'portfolio',
	'menu_name' => 'Portfolio',
	'singular'  => 'Project',
	'plural'    => 'Projects',
	'slug'      => 'portfolio',
) );

$team_member = new PremiseCPT( array( 
	'post_type' => 'team_member',
	'singular'  => 'Team Member',
	'plural'    => 'Team Members',
	'slug'      => 'team-member',
) );

if( is_admin() ){
	add_action( 'load-post.php', 'call_Bloodhoundteam_memberClass' );
	add_action( 'load-post-new.php', 'call_Bloodhoundteam_memberClass' );
}


/**
 * Site scripts
 */
if( !function_exists('bloodhound_enqueue_scripts') ) {
	function bloodhound_enqueue_scripts() {
		//register stylesheets
		wp_register_style( 'jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css' );
		wp_register_style( 'googlefonts', 'http://fonts.googleapis.com/css?family=Oswald:400,300,700|Nunito:400,300,700', array( 'jquery-ui' ) );
		wp_register_style( 'bloodhound_style', get_template_directory_uri().'/style.css' );
		wp_register_style( 'bloodhound_responsive', get_template_directory_uri().'/css/responsive.css', array( 'bloodhound_style' ) );
		//register scripts
		wp_register_script('bloodhound_main_js', get_template_directory_uri().'/js/main.js', array( 'jquery', 'jquery-ui-accordion' ) );
		//enqueue styles and scripts
		if( !is_admin()){
			wp_enqueue_style('bloodhound_responsive');
			wp_enqueue_script('bloodhound_main_js');
		}
	}
}





/**
 * Admin scripts
 */
if( !function_exists('bloodhound_enqueue_admin_scripts') ) {
	function bloodhound_enqueue_admin_scripts() {
		//register admin style
		wp_register_style('minicolors-css', get_template_directory_uri().'/includes/admin/css/jquery.minicolors.css');
		wp_register_style('bloodhound_admin_css', get_template_directory_uri().'/includes/admin/css/bloodhound-admin.css', array('minicolors-css'));
		//register scripts
		wp_register_script('minicolors', get_template_directory_uri().'/includes/admin/js/jquery.minicolors.min.js');
		wp_register_script('bloodhound_admin_js', get_template_directory_uri().'/includes/admin/js/bloodhound-admin.js', array('jquery', 'minicolors' ) );
		//enqueue admin style and script
		if( is_admin()){
			wp_enqueue_style('bloodhound_admin_css');	
			wp_enqueue_script('bloodhound_admin_js');
		}
	}
}


/**
 * Load admin scripts
 */
function bloodhound_load_admin_scripts() {
	add_action('admin_enqueue_scripts', 'bloodhound_enqueue_admin_scripts');
}



/**
 * Includes
 */
require_once( 'includes/includes.php' );


