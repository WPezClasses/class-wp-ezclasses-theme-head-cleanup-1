<?php
/** 
 * The usual WordPress head cleanup suspects wrapped into an ez to use class (@link https://github.com/WPezClasses/class-wp-ezclasses-theme-head-cleanup-1)
 *
 * WordPress tends to add stuff in the head that are sometimes / often considered unnecessary and excessive. This is that snippet ez'tized.
 *
 * PHP version 5.3
 *
 * LICENSE: TODO
 *
 * @package WPezClasses
 * @author Mark Simchock <mark.simchock@alchemyunited.com>
 * @since 0.5.0
 * @license TODO
 */
 
/**
 * == Change Log == 
 *
 * --- 27 September 2014 - Ready
 *
 */
 
/**
 * == TODO == 
 *
 * add_filter( 'style_loader_src', 'remove_wp_ver_css_js', 9999 ); // remove WP version from css
 * add_filter( 'script_loader_src', 'remove_wp_ver_css_js', 9999 ); // remove Wp version from scripts
 * 
 * remove WP version from scripts function remove_wp_ver_css_js( $src ) { if ( strpos( $src, 'ver=' ) ) $src = remove_query_arg( 'ver', $src ); return $src; }
 */
 

// No WP? Die! Now!!
if (!defined('ABSPATH')) {
	header( 'HTTP/1.0 403 Forbidden' );
    die();
}

if (! class_exists('Class_WP_ezClasses_Theme_Head_Cleanup_1') ) {
  class Class_WP_ezClasses_Theme_Head_Cleanup_1 extends Class_WP_ezClasses_Master_Singleton {
  
    protected $_arr_init;
	
	protected function __construct() {
	  parent::__construct();
	}
	
	/**
	 *
	 */
	public function ezc_init($arr_args = ''){
	
	//  $arr_init_defaults = $this->init_defaults();
	  $this->_arr_init = WP_ezMethods::ez_array_merge(array($this->init_defaults(), $arr_args));
	  
	  add_action( 'init', array($this, 'wp_head_cleanup'), 50);
	  
	}
		
	
	/**
	 * bool to turn on (or off) which cleanups you want to do, or not.
	 */
    public function init_defaults(){
	
	  $arr_defaults = array(

		// 'wp_head' - start
		
		//set_a
		'rsd_link'	 						=> true, // http://www.themelab.com/remove-code-wordpress-header
		'wlwmanifest_link'					=> true,
		'index_rel_link'					=> true,			
		'wp_generator'						=> true,		// WP version
		
		// set_b
		'parent_post_rel_link'				=> true, 		// 10, 0
		'start_post_rel_link' 				=> true,		// 10, 0
		'adjacent_posts_rel_link_wp_head'	=> true,		// 10, 0	
		'wp_shortlink_wp_head'				=> true, 		// 10, 0 
		
		// set_c
		'feed_links'						=> true, 		// , 2);
		
		//set_d
		'feed_links_extra'					=> true 		// ,3);
		
		// 'wp_head' - end
	
        ); 
	  return $arr_defaults;
	}
	
	/**
	 * the remove_action() for each set is slightly different. this helps to simplify the code and reduce typing out if elseif
	 */
	public function set_map(){
	
	  $arr_set_map = array(
	  
		//set_a
		'rsd_link'	 						=> 'a',
		'wlwmanifest_link'					=> 'a',
		'index_rel_link'					=> 'a',			
		'wp_generator'						=> 'a',		
		
		// set_b
		'parent_post_rel_link'				=> 'b', 	// 10, 0
		'start_post_rel_link' 				=> 'b',		// 10, 0
		'adjacent_posts_rel_link_wp_head'	=> 'b',		// 10, 0	
		'wp_shortlink_wp_head'				=> 'b', 	// 10, 0 
		
		// set_c
		'feed_links'						=> 'c', 	// , 2);
		
		//set_d
		'feed_links_extra'					=> 'd', 		// ,3);
	  
	    );
		
	  return  $arr_set_map;
	}
	
	/**
	 * This is where the magic happens. 
	 */
	public function wp_head_cleanup(){
	
	    $arr_wp_head_cleanup = $this->_arr_init;
		$arr_set_map = $this->set_map();
		
      // bang out what remains
	  foreach ( $arr_wp_head_cleanup as $str_key => $bool_var ){
	    
		// is there a set_map?  and is the bool true? 
		if ( isset($arr_set_map[$str_key]) && $bool_var === true ){
		
		  // which set?
		  if ( $arr_set_map[$str_key] == 'a'){
		    remove_action('wp_head', $str_key );
			
		  } elseif ( $arr_set_map[$str_key] == 'b'){
		    remove_action('wp_head', $str_key, 10, 0);
			
		  } elseif ( $arr_set_map[$str_key] == 'c'){
		    remove_action('wp_head', $str_key, 2 );
			
		  } elseif ( $arr_set_map[$str_key] == 'd'){
		    remove_action('wp_head', $str_key, 3 );
		  }
	    }
	  } 
	}
	
  }
}