<?php
/**
Plugin Name: SuperSlider-PreviousNext-Thumbs
Plugin URI: http://wp-superslider.com/superslider/superslider-previousNext-thumbs
Description: A previous-next post, thumbnail navigation creator. Works specifically on the single post pages. Uses Mootools 1.2 javascript. 
Author URI: http://wp-superslider.com
Author: Daiv Mowbray
Version: 0.2


*/

/*  Copyright 2008  Daiv Mowbray  (email : daiv.mowbray@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('ssPnext')) {
    class ssPnext	{
				/**
		* @var string   The name the options are saved under in the database.
		*/
		var $js_path;
		var $PnextOpOut;
		var $optionsName = "ssPnext_options";
		var $Pnext_domain = 'superslider-Pnext';
		var $base_over_ride;
		var $show_over_ride;
		var $ssBaseOpOut;
        
		function set_Pnext_paths()
			{
			if ( !defined( 'WP_CONTENT_URL' ) )
				define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
			if ( !defined( 'WP_CONTENT_DIR' ) )
				define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
			if ( !defined( 'WP_PLUGIN_URL' ) )
				define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
			if ( !defined( 'WP_PLUGIN_DIR' ) )
				define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
			if ( !defined( 'WP_LANG_DIR') )
				define( 'WP_LANG_DIR', WP_CONTENT_DIR . '/languages' );            
           
			}
		
		/**
		* PHP 4 Compatible Constructor
		*/
		function ssPnext(){//$this->__construct();
			
			ssPnext::Pnext();
		
		}
		
		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
		
			self::Pnext();
		
		}
		
		function language_switcher() {

			$superslider_Pnext_locale = get_locale();
			$superslider_Pnext_mofile = dirname(__FILE__) . "/languages/superslider-pnext-".$superslider_Pnext_locale.".mo";
			$plugin_dir = basename(dirname(__FILE__));

			load_plugin_textdomain($Pnext_domain, 'wp-content/plugins/languages/' . $plugin_dir );		
		}
		
		/**
		* Retrieves the options from the database.
		* @return array
		*/
		function set_Pnext_options() {
			$PnextOptions = array(
				"load_moo"    => "on",
				"css_load"    => "default",
				"css_theme"   => "default", 
				"morph_Pnext" => "on",
				//"opacity"     => "0.7",
				"resize_dur"  => "800",
				"Pnext_class" => "",
				"trans_type"	=> "Sine",
				"trans_typeout" => "easeOut",
				"thumb_w"  => "180",
				"thumb_h"  => "30",
				"thumb_crop"  => "true",
				"thumbsize"   =>  "thumbnail",
				"previous_text"     =>  "View previous entry",
				"next_text"     =>  "View next entry",
				"title_length"     =>  "22",
				"excluded_categories"     =>  "",
				"post_in_cat"     =>  "true",
				"num_ran"     => "2",
				"make_thumb"   =>  "on",
				"auto_insert"   =>  "on",
				"pnext_location"   =>  "loop_end"
				);


			$savedOptions = get_option($this->optionsName);
				if (!empty($savedOptions)) {
					foreach ($savedOptions as $key => $option) {
						$PnextOptions[$key] = $option;
					}
			}
			update_option($this->optionsName, $PnextOptions);
				return $PnextOptions;
		}
		
		/**
		* Saves the admin options to the database.
		*/
		function savePnextOptions(){
			update_option($this->optionsName, $this->PnextOptions);
		}
		
		/**
		* Loads functions into WP API
		* 
		*/
		function Pnext_init() {

			$this->PnextOptions = $this->set_Pnext_options();
			$this->set_Pnext_paths();
			
			// lets see if the base plugin is here and get its options
			if (class_exists('ssBase')) {
					$this->ssBaseOpOut = get_option('ssBase_options');
					$this->base_over_ride = $this->ssBaseOpOut[ss_global_over_ride];
				}else{
				$this->base_over_ride = 'false';
			}
			
			// lets see if the ss-Show plugin is here
			if (class_exists('ssShow')) {
					$this->show_over_ride = 'true';
				}else{
				$this->show_over_ride = 'false';
				}
			
			extract($this->PnextOptions);
			    	   
            //$this->language_switcher();
            
            // remove_action( 'template', 'previous_post_link', 1 );
    	   // remove_action( 'template',  'next_post_link', 1 );
    	   
            $this->js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__) ) . '/js/';
			
  			wp_register_script('moocore', $this->js_path.'mootools-1.2.3-core-yc.js', NULL, '1.2.3');
			
			wp_register_script( 'moomore', $this->js_path. 'mootools-1.2.3.1-more.js', array( 'moocore' ), '1.2.3');
			
			if ( (class_exists('ssBase')) && ($this->ssBaseOpOut['ss_global_over_ride']) ) { extract($this->ssBaseOpOut); }

            if ($css_load == 'default') {
                    $cssFile = WP_PLUGIN_URL.'/superslider-previousnext-thumbs/plugin-data/superslider/ssPnext/'.$css_theme.'/'.$css_theme.'.css';
    
                } elseif ($css_load == 'pluginData') {
                    $cssFile = WP_CONTENT_URL.'/plugin-data/superslider/ssPnext/'.$css_theme.'/'.$css_theme.'.css';
     
                }elseif ($css_load == 'off') {
                    $cssFile = '';
                    
             }
          
            wp_register_style('superslider_Pnext', $cssFile);


            if ( $morph_Pnext == 'on' ) {  			
               add_action ( 'wp_enqueue_scripts', array(&$this,'Pnext_add_javascript') );
               add_action ( 'wp_footer', array(&$this,'Pnext_starter') );			   
             }
             if ($css_load != 'off' ) {
                 add_action ( 'wp_print_styles', array(&$this,'Pnext_add_css') );
               }
             
             if ($auto_insert == 'on') {  
                 add_action ( 'template_redirect', array(&$this,'Pnext_add_thumb_nav' ) );
             }


		}
		
    /**
    * Outputs the HTML for the admin sub page.
    */
    function Pnext_ui(){
        global $base_over_ride;
        global $Pnext_domain;
        include_once 'admin/superslider-pnext-ui.php';
    } 
    
    function Pnext_admin_pages(){
    
        if (  function_exists('add_options_page') ) {
            if (  current_user_can('manage_options') ) {
                if (!class_exists('ssBase')) $plugin_page = add_options_page(__('Superslider Pnext', 'superslider-Pnext'),__('SuperSlider-Pnext', 'superslider-Pnext'), 8, 'superslider-pnext', array(&$this, 'Pnext_ui'));
                add_filter('plugin_action_links', array(&$this, 'filter_plugin_Pnext'), 10, 2 );	
                
                add_action ( 'admin_print_styles', array(&$this,'ssbox_admin_style'));
                if (!class_exists('ssBase')) add_action('admin_print_scripts-'.$plugin_page, array(&$this,'Pnext_admin_script'));
            }					
        }
    }
    function Pnext_admin_script(){
          wp_enqueue_script('jquery-ui-tabs');	// this will load the jquery tabs script into head
    
    }
    /**
    * Add link to options page from plugin list.
    */
    function filter_plugin_Pnext($links, $file) {
         static $this_plugin;
            if (  ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

        if (  $file == $this_plugin )
            $settings_link = '<a href="admin.php?page=superslider-pnext">'.__('Settings', $Pnext_domain).'</a>';
            array_unshift( $links, $settings_link ); //  before other links
            return $links;
    }		
    /**
    *	remove options from DB upon deactivation
    */
    function Pnext_ops_deactivation(){		
        delete_option($this->optionsName);
        delete_option('prenext_size_w');
        delete_option('prenext_size_h');
        delete_option('prenext_crop');
    }

    function Pnext_add_javascript(){
    
       extract($this->PnextOpOut);

       if ( (!is_admin()) && (function_exists('wp_enqueue_script')) && ( $morph_Pnext == 'on') && ( is_singular() )) {
            if ( ($this->base_over_ride != "on") && ($load_moo == 'on') ) {
               wp_enqueue_script('moocore');		
               wp_enqueue_script('moomore');
            }
        }
    }
	
    /**
    * Adds a link to the stylesheet in the header
    */
    function Pnext_add_css() {
    
        //extract($this->PnextOpOut);
        $css_load = $this->PnextOpOut[css_load];
         
         if ( ($css_load !== 'off') && (is_singular() ) ){
           
            wp_enqueue_style( 'superslider_Pnext');
          
          }
    }
    
    function Pnext_starter(){
    
          //extract($this->PnextOpOut);

   $mytrans = "Fx.Transitions.".$this->PnextOpOut[trans_type].".".$this->PnextOpOut[trans_typeout];
                   
        $mystarter = "
        var pnext = $$('div.button_wrap');
        pnext.each(function(movePnext, i) {
        var pnextHit = movePnext.getElements('.slidebttn');
        var pnextMove = movePnext.getElement('.pnext_tag');
        var span = pnextMove.getElement('span');
        var PnextMorph = new Fx.Morph(pnextMove, {
                      unit: 'px',
                      link: 'cancel',
                      duration: ".$this->PnextOpOut[resize_dur].", 
                      transition: ".$mytrans.",
                      fps: 30
        });
        pnextHit.addEvents({
            mouseenter: function(e) {  
               PnextMorph.start('.pnext_tag_active');
               span.fade('in');
               pnextHit.addClass('button_c');
               },
            mouseleave: function(e) {          
                PnextMorph.start('.pnext_tag_inactive');
                span.fade('out');
                pnextHit.removeClass('button_c');
                }
           });       
        });";
          
    $starter .= "\n"."<script type=\"text/javascript\">\n";
    $starter .= "\t"."// <![CDATA[\n";		
    $starter .= "window.addEvent('domready', function() {
                ".$mystarter."					
                });\n";
    $starter .= "\t".'// ]]>';
    $starter .= "\n".'</script>'."\n";
                        
    echo $starter;
    
    }
		
    function Pnext() {
        
        $this->PnextOpOut = get_option($this->optionsName);
    
        //extract($this->PnextOpOut);
         
        register_activation_hook(__FILE__, array(&$this,'Pnext_init') ); //http://codex.wordpress.org/Function_Reference/register_activation_hook
        register_deactivation_hook( __FILE__, array(&$this,'Pnext_ops_deactivation') ); //http://codex.wordpress.org/Function_Reference/register_deactivation_hook
        
        add_action ( 'init', array(&$this,'Pnext_init' ) );			
        add_action ( 'admin_menu', array(&$this,'Pnext_admin_pages'));
        
        add_action ( 'admin_init', array(&$this,'Pnext_create_thumbs' ) );
        
		add_action( 'admin_init', array(&$this, 'Pnext_create_media_page') );
    }
    
    function Pnext_add_thumb_nav() {    	   
    	   
    	   //extract($this->PnextOpOut);
    	   $pnext_location = $this->PnextOpOut[pnext_location];
    	   
    	   if ( ( is_singular()) && ($pnext_location == 'content_before' || $pnext_location == 'content_after') ) {
    	       
    	       add_action ( 'the_content', array(&$this,"ss_previous_next_content")); 
    	   
    	   } elseif ( is_singular()) {
    	       
    	       add_action ( $pnext_location, array(&$this,"ss_previous_next_nav"));
    	   
    	   }
    	   
    	}
        // if location is above or below content
    function ss_previous_next_content($content = '') {
        
        //extract($this->PnextOpOut);
        $pnext_location = $this->PnextOpOut[pnext_location];

        switch($pnext_location) {
        
        case 'content_before' :            
                echo $this->ss_previous_next_nav();
                echo $content;
            break;
            
        case 'content_after' :            
                echo $content;
                echo $this->ss_previous_next_nav();
            break;  

        }

    }
    /**
    */
    
    public function ss_previous_next_nav() {
    
        extract($this->PnextOpOut); 

        $thumb_w = get_option($thumbsize.'_size_w');
        $thumb_h = get_option($thumbsize.'_size_h');
        
        $previouspost = get_previous_post($post_in_cat, $excluded_categories);
        $nextpost = get_next_post($post_in_cat, $excluded_categories);

        if ($previouspost != null || $nextpost != null ) $previous_next = '<div id="pnext-nav" class="navigation">';
                  
             if ($previouspost != null) {
             
               $preid = $previouspost->ID;
              
               $image = ssPnext::ss_get_prenext_image($preid, 'previous');
               $title = ssPnext::ss_Pnext_titles($previouspost->post_title, $title_length);
               $link = get_permalink($preid);

               $previous  = '<div class="button_wrap nav_previous alignleft"><a href="'.$link.'" class="slidebttn">';
               $previous .= '<img class=" nextpost_thumb '.$image[3].'" src="' . $image[0] . '" alt="' . $title . '" width="' . $thumb_w . '" height="' . $thumb_h . '" />';
               $previous .= '</a><br />
                    <div class="pnext_tag" id="pnext_tag1"><span>'.$previous_text.'</span></div>
                    <a class="button_bLeft slidebttn" title="'.$previouspost->post_title.'" id="button_bLeft" href="'.$link.'">'.$title.'</a>
                    </div>';
               $previous_next .=  $previous;
               }

            if ($nextpost != null) {
                
                $nextid = $nextpost->ID;   
              
                $image = ssPnext::ss_get_prenext_image($nextid, 'next');
                $title = ssPnext::ss_Pnext_titles($nextpost->post_title, $title_length);
                $link = get_permalink($nextid);

                $next = '<div class="button_wrap nav_next alignright"><a href="'.$link.'" class="slidebttn">';
                $next .= '<img class=" nextpost_thumb '.$image[3].'" src="' . $image[0] . '" alt="' . $title . '" width="'.$thumb_w.'" height="'.$thumb_h.'" />';
                $next .= '</a><br />
                    <div class="pnext_tag" id="pnext_tag2"><span>'.$next_text.'</span></div>
                    <a class="button_bRight slidebttn" title="'.$nextpost->post_title.'" id="button_bRight" href="'.$link.'">'.$title.'</a>
                    </div>';
               $previous_next .= $next ;
              
               }

        if ($previouspost != null || $nextpost != null ) $previous_next .= '<br style="clear:both;" /></div><br style="clear:both;" />';

        echo $previous_next;

    }

    function ss_get_prenext_image ( $id, $prenext ) {
           
           extract($this->PnextOpOut);
                
                // check first for a post 2.9 post thumb setting
            if ( function_exists( 'get_the_post_thumbnail' )) {
             
               $myid = get_post_thumbnail_id($id);

               $image = wp_get_attachment_image_src($myid, $thumbsize );
               
               if ( $image ) {
     
               $image[3] = 'postthumbnail_'.$prenext;
               return $image;
               }
           }
           
                // check for any attachments as there is no post thumb         
            if ( empty($image) ) {
                
                $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image') );	//, 'order' => $order, 'orderby' => $orderby
             }
             
            if ( !empty($attachments) ) {
                    foreach ( $attachments as $id => $attachment ) :    
                        $image = wp_get_attachment_image_src($id, $thumbsize ); 
                        $image[3] = 'attached_'.$prenext;
                     break;
                    endforeach;
                 
            } elseif ( empty($image) ) {

                // If no image in post use default image function 
                // First we get the category
            $cat = get_the_category($id);
            $cat = $cat[0];
            $cat = 'cat-'.$cat->slug;

            $image = ssPnext::Pnext_default_image($cat, $prenext);
            }
           
           return $image;
    }
            //create substring of the title to the last space and add dots
    public function ss_Pnext_titles($title, $title_length) {
                
        if (strlen($title) >= ($title_length+1)){
            $short = substr($title,0,$title_length);	
            if (substr_count($short," ") > 1) {
                $lastspace = strrpos($short," ");
                $short = substr($short,0,$lastspace);
            }
            $dots = '...';
        } else { 
            $short = $title;
            $dots = '';
        }
      $title = $short . $dots;
      return $title;
    }
    
 
    // no image in this post, lets get a default 
    function Pnext_default_image($cat, $prenext){        
        
        extract($this->PnextOptions);	
        
        if ($css_load == 'default') {
                $default_image_path = WP_PLUGIN_URL.'/superslider-previousnext-thumbs/plugin-data/superslider/ssPnext/pnext-thumbs/';
            } elseif ($css_load == 'pluginData') {
                $default_image_path = WP_CONTENT_URL.'/plugin-data/superslider/ssPnext/pnext-thumbs/'; 
            }
         $default_image = $default_image_path.$cat.'-'.$prenext.'.jpg';
        if (file_exists(ABSPATH."/".substr($default_image,stripos($default_image,"wp-content")))) {            
            $image[0] = $default_image;
            $image[3] = 'category_'.$prenext;
            
        } else {
            $n = mt_rand(1, $num_ran);          
            $image[0] = $default_image_path.'random-image-'.$n.'-'.$prenext.'.jpg';         
            $image[3] = 'random_'.$prenext;
        }
        
        return $image;
    }

    function load_Pnext(){
        
       extract($this->PnextOptions);	
        
       if (!is_admin() && (is_singular() )){
            if ($css_load != 'off' ) { 
                add_action ( 'wp_print_styles', array(&$this,'Pnext_add_css' ));
               
             }
            if ( $morph_Pnext == 'on'){  
             
             add_action ( 'wp_print_scripts', array(&$this,'Pnext_add_javascript' ));
             add_action ( "wp_footer", array(&$this,"Pnext_starter"));
            }

        }
    }
            
    function ssbox_admin_style(){
        if ($this->base_over_ride != "on") {
            $cssAdminFile = WP_PLUGIN_URL.'/superslider-previousnext-thumbs/admin/ss_admin_style.css';
            wp_register_style('superslider_admin', $cssAdminFile);
            wp_enqueue_style( 'superslider_admin');
        }	
        
    }
    
    
    /*
     * @param string $id String for use in the 'id' attribute of tags.
 * @param string $title Title of the field.
 * @param string $callback Function that fills the field with the desired content. The function should echo its output.
 * @param string $page The type of settings page on which to show the field (general, reading, writing, ...).
 * @param string $section The section of the settingss page in which to show the box (default, ...).
 * @param array $args Additional argument
   
   
   	//	add_settings_field($id,               $title,       $callback,                           $page,     $section = 'default', $args = array())
		add_settings_field('mediatag_base', 'Media-Tags', 'mediatags_setting_permalink_proc', 'permalink', 'optional');

   
   $page = options-media.php
   */
    function Pnext_create_media_page() {
    			
    		register_setting( 'media', 'prenext_size_w' );
    		register_setting( 'media', 'prenext_size_h' );
    		register_setting( 'media', 'prenext_crop' );

    			//add_settings_section($id, $title, $callback, $page)
			add_settings_section('pnext_section', 'SuperSlider-PreviousNext Image Sizes', array(&$this, 'Pnext_media_section'), 'media');
			
			add_settings_field('prenext_size_w', 'PreNext Width', array(&$this, 'Pnext_media_w'), 'media', 'pnext_section');
			add_settings_field('prenext_size_h', 'PreNext Height', array(&$this, 'Pnext_media_h'), 'media', 'pnext_section');
			add_settings_field('prenext_crop', 'PreNext Crop', array(&$this, 'Pnext_media_crop'), 'media', 'pnext_section');

    }

    function Pnext_media_section(){
      $section = '<span class="description"> More image sizes added by your SuperSlider plugin. Adding prenext to the standard thumbnail, medium, and large sizes.</span>';        
       echo $section;
	}
   
	function Pnext_media_w(){        
        $Pnext_w = get_option ('prenext_size_w');
        echo '<label for="Pnext_size_w">Width</label><input name="Pnext_size_w" id="Pnext_size_w" type="text" value="'. $Pnext_w.'" class="small-text" />'; 
       
	}
	function Pnext_media_h(){
        $Pnext_h = get_option('prenext_size_h');       
        echo '<label for="Pnext_size_h">Height</label><input name="Pnext_size_h" id="Pnext_size_h" type="text" value="'. $Pnext_h.'" class="small-text" />
        <br />';
	}
	function Pnext_media_crop(){
        $Pnext_crop = get_option('prenext_crop');
          echo '<input type="checkbox"'; 
            checked('1', $Pnext_crop);        
          echo ' value="1" id="Pnext_crop" name="Pnext_crop">
            <label for="Pnext_crop">';
            _e('Crop PreNext image to exact dimensions (normally thumbnails are proportional)'); 
          echo '</label>';	
	}
	
	/*
	* Time to make thumbnails
	*
	*/
	function Pnext_create_thumbs(){
			extract($this->PnextOptions);
			//if ($make_thumb == 'on') {
			    $this->listnewimages();
			
			    add_filter( 'intermediate_image_sizes',  array(&$this, 'additional_thumb_sizes') );			
			//}

	}
	
	function additional_thumb_sizes( $sizes ) {
			$sizes[] = "prenext";
			return $sizes;
	}

	function listnewimages() { 		
	   extract($this->PnextOptions);	
        
        if ($thumb_crop == true) { $crop = 1; }else { $crop = 0;}
		if( FALSE == get_option('prenext_size_w') )
			{	
				add_option('prenext_size_w', $thumb_w );
				add_option('prenext_size_h', $thumb_h);
				add_option('prenext_crop', $crop);
			}			
	}

    }// end class Pnext
}// end if class Pnext

//instantiate the class
if (class_exists('ssPnext')) {
	$myssPnext = new ssPnext();
}
?>