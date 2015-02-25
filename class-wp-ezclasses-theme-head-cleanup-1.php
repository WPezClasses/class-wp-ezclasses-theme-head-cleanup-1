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
 * -- 25 Feb 2015 - Ready
 * --- Updated to new ez standard(s)
 *
 * -- 27 September 2014 - Ready
 *
 */
 
/**
 * == TODO == 
 *
 * add_filter( 'style_loader_src', 'modify_wp_ver_css_js', 9999 ); // remove WP version from css
 * add_filter( 'script_loader_src', 'modify_wp_ver_css_js', 9999 ); // remove Wp version from scripts
 * 
 * remove WP version from scripts function 
 * modify_wp_ver_css_js( $src ) { if ( strpos( $src, 'ver=' ) ) $src = remove_query_arg( 'ver', $src ); return $src; }
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
	public function ez__construct($arr_args = ''){
	
	//  $arr_init_defaults = $this->init_defaults();
	  $this->_arr_init = WPezHelpers::ez_array_merge(array($this->init_defaults(), $arr_args));
	  
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
	
	  /*
	   * - - IMPORTANT - -
	   * Some might find this approach somewhat unorthodox. However - for example - an if ( isset($arr_set_map['rsd_link']['a']) ){}
	   * is said to faster than if ( $arr_set_map['rsd_link'] == 'a' ) {}
	   *
	   * See method wp_head_cleanup() below for how this is being used. 
	   */
	  
		//set_a
		$arr_set_map['rsd_link']['a']							= true;
		$arr_set_map['wlwmanifest_link']['a']					= true;
		$arr_set_map['index_rel_link']['a']						= true;		
		$arr_set_map['wp_generator']['a']						= true;	
		
		// set_b
		$arr_set_map['parent_post_rel_link']['b']				= true; 	// 10, 0
		$arr_set_map['start_post_rel_link']['b'] 				= true;	// 10, 0
		$arr_set_map['adjacent_posts_rel_link_wp_head']['b']	= true;	// 10, 0	
		$arr_set_map['wp_shortlink_wp_head']['b']				= true; 	// 10, 0 
		
		// set_c
		$arr_set_map['feed_links']['c']							= true; 	// , 2);
		
		//set_d
		$arr_set_map['feed_links_extra']['d']					= true; 	// ,3);
	  
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
	  
	    /**
		 * - - IMPORTANT - -
		 * if elseif is said to be slight faster than Switch / Case.
		 * Over-optimizing? Perhaps. But better habits are better than bad one, eh? :)
		 */
	    
		// is there a set_map?  and is the bool true? 
		if ( isset($arr_set_map[$str_key]) && $bool_var === true ){
		
		  // which set?
		  if ( isset($arr_set_map[$str_key]['a']) ){
		    remove_action('wp_head', $str_key );
			
		  } elseif ( isset($arr_set_map[$str_key]['b']) ){
		    remove_action('wp_head', $str_key, 10, 0);
			
		  } elseif ( isset($arr_set_map[$str_key]['c']) ){
		    remove_action('wp_head', $str_key, 2 );
			
		  } elseif ( isset($arr_set_map[$str_key]['d']) ){
		    remove_action('wp_head', $str_key, 3 );
		  }
	    }
	  } 
	}
	
  }
}