<?php
/**
Plugin Name: SuperSlider-PreviousNext-Thumbs
Plugin URI: http://superslider.daivmowbray.com/superslider/superslider-previousNext-thumbs
Description: A previous-next post, thumbnail navigation creator. Works specifically on the single post pages. Uses Mootools 1.4.5 javascript. 
Author URI: http://www.daivmowbray.com
Author: Daiv Mowbray
Version: 2.1


*/

/*  Copyright 2011  Daiv Mowbray  (email : daiv.mowbray@gmail.com)

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
		var $plugin_domain = 'superslider-Pnext';
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
		  global $plugin_domain;

			$superslider_login_locale = get_locale();
			$superslider_login_mofile = dirname(__FILE__) . "/languages/superslider-login-".$superslider_login_locale.".mo";
			$plugin_dir = dirname(plugin_basename(__FILE__));
			load_plugin_textdomain($plugin_domain, false, $plugin_dir.'/languages/' );		
		}
		
		function Pnext() {        

        $this->PnextOpOut = get_option($this->optionsName);
         
        register_activation_hook(__FILE__, array(&$this,'Pnext_init') ); //http://codex.wordpress.org/Function_Reference/register_activation_hook
        register_deactivation_hook( __FILE__, array(&$this,'Pnext_ops_deactivation') ); //http://codex.wordpress.org/Function_Reference/register_deactivation_hook
        
        add_action ( 'init', array(&$this,'Pnext_init' ) );			
        add_action ( 'admin_menu', array(&$this, 'plugin_setup_optionspage'));        
        add_action ( 'admin_init', array(&$this, 'Pnext_create_thumbs' ) );        
		add_action ( 'admin_init', array(&$this, 'Pnext_create_media_page') );
    	}
    	
    	/**
		* Saves the admin options to the database.
		*/
		function savePnextOptions(){
			update_option($this->optionsName, $this->PnextOptions);
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
				"text_over"     => "off",
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
				"pnext_location"   =>  "content_after",
				"text_length" => "120",
                "text_type" => "content",
                "short_replace" => " ",
				'delete_options' => ""
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
		* Loads functions into WP API
		* 
		*/
		function Pnext_init() {

			$this->PnextOptions = $this->set_Pnext_options();
			$this->set_Pnext_paths();
			$admin_js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/admin/js/';
			
			 $this->language_switcher();
			 
			// lets see if the base plugin is here and get its options
			if (class_exists('ssBase')) {
					$this->ssBaseOpOut = get_option('ssBase_options');
					$this->base_over_ride = $this->ssBaseOpOut['ss_global_over_ride'];
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
			    	               
            remove_action( 'template', 'previous_post_link', 1 );
    	    remove_action( 'template',  'next_post_link', 1 );
    	   
            $this->js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__) ) . '/js/';
			
  			wp_register_script('moocore', $this->js_path.'mootools-core-1.4.5-full-compat-yc.js', NULL, '1.4.5');			
			wp_register_script( 'moomore', $this->js_path. 'mootools-more-1.4.0.1.js', array( 'moocore' ), '1.4.0.1');
			
			if ( (class_exists('ssBase')) && ($this->ssBaseOpOut['ss_global_over_ride']) ) { extract($this->ssBaseOpOut); }
			
			$cssAdminPath = WP_PLUGIN_URL.'/superslider-previousnext-thumbs/admin/';    			
    		
    		wp_register_style('superslider_admin', $cssAdminPath.'ss_admin_style.css');
    		wp_register_style('superslider_admin_tool', $cssAdminPath.'ss_admin_tool.css');
  			
  			wp_register_script( 'jquery-dimensions', $admin_js_path.'jquery.dimensions.min.js', array( 'jquery-ui-core' ), '2', false);
  			wp_register_script( 'jquery-tooltip', $admin_js_path.'jquery.tooltip.min.js', array( 'jquery-dimensions' ), '2', false);
  			wp_register_script( 'superslider-admin-tool', $admin_js_path.'superslider-admin-tool.js', array( 'jquery', 'jquery-tooltip' ), '2', false);


            switch ($css_load) {
            case 'default':
                $cssFile = WP_PLUGIN_URL.'/superslider-previousnext-thumbs/plugin-data/superslider/ssPnext/'.$css_theme.'/'.$css_theme.'.css';
                break;
            case 'pluginData':
                $cssFile = WP_CONTENT_URL.'/plugin-data/superslider/ssPnext/'.$css_theme.'/'.$css_theme.'.css';
                break;
            case 'theme':
                $cssFile = get_stylesheet_directory_uri().'/plugin-data/superslider/ssPnext/'.$css_theme.'/'.$css_theme.'.css';
                break;
            case 'off':
                $cssFile = '';
                break;
            }
        
            wp_register_style('superslider_Pnext', $cssFile);
            
            if ( $morph_Pnext == 'on' ) {  			
               add_action ( 'wp_enqueue_scripts', array(&$this,'Pnext_add_javascript') );
               add_action ( 'wp_footer', array(&$this,'Pnext_starter') );			   
             }
             if ($css_load != 'off' ) {
                 add_action ( 'wp_print_styles', array(&$this,'Pnext_add_css') );
             }
 
             if ($auto_insert == 'on' && !is_page()) {  // && is_singular()        
                 add_action ( 'template_redirect', array(&$this,'Pnext_add_thumb_nav' ) );
             }

		}
		
		/**
		* Outputs the HTML for the admin sub page.
		*/
	function Pnext_ui(){
		global $base_over_ride;
		global $plugin_domain;
		include_once 'admin/superslider-pnext-ui.php';
	} 
	
	function plugin_setup_optionspage(){    
		if (  function_exists('add_options_page') && current_user_can('manage_options')) {
				$plugin_page = add_options_page(__('Superslider Pnext', 'superslider-Pnext'),__('SuperSlider-Pnext', 'superslider-Pnext'), 'manage_options', 'superslider-pnext', array(&$this, 'Pnext_ui'));
				add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_Pnext'), 10, 2 );	
				
				add_action ( 'admin_print_scripts-'.$plugin_page, array(&$this,'ss_admin_style'));
				add_action ( 'admin_print_scripts-'.$plugin_page, array(&$this,'ss_admin_script'));				
		}
	}
	function ss_admin_script(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core');
		wp_enqueue_script( 'jquery-ui-tabs');  
	    wp_enqueue_script( 'jquery-tooltip' );
		wp_enqueue_script( 'superslider-admin-tool' );
	
	}
		            
    function ss_admin_style(){
        wp_enqueue_style( 'superslider_admin');
    	wp_enqueue_style( 'superslider_admin_tool');
        
    }
		/**
		* Add link to options page from plugin list.
		*/
		function filter_plugin_Pnext($links, $file) {
			global $plugin_domain;
			static $this_plugin;
				if (  ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);
	
			if (  $file == $this_plugin )
				$settings_link = '<a href="admin.php?page=superslider-pnext">'.__('Settings', $plugin_domain).'</a>';
				array_unshift( $links, $settings_link ); //  before other links
				return $links;
		}		
    /**
    *	remove options from DB upon deactivation
    */
    function Pnext_ops_deactivation(){		
        if($this->PnextOpOut['delete_options'] == true){
            delete_option($this->optionsName);
            delete_option('prenext_size_w');
            delete_option('prenext_size_h');
            delete_option('prenext_crop');
        }
    }

    function Pnext_add_javascript(){
       // $morph_Pnext = $this->PnextOpOut['morph_Pnext'];
      //  $load_moo = $this->PnextOpOut['load_moo'];
       if ( (!is_admin()) && (function_exists('wp_enqueue_script')) && ( $this->PnextOpOut['morph_Pnext'] == 'on') && ( is_singular() )) {
            if ( ($this->base_over_ride != "on") && ($this->PnextOpOut['load_moo'] == 'on') ) {
               wp_enqueue_script('moocore');		
               wp_enqueue_script('moomore');
            }
        }
    }
	
    /**
    * Adds a link to the stylesheet in the header
    */
    function Pnext_add_css() {
        //$css_load = $this->PnextOpOut['css_load'];         
         if ( ($this->PnextOpOut['css_load'] !== 'off') && (is_singular() ) ){           
            wp_enqueue_style( 'superslider_Pnext');          
          }
    }
    
    function Pnext_starter(){
       $mytrans = "Fx.Transitions.".$this->PnextOpOut['trans_type'].".".$this->PnextOpOut['trans_typeout'];
                       
        $mystarter = "
            var pnext = $$('div.button_wrap'); pnext.each(function(movePnext, i) { var pnextHit = movePnext.getElements('.slidebttn'); var pnextMove = movePnext.getElement('.pnext_tag'); var span = pnextMove.getElement('span'); var PnextMorph = new Fx.Morph(pnextMove, { unit: 'px', link: 'cancel', duration: ".$this->PnextOpOut['resize_dur'].", transition: ".$mytrans.", fps: 30
            });
            pnextHit.addEvents({
                mouseenter: function(e) { PnextMorph.start('.pnext_tag_active'); span.fade('in'); pnextHit.addClass('button_c'); },
                mouseleave: function(e) { PnextMorph.start('.pnext_tag_inactive'); span.fade('out'); pnextHit.removeClass('button_c'); }
               });       
            });";
              
        $starter = "\n"."<script type=\"text/javascript\">\n";
        $starter .= "\t"."// <![CDATA[\n";		
        $starter .= "window.addEvent('domready', function() {
                    ".$mystarter."					
                    });\n";
        $starter .= "\t".'// ]]>';
        $starter .= "\n".'</script>'."\n";
                            
        echo $starter;
    
    }
    
    
    function Pnext_add_thumb_nav() {
    	  // $auto_insert = $this->PnextOpOut['auto_insert'];

		if ( is_single() && $this->PnextOpOut['auto_insert'] == 'on' ) { 
    	       add_filter ( 'the_content', array(&$this,"ss_pnext_content"));
    	   } elseif ( is_single() ) { 
    	       add_filter ( $pnext_location, array(&$this,"ss_previous_next_nav"));  
    	   }
    	}
        // if location is above or below content
    function ss_pnext_content($content = '') {

        $pnext_location = $this->PnextOpOut['pnext_location'];	
        $noecho = true;

        switch($pnext_location) {
        case 'content_after' :                         
                $content .= $this->ss_previous_next_nav($noecho);
                return $content;
            break;  
        case 'content_before' :   
                $content = $this->ss_previous_next_nav($noecho) . $content;
                return $content;
            break;
        case 'content_before_after' :
                $thumbs = $this->ss_previous_next_nav($noecho);
                $content = $thumbs . $content . $thumbs;
                return $content;
            break;
        }

    }
    
    public function ss_previous_next_nav($noecho) {    
        extract($this->PnextOpOut); 

        $thumb_w = get_option($thumbsize.'_size_w');
        $thumb_h = get_option($thumbsize.'_size_h');
        
        if(is_singular()) {
        	$previouspost = get_previous_post($post_in_cat, $excluded_categories);
        	$nextpost = get_next_post($post_in_cat, $excluded_categories);
        }

        if ($previouspost != null || $nextpost != null ) $previous_next = '<br style="clear:both;height:0px;" /><div id="pnext-nav" class="pnext-navigation">';
                  
             if ($previouspost != null || $previouspost != '') {
         		
               $preid = $previouspost->ID;
               $ptext ='';
               if ($text_type == 'content') { $ptext = $previouspost->post_content; }
                elseif ($text_type == 'excerpt') {$ptext = $previouspost->post_excerpt; }
                elseif ($text_type == 'href') {$ptext = $previouspost->guid; }
                elseif ($text_type == 'post_date') {$ptext = $previouspost->post_date; }

               $image = ssPnext::ss_get_pnext_image($preid, 'previous');
               $title = ssPnext::ss_Pnext_titles($previouspost->post_title, $title_length);
               
               if($text_type !== '' )$ptext = ssPnext::ss_Pnext_text($ptext, $text_length, $short_replace);

               $link = get_permalink($preid);

               $previous  = '<div class="button_wrap nav_previous alignleft"><a href="'.$link.'" class="slidebttn" title="'.$ptext.'">';
               $previous .= '<img class=" nextpost_thumb '.$image[3].'" src="' . $image[0] . '" alt="' . $title . '" width="' . $thumb_w . '" height="' . $thumb_h . '" /></a><br />';
               if(($text_type != '') && ($ptext !='') && ($text_over =='on'))$previous .= '<p>'.$ptext.'</p>';
               $previous .= '
                    <div class="pnext_tag" id="pnext_tag1"><span>'.$previous_text.'</span></div>
                    <a class="button_bLeft slidebttn" title="'.$previouspost->post_title.'" id="button_bLeft" href="'.$link.'">'.$title.'</a>
                    </div><!-- close ss-previous -->';
               $previous_next .=  $previous;
               }

            if ($nextpost != null || $nextpost != '') {  
                
                $nextid = $nextpost->ID;   
                $ntext = '';
                if ($text_type == 'content') { $ntext = $nextpost->post_content; }
                elseif ($text_type == 'excerpt') {$ntext = $nextpost->post_excerpt; }
                elseif ($text_type == 'href') {$ntext = $nextpost->guid; }
                elseif ($text_type == 'post_date') {$ntext = $nextpost->post_date; }
 
                $image = ssPnext::ss_get_pnext_image($nextid, 'next');
                $title = ssPnext::ss_Pnext_titles($nextpost->post_title, $title_length);
               
                if($text_type !== '')$ntext = ssPnext::ss_Pnext_text($ntext, $text_length, $short_replace);

                $link = get_permalink($nextid);

                $next = '<div class="button_wrap nav_next alignright"><a href="'.$link.'" class="slidebttn" title="'.$ntext.'">';
                $next .= '<img class=" nextpost_thumb '.$image[3].'" src="' . $image[0] . '" alt="' . $title . '" width="'.$thumb_w.'" height="'.$thumb_h.'" /></a><br />';
                if(($text_type !== '') && ($ntext !='')  && ($text_over =='on'))$next .= '<p>'.$ntext.'</p>';
                $next .= '
                    <div class="pnext_tag" id="pnext_tag2"><span>'.$next_text.'</span></div>
                    <a class="button_bRight slidebttn" title="'.$nextpost->post_title.'" id="button_bRight" href="'.$link.'">'.$title.'</a>
                    </div><!-- close ss-next -->';
               $previous_next .= $next ;
              
               }

        if ($previouspost != null || $nextpost != null ) $previous_next .= '<br style="clear:both;height:0px;" /></div><!-- close ss-Pnext -->';

        if ($noecho == true && isset($previous_next)) {
            return $previous_next;
            }elseif (isset($previous_next)){
            echo $previous_next;
            }
    }

    function ss_get_pnext_image ( $id, $prenext ) {          
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
            //create substring of the text to the last space and add dots
    public function ss_Pnext_text($text, $text_length, $short_replace) {
        // remove all html tags
        $text = strip_tags($text) . "\n";     
        // cut down to size
        if (strlen($text) >= ($text_length+1)){            
            $short = substr($text,0,$text_length);	
            if (substr_count($short," ") > 1) {
                $lastspace = strrpos($short," ");
                $short = substr($short,0,$lastspace);
            }
            $dots = '...';
        } else { 
            $short = $text;
            $dots = '';
           
        }
        // we have to remove any shortcode brackets from the content.
      $pattern ='/\[.*?\]/';
      $cuttext = preg_replace($pattern, $short_replace, $short); 
      $text = $cuttext . $dots;
      return $text;
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

		switch($this->PnextOpOut['css_load']){
		  case'default' :
			$default_image_path = WP_PLUGIN_URL.'/superslider-previousnext-thumbs/plugin-data/superslider/ssPnext/pnext-thumbs/';
		    break;
		  case'pluginData' :
		  	$default_image_path = WP_CONTENT_URL.'/plugin-data/superslider/ssPnext/pnext-thumbs/';
		  	break;
		  case'theme' :
		  	$default_image_path = get_stylesheet_directory_uri().'/plugin-data/superslider/ssPnext/pnext-thumbs/'; 
		  	break;
		  case'off' :
			$default_image_path = WP_PLUGIN_URL.'/superslider-previousnext-thumbs/plugin-data/superslider/ssPnext/pnext-thumbs/'; 
		  	break;
		  }

         $default_image = $default_image_path.$cat.'-'.$prenext.'.jpg';
        if (file_exists(ABSPATH."/".substr($default_image,stripos($default_image,"wp-content")))) {            
            $image[0] = $default_image;
            $image[3] = 'category_'.$prenext;
            
        } else {
            $n = mt_rand(1, $this->PnextOpOut['num_ran']);          
            $image[0] = $default_image_path.'random-image-'.$n.'-'.$prenext.'.jpg';         
            $image[3] = 'random_'.$prenext;
        }
        
        return $image;
    }

    function load_Pnext(){
       if (!is_admin() && (is_singular() )){
            if ($this->PnextOpOut['css_load'] != 'off' ) { 
                add_action ( 'wp_print_styles', array(&$this,'Pnext_add_css' ));
               
             }
            if ( $this->PnextOpOut['morph_Pnext'] == 'on'){  
             
             add_action ( 'wp_print_scripts', array(&$this,'Pnext_add_javascript' ));
             add_action ( "wp_footer", array(&$this,"Pnext_starter"));
            }
       }
    }
    
    function Pnext_create_media_page() {    			
        register_setting( 'media', 'prenext_size_w' );
        register_setting( 'media', 'prenext_size_h' );
        register_setting( 'media', 'prenext_crop' );
        
        add_settings_field('prenext_size_w', 'PreNext Thumb', array(&$this, 'Pnext_media_size'), 'media', 'default');

    }
   
	function Pnext_media_size(){        
        $Pnext_w = get_option ('prenext_size_w');
        $Pnext_h = get_option('prenext_size_h');    
        $Pnext_crop = get_option('prenext_crop');
        echo '<label for="prenext_size_w">'.__(' Max Width ', 'superslider-previousNext-thumbs').'</label><input name="prenext_size_w" id="prenext_size_w" type="text" value="'. $Pnext_w.'" class="small-text" /> 
        <label for="prenext_size_h">'.__(' Max Height ', 'superslider-previousNext-thumbs').'</label><input name="prenext_size_h" id="prenext_size_h" type="text" value="'. $Pnext_h.'" class="small-text" />
        <br /><input type="checkbox"'; 
            checked('1', $Pnext_crop);        
        echo ' value="1" id="prenext_crop" name="prenext_crop"><label for="Pnext_crop">'.__(' Crop PreNext image to exact dimensions', 'superslider-previousNext-thumbs').'</label>';	
	}
	
	/*
	* Time to make thumbnails
	*
	*/
	function Pnext_create_thumbs(){
        $this->listnewimages();
        add_filter( 'intermediate_image_sizes',  array(&$this, 'additional_thumb_sizes') );			
	}
	
	function additional_thumb_sizes( $sizes ) {
        $sizes[] = "prenext";
        return $sizes;
	}

	function listnewimages() {
        if ($this->PnextOpOut['thumb_crop'] == true) { $crop = 1; }else { $crop = 0;}
		if( FALSE == get_option('prenext_size_w') ) {	
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