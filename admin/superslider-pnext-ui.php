<?php
/*
Copyright 2012 daiv Mowbray

This file is part of SuperSlider-Pnext

SuperSlider-Pnext is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Pnext is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Fancy Categories; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	/**
   * Should you be doing this?
   */ 	
$plugin_name = 'superslider-Pnext';

	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', $plugin_name) );
		}
		if (isset($_POST['set_defaults']))  {
			check_admin_referer('Pnext_options');
			$Pnext_OldOptions = array(
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
				'delete_options' => ''
				);

			update_option('ssPnext_options', $Pnext_OldOptions);
				
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-PreviousNext default options have been reloaded.', $plugin_name) . '</strong></p></div>';
			
		}
		elseif (isset($_POST['action']) && $_POST['action'] == 'update' ) {
			
			check_admin_referer('Pnext_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-PreviousNext options have been saved.', $plugin_name) . '</strong></p></div>';
			
			$Pnext_newOptions = array(
				'load_moo' 		=> isset($_POST['op_load_moo']) ? $_POST["op_load_moo"] : "",
				'css_load'		=> $_POST['op_css_load'],
				'css_theme'		=> $_POST["op_css_theme"],
				'morph_Pnext' 	=> isset($_POST['op_morph_Pnext']) ? $_POST["op_morph_Pnext"] : "",
				'text_over' 	=> isset($_POST['op_text_over']) ? $_POST["op_text_over"] : "",
				'resize_dur'	=> $_POST["op_resize_duration"],
				'trans_type'	=> $_POST["op_trans_type"],
				'trans_typeout'	=> $_POST["op_trans_typeout"],
				'Pnext_class'	=> $_POST["op_Pnext_class"],
				'thumb_w'	    => $_POST["op_thumb_w"],
				'thumb_h'	    => $_POST["op_thumb_h"],
				'thumb_crop' 	=> isset($_POST['op_thumb_crop']) ? $_POST["op_thumb_crop"] : "",
				'previous_text'	=> $_POST["op_previous_text"],
				'next_text'	    => $_POST["op_next_text"],
				'title_length'	        => $_POST["op_title_length"],
				'excluded_categories'	=> $_POST["op_excluded_categories"],
				'post_in_cat' 	=> isset($_POST['op_post_in_cat']) ? $_POST["op_post_in_cat"] : "",
				'thumbsize'	    => $_POST["op_thumbsize"],
				'num_ran'	    => $_POST["op_num_ran"],
				'make_thumb' 	=> isset($_POST['op_make_thumb']) ? $_POST["op_make_thumb"] : "",
				'auto_insert' 	=> isset($_POST['op_auto_insert']) ? $_POST["op_auto_insert"] : "",
				'pnext_location'=> $_POST["op_pnext_location"],
				'text_length'   => $_POST["op_text_length"],
				'text_type'     => $_POST["op_text_type"],
				'short_replace' => $_POST["op_short_replace"],
				'delete_options' => isset($_POST['op_delete_options']) ? $_POST["op_delete_options"] : ""
			);	

		update_option('ssPnext_options', $Pnext_newOptions);
        
        update_option('prenext_size_w', $Pnext_newOptions['thumb_w'] );
		update_option('prenext_size_h', $Pnext_newOptions['thumb_h'] );
		if ($Pnext_newOptions['thumb_crop'] == 'true') $c = '1'; else  
		$c = '0';
		update_option('prenext_crop', $c);
		
		// from here		
		}elseif (isset($_POST['proaction']) && $_POST['proaction'] == 'updatepro' ) {
			
			check_admin_referer('ssPro_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Pro Options saved.', 'superslider' ) . '</strong></p></div>';
			
			
			$ssPro_newOptions = array(				
				'pro_code' => isset($_POST['op_pro_code']) ? $_POST["op_pro_code"] : ""
				);
			update_option('ssPro_options', $ssPro_newOptions);
	
		}

	$ssPro_newOptions = get_option('ssPro_options'); 
	$ispro = '';
	if($ssPro_newOptions['pro_code'] == "We are all beautiful creative people")$ispro = true;



		$Pnext_newOptions = get_option('ssPnext_options');   

	/**
	*	Let's get some variables for multiple instances
	*/
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl'); 
	$plugin_name = 'SuperSlider-PreviousNext-Thumbs';
?>

<div class="wrap">
<div class="ss_column1">

<form name="Pnext_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('Pnext_options'); echo "\n"; ?>
		
<div style="">
<a href="http://superslider.daivmowbray.com/">
<img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-previousnext-thumbs/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
  <h2 style="display:inline; position: relative;">SuperSlider-PreviousNext-Thumbnails Options</h2>
 </div><br style="clear:both;" />
 <script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function ($) {

	$(function() {
        $( "#ssslider" ).tabs({ active: 1 });
    });
});	
// ]]>
</script>
 
<div id="ssslider" class="ui-tabs">
    <ul id="ssnav" class="ui-tabs-nav">
        <li <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	class="ui-state-default" ><a href="#fragment-1"><span>Appearance</span></a></li>
        <li class="ui-tabs-selected"><a href="#fragment-2"><span>Placement options</span></a></li>
        <li class="ui-tabs-selected"><a href="#fragment-3"><span>Text options</span></a></li>
        <li class="ui-state-default"><a href="#fragment-4"><span>Transition Options</span></a></li>
        <li class="ui-state-default"><a href="#fragment-5"><span>Thumbnail options</span></a></li>
        <li <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	class="ss-state-default" ><a href="#fragment-6"><span>File storage</span></a></li>
    </ul>
    <div id="fragment-1" class="ss-tabs-panel">
 	<div <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	
	>
	<h3>Pnext Appearance</h3>
	
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  	
		<legend><b><?php _e(' Themes',$plugin_name); ?>:</b></legend>
	<table width="100%" cellpadding="10" align="center">
	<tr>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-previousnext-thumbs/admin/img/default.png" alt="default" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-previousnext-thumbs/admin/img/blue.png" alt="blue" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-previousnext-thumbs/admin/img/black.png" alt="black" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-previousnext-thumbs/admin/img/custom.png" alt="custom" border="0" width="110" height="25" /></td>
	</tr>
	<tr>
		<td><label for="op_css_theme1">
			 <input type="radio"  name="op_css_theme" id="op_css_theme1"
			 <?php if($Pnext_newOptions['css_theme'] == "default") echo $checked; ?> value="default" />
			<?php _e(' For thumbnails of 150 x 150 px.',$plugin_name); ?></label>
		</td>
		<td> <label for="op_css_theme2">
			 <input type="radio"  name="op_css_theme" id="op_css_theme2"
			 <?php if($Pnext_newOptions['css_theme'] == "blue") echo $checked; ?> value="blue" />
			 <?php _e(' For thumbnails of 80 x 80 px.',$plugin_name); ?></b></label>
  		</td>
		<td><label for="op_css_theme3">
			 <input type="radio"  name="op_css_theme" id="op_css_theme3"
			 <?php if($Pnext_newOptions['css_theme'] == "black") echo $checked; ?> value="black" />
			 <?php _e(' For thumbnails of 180 x 30 px.',$plugin_name); ?></label>
  		</td>
		<td> <label for="op_css_theme4">
			 <input type="radio"  name="op_css_theme" id="op_css_theme4"
			 <?php if($Pnext_newOptions['css_theme'] == "custom") echo $checked; ?> value="custom" />
			<?php _e(' For thumbnails of 180 x 30 px.',$plugin_name); ?></label>
     </td>
	</tr>
	</table>

  </fieldset>
  </div>
</div><!--  close frag 1-->
 
<div id="fragment-2" class="ss-tabs-panel">
	
<h3 class="title">Placement</h3>
<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   			<legend><b><?php _e(' Placement options'); ?>:</b></legend>
  	<ul style="list-style-type: none;"> 
  		 	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_post_in_cat">
		 <input type="checkbox" class="span-text" name="op_post_in_cat" id="op_post_in_cat"
		  <?php if($Pnext_newOptions['post_in_cat'] == "true") echo $checked; ?>  value="true" />
		  <?php _e('Only show posts from the active category'); ?></label> <br />
		  <span class="setting-description"><?php _e(' Unselected will display all posts from all categories.',$plugin_name); ?></span>		 
	</li>
		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_excluded_categories"><?php _e('Exclude categories'); ?>:
		 <input type="text" class="span-text" name="op_excluded_categories" id="op_excluded_categories" size="30" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['excluded_categories']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Exclude as a list of comma seperated category ID numbers.',$plugin_name); ?></span>
	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_auto_insert">
		 <input type="checkbox" class="span-text" name="op_auto_insert" id="op_auto_insert"
		  <?php if($Pnext_newOptions['auto_insert'] == "on") echo $checked; ?>  value="on" />
		  <?php _e('Automatically insert Pnext navigation into your single posts page'); ?></label> <br />
		  <span class="setting-description"><?php _e(' Unselected will require manual insertion of the required function into your single.php theme file.',$plugin_name); ?></span>		 
	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">	
	<label for="op_pnext_location"><?php _e(' Pnext placement on your page.',$plugin_name); ?></label>
		<select name="op_pnext_location" id="op_pnext_location">
			  <option <?php if($Pnext_newOptions['pnext_location'] == "content_before") echo $selected; ?> id="content_before" value='content_before'> before content</option>
			  <option <?php if($Pnext_newOptions['pnext_location'] == "content_after") echo $selected; ?> id="content_after" value='content_after'> after content</option>
			  <option <?php if($Pnext_newOptions['pnext_location'] == "content_before_after") echo $selected; ?> id="content_before_after" value='content_before_after'> before and after content</option>
		<!--the_content, the_posts, comment_form, -->
		</select>
	</li>
	
     </ul>
   </fieldset>
</div><!--  close frag 2-->
 
<div id="fragment-3" class="ss-tabs-panel">
	
<h3 class="title">Text</h3>  
<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   			<legend><b><?php _e(' Text options'); ?>:</b></legend>
  		 <ul style="list-style-type: none;">  
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_next_text"><?php _e('next text'); ?>:
		 <input type="text" class="span-text" name="op_next_text" id="op_next_text" size="45" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['next_text']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Text to display upon roll over next title.',$plugin_name); ?></span>
		 
	</li>
        <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_previous_text"><?php _e('previous text'); ?>:
		 <input type="text" class="span-text" name="op_previous_text" id="op_previous_text" size="45" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['previous_text']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Text to display upon roll over previous title.',$plugin_name); ?></span>
		 
	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_title_length"><?php _e('Title length'); ?>:
		 <input type="text" class="span-text" name="op_title_length" id="op_title_length" size="3" maxlength="3"
		 value="<?php echo ($Pnext_newOptions['title_length']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Limit the number of letters in your titles.',$plugin_name); ?></span>
		 
	</li>	
	
		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">	
	<label for="op_text_type"><?php _e('Which text to add to the previous / next links as link title, if any.',$plugin_name); ?></label>
		<select name="op_text_type" id="op_text_type">
			  <option <?php if($Pnext_newOptions['text_type'] == "") echo $selected; ?> value=""> None</option>
			  <option <?php if($Pnext_newOptions['text_type'] == "content") echo $selected; ?> value="content"> Content</option>
			  <option <?php if($Pnext_newOptions['text_type'] == "excerpt") echo $selected; ?> value="excerpt"> Excerpt</option>
			  <option <?php if($Pnext_newOptions['text_type'] == "href") echo $selected; ?> value="href"> href</option>
			  <option <?php if($Pnext_newOptions['text_type'] == "post_date") echo $selected; ?> value="post_date"> Post date</option>		  
		</select>
	</li>	
	   
	   <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_text_length"><?php _e('Text length'); ?>:
		 <input type="text" class="span-text" name="op_text_length" id="op_text_length" size="3" maxlength="3"
		 value="<?php echo ($Pnext_newOptions['text_length']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Limit the number of letters in your link title text.',$plugin_name); ?></span>
		 
	</li>	
	
		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_text_over">
		 <input type="checkbox" class="span-text" name="op_text_over" id="op_text_over"
		  <?php if($Pnext_newOptions['text_over'] == "on") echo $checked; ?>  value="on" />
		  <?php _e('Automatically insert Text overtop of the thumbnail'); ?></label> <br />
		  <span class="setting-description"><?php _e(' Activating this may require some css adjustments to get the look you want.',$plugin_name); ?></span>		 
	</li>
		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_short_replace"><?php _e('ShortCode replace'); ?>:
		 <input type="text" class="span-text" name="op_short_replace" id="op_short_replace" size="30" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['short_replace']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Replace shortcodes in your post text with this string.',$plugin_name); ?></span>
		 
	</li>
                
     </ul>
   </fieldset>
</div><!-- close frag3 --> 

	<div id="fragment-4" class="ss-tabs-panel">
	<h3 class="title">Pnext Transition Options</h3>
	
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- options start -->
   <legend><b><?php _e(' Personalize Transitions',$plugin_name); ?>:</b></legend>

   <ul style="list-style-type: none;">
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_morph_Pnext">
		 <input type="checkbox" 
		 <?php if($Pnext_newOptions['morph_Pnext'] == "on") echo $checked; ?> name="op_morph_Pnext" id="op_morph_Pnext" />
		 <?php _e('Turn Morph Pnext image on'); ?></label>		 
	  </li>
	  
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_trans_type"><?php _e(' Transition type',$plugin_name); ?>:   </label>  
		 <select name="op_trans_type" id="op_trans_type">
			 <option <?php if($Pnext_newOptions['trans_type'] == "Sine") echo $selected; ?> id="Sine" value='Sine'> Sine</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Elastic") echo $selected; ?> id="Elastic" value='Elastic'> Elastic</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Bounce") echo $selected; ?> id="Bounce" value='Bounce'> Bounce</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Back") echo $selected; ?> id="Back" value='Back'> Back</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Expo") echo $selected; ?> id="Expo" value='Expo'> Expo</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Circ") echo $selected; ?> id="Circ" value='Circ'> Circ</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Quad") echo $selected; ?> id="Quad" value='Quad'> Quad</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Cubic") echo $selected; ?> id="Cubic" value='Cubic'> Cubic</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Linear") echo $selected; ?> id="Linear" value='Linear'> Linear</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Quart") echo $selected; ?> id="Quart" value='Quart'> Quart</option>
			 <option <?php if($Pnext_newOptions['trans_type'] == "Quint") echo $selected; ?> id="Quint" value='Quint'> Quint</option>
			</select>
		<label for="op_trans_typeout"><?php _e(' Transition action.',$plugin_name); ?></label>
		<select name="op_trans_typeout" id="op_trans_typeout">
			 <option <?php if($Pnext_newOptions['trans_typeout'] == "easeIn") echo $selected; ?> id="easeIn" value='easeIn'> ease in</option>
			 <option <?php if($Pnext_newOptions['trans_typeout'] == "easeOut") echo $selected; ?> id="easeOut" value='easeOut'> ease out</option>
			 <option <?php if($Pnext_newOptions['trans_typeout'] == "easeInOut") echo $selected; ?> id="easeInOut" value='easeInOut'> ease in out</option>     
		</select><br />
		<span class="setting-description"><?php _e(' IN is the begginning of transition. OUT is the end of transition.',$plugin_name); ?></span>
     </li>   
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_resize_duration"><?php _e(' Transition time '); ?>:
		 <input type="text" class="span-text" name="op_resize_duration" id="op_resize_duration" size="3" maxlength="6"
		 value="<?php echo ($Pnext_newOptions['resize_dur']); ?>" /></label> 
		 <span class="setting-description"><?php _e('  In milliseconds, ie: 1000 = 1 second, (default 500)',$plugin_name); ?></span>
	</li>
	<li>
		 <label for="op_Pnext_class"><?php _e('Pnext thumbnail class'); ?>:
		 <input type="text" class="span-text" name="op_Pnext_class" id="op_Pnext_class" size="30" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['Pnext_class']); ?>" /></label> 
		 <br /><span class="setting-description"><?php _e(' Add a class for the thumbnail.',$plugin_name); ?></span>
		 
	</li>
      	 

     </ul>
  </fieldset>
  </div><!--  close frag 4-->
		
	<div id="fragment-5" class="ss-tabs-panel">
	<h3 class="title">Thumbnail</h3>
		  
		  <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- options start -->
   <legend><b><?php _e(' Personalize thumbnails',$plugin_name); ?>:</b></legend>
  <ul style="list-style-type: none;">       	 
	   	  
	   <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_thumbsize"><?php _e(' Thumbnail Size'); ?>: </label> 
		 
		  <select name="op_thumbsize" id="op_thumbsize">
		      <option <?php if($Pnext_newOptions['make_thumb'] == "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> <?php if($Pnext_newOptions['thumbsize'] == "prenext") echo $selected; ?> id="ssPnext" value="prenext"> prenext</option>
		     <option <?php
		     if (class_exists('ssShow')) { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> <?php if($Pnext_newOptions['thumbsize'] == "minithumb") echo $selected; ?> id="minithumb" value='minithumb'> minithumb</option>
			 <option <?php if($Pnext_newOptions['thumbsize'] == "thumbnail") echo $selected; ?> id="thumbnail" value='thumbnail'> thumbnail</option>
			  <option <?php if (class_exists('ssExcerpt')) { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> <?php if($Pnext_newOptions['thumbsize'] == "excerpt") echo $selected; ?> id="excerpt_thumb" value='excerpt'> excerpt</option>		   

			 <option <?php if($Pnext_newOptions['thumbsize'] == "medium") echo $selected; ?> id="medium" value='medium'> medium</option>
			 
  		    <option <?php if (class_exists('ssShow')) { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> <?php if($Pnext_newOptions['thumbsize'] == "slideshow") echo $selected; ?> id="slideshow" value='slideshow'> slideshow</option>		   
		 </select>	 
		 <span class="setting-description"><?php _e(' Which image size to use in your Previous next navigation. ',$plugin_name); ?></span>
	  </li>
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
	   <span class="setting-description">
	   <?php _e(' Different thumbnail sizes effect the plugin themes. Each theme is set for a different Image size. You may have to edit the theme css file to suit your image size. ',$plugin_name); ?>
	   </span>
	  </li>
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
	   <label for="op_make_thumb">
		      <input type="checkbox" <?php if($Pnext_newOptions['make_thumb'] == "on") echo $checked; ?> value="on" name="op_make_thumb" id="op_make_thumb" />
		      <?php _e('Make thumbnail. '); ?></label>	
	       <br /><span class="setting-description"><?php _e('If you want to have custom sized Prenext thumbnails, turn the Make thumbnail on, save your options, then select the prenext option from the Thumbnail Size options list above.<br /> The SuperSlider-Pnext plugin can create additional Prenext thumbnails. This happens upon image upload. So to create Prenext thumbs for previously uploaded images you would need to install the <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" >Regenerate thumnails plugin</a>.',$plugin_name); ?></span><br />
		 
		 <label for="op_thumb_w"><?php _e(' Width '); ?>:
             <input type="text" class="span-text" name="op_thumb_w" id="op_thumb_w" size="3" maxlength="5"
             value="<?php echo get_option('prenext_size_w'); ?>" /> px.</label> 
             <span class="setting-description"><?php _e('  ',$plugin_name); ?></span>
		  <label for="op_thumb_h"><?php _e(' Height '); ?>:
             <input type="text" class="span-text" name="op_thumb_h" id="op_thumb_h" size="3" maxlength="5"
             value="<?php echo get_option('prenext_size_h'); ?>" /> px.</label> 
             <span class="setting-description"><?php _e('  ',$plugin_name); ?></span>
		 <label for="op_thumb_crop">
			<input type="checkbox" name="op_thumb_crop" id="op_thumb_crop"
			<?php if( get_option('prenext_crop') == "1") echo $checked; ?> value="true" />
			<?php _e(' Create cropped, unsellected leaves the image proportional. ',$plugin_name); ?></label>
			<br /><span class="setting-description"><?php _e('(These image settings are also available on the <a href="options-media.php">Media Settings page</a>).',$plugin_name); ?></span>
	  </li>
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
             <label for="op_num_ran"><?php _e(' Number of Random '); ?>:
             <input type="text" class="span-text" name="op_num_ran" id="op_num_ran" size="3" maxlength="5"
             value="<?php echo ($Pnext_newOptions['num_ran']); ?>" /> images.</label> <br />
             <span class="setting-description"><?php _e(' How many random images to pick from, if there are no images attached or imbeded in the post. And you don\'t have default category thumbnail images created. 
             To create default category thumbnails: for each category add an image with the name <b>cat-yourCatSlugName-previous.jpg</b> and <b>cat-yourCatSlugName-next.jpg</b> to the folder <b>plugin-data/superslider/ssPnext/Pnext-thumbs/</b>. 
             Categories with no Pnext image will display one of the random thumbnails.',$plugin_name); ?></span>
         </li>
     </ul>
   </fieldset>
</div><!-- close frag5 -->

<div id="fragment-6" class="ss-tabs-panel">
	
	<div
<?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> 
	>
	<h3 class="title">File Storage</h3>
<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Header files options start -->
   			<legend><b><?php _e(' Loading Options'); ?>:</b></legend>
  		 <ul style="list-style-type: none;">  		 
  		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<label for="op_load_moo">
    	<input type="checkbox" 
    	<?php if($Pnext_newOptions['load_moo'] == "on") echo $checked; ?> name="op_load_moo" id="op_load_moo" />
    	<?php _e(' Load Mootools 1.4.1 into your theme header.',$plugin_name); ?></label>
    	
	</li>
	
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
  
    	<label for="op_css_load1">
			<input type="radio" name="op_css_load" id="op_css_load1"
			<?php if($Pnext_newOptions['css_load'] == "default") echo $checked; ?> value="default" />
			<?php _e(' Load css from default location. Pnext plugin folder.',$plugin_name); ?></label><br />
    	<label for="op_css_load2">
			<input type="radio" name="op_css_load"  id="op_css_load2"
			<?php if($Pnext_newOptions['css_load'] == "pluginData") echo $checked; ?> value="pluginData" />
			<?php _e(' Load css from plugin-data folder, see side note. (Recommended)',$plugin_name); ?></label><br />
    	<label for="op_css_load3">
			<input type="radio" name="op_css_load"  id="op_css_load3"
			<?php if($Pnext_newOptions['css_load'] == "theme") echo $checked; ?> value="theme" />
			<?php _e(' Load css, from your theme folder.',$plugin_name); ?></label><br />
		<label for="op_css_load4">
			<input type="radio" name="op_css_load"  id="op_css_load4"
			<?php if($Pnext_newOptions['css_load'] == "off") echo $checked; ?> value="off" />
			<?php _e(' Don\'t load css. You will need to manually add css info to your theme css file. Also, the default images (for posts with no image.) will now need to be placed in wp-content/plugin-data/superslider/ssPnext/pnext-thumbs/',$plugin_name); ?></label>

    </li>
    </ul>
     </fieldset>
    
		<p>
		<?php _e(' If your theme or any other plugin loads the mootools 1.4.1 javascript framework into your file header, you can de-activate it here.',$plugin_name); ?></p><p><?php _e(' Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$plugin_name); ?></p></td>
	</div><!-- close frag 6 -->
</div><!--  close tabs -->
<p>
<label for="op_delete_options">
		      <input type="checkbox" <?php if($Pnext_newOptions['delete_options'] == "on") echo $checked; ?> name="op_delete_options" id="op_delete_options" />
		      <?php _e('Remove options. '); ?></label>	
		 <br /><span class="setting-description"><?php _e('Select to have the plugin options removed from the data base upon deactivation.'); ?></span>
		 <br />
</p>
<p class="submit">
		<input type="submit" class="button" name="set_defaults" value="<?php _e(' Reload Default Options',$plugin_name); ?> &raquo;" />
		<input type="submit" id="update2" class="button-primary" value="<?php _e(' Update options',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form>
</div>
</div><!-- close column1 -->


<div class="ss_column2">

<?php if( $ispro !== true) { ?>

	<div class="ss_donate ss_admin_box"> 
		<h2><span class="promo"><?php _e('Spread the Word!', $plugin_name); ?></span></h2>
		<p><?php _e('Want to help make this plugin even better? All donations are used to improve and maintain this plugin, so donate $5, $10, $20 or $50! We\'ll both be glad you did. Thanx. ', $plugin_name); ?></p>
       <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="N2F3EUVHPYY5G">
            <input type="image" class="paypal_button" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
       </form>
       
       
       <p><?php _e('Better yet, if you would like to join the exclusive pro members club,', $plugin_name); ?> <a href="http://superslider.daivmowbray.com/superslider-pro/"><?php _e('learn more'); ?></a><?php _e('or upgrade now!'); ?> </p>
       <h2><span class="promo">SuperSlider Pro</span></h2>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="83HF3CEUD4976">
			<input type="image" class="paypal_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

       <p><?php _e('Or if you find this plugin useful you could :'); ?></p><ul>
       	<li><a href="http://wordpress.org/extend/plugins/<?php echo $plugin_name; ?>/"><?php _e('Rate the plugin 5 stars on WordPress.org', $plugin_name); ?></a></li>
       	<li><a href="http://superslider.daivmowbray.com/superslider/<?php echo $plugin_name; ?>/"><?php _e('Blog about it &amp; link to the plugin page', $plugin_name); ?></a></li>
       	<li><a href="http://wordpress.org/support/view/plugin-reviews/<?php echo $plugin_name; ?>"><?php _e('Post a glowing review on WordPress.org, that would be really nice.', $plugin_name); ?></a></li>
       	<li><a href="http://amzn.com/w/2GUXZ71357NX9"><?php _e('or buy me a gift from my wishlist ...', $plugin_name); ?></a></li></ul>
       
    </div>
    <div class="ss_admin_box" id="sitereview">
		<h2><?php _e('Improve your Site!', $plugin_name); ?></h2>
		<p><?php _e('Don\'t know where to start? Order a ', $plugin_name); ?><a href="http://superslider.daivmowbray.com/services/website-review/#order"><?php _e('website review', $plugin_name); ?></a> from SuperSlider!
		<a href="http://superslider.daivmowbray.com/services/website-review/"> Read more ... </a></p>	
	</div>

 
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please talk about them in the', $plugin_name); ?> <a href="http://wordpress.org/support/plugin/<?php echo $plugin_name; ?>/">Support forums</a>.</p>	
		</div>

 <?php 
 } else { ?>
	
		<div class="ss_donate ss_admin_box"> <h2><span class="promo">SuperSlider Pro</span></h2> </div>
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please contact me directly via this contact form', $plugin_name); ?><br /><a href="http://superslider.daivmowbray.com/pro-support/">Pro Support</a>.</p>	
		</div>
<?php }?>

	<h2><?php _e('More SuperSlider Plugins', $plugin_name); ?></h2>
	<p><?php _e('There are 11 different SuperSlider plugins. All are free to use. Take a minute and learn what each one can do for you. They save you time and money, while making a better web site.', $plugin_name); ?></p>
	 <div class="ss_plugins_list
	 <?php if (class_exists('ssBase') && class_exists('ssShow') &&  class_exists('ssMenu') && class_exists('ssMenu') && class_exists('ssImage') && class_exists('ssExcerpt') && class_exists('ssMediaPop') && class_exists('perpost_code') && class_exists('ssPnext') && class_exists('ss_postsincat_widget') && class_exists('ssLogin') && class_exists('ssSlim')) { echo "all-installed" ; } ?>
	 "> 
	 
		<div class="ss_plugin <?php if (class_exists('ssBase')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider/" title="visit this plugin at WordPress.org to learn more">SuperSlider</a>	
		<a href="#ss_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="ss_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider base, is a global admin plugin for all SuperSlider plugins and comes stocked full of eye candy in the form of modules.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssShow')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-show/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Show</a>
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-show&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMenu')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-menu/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Menu</a>		
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-menu&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssImage')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-image/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Image</a>
		<a href="#image_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-image&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="image_tips_info" class="info_box" style="display:none;">
		<p>Take control your photos and image display. Can add a randomly selected image to any post without an image. Provides a shortcode for adding a photo or image to your post. Provides an easy way to change image properties globally. At the click of a button all post size images can be changed from thumbnail size image to medium size image or any available image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssExcerpt')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-excerpt/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Excerpt</a>
		<a href="#excerpt_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-excerpt&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="excerpt_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Excerpts automatically adds thumbnails wherever you show excerpts (archive page, feed... etc). Mouseover image will then Morph its properties, (controlled with css) You can pre-define the automatic creation of excerpt sized excerpt-nails.(New image size created, upon image upload).</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMediaPop')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-media-pop/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Media-Pop</a>	
		<a href="#media_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-media-pop&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="media_tips_info" class="info_box" style="display:none;">
		<p>Soda pop for your media. Take control of your media. Access all size versions of your uploaded image for insert. SuperSlider-Media-Pop adds numerous image enhancements to your admin panels. Displays all attached files to this post/page in post listing screen. It adds image sizes to the Upload/Insert image screen, making all image sizes available to be inserted and adding to the image link field options. Insert any image size and link to any image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('perpost_code')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-perpost-code/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Perpost-Code</a>
		<a href="#code_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-perpost-code&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="code_tips_info" class="info_box" style="display:none;">
		<p>Write css and javascript code directly on your post edit screen on a per post basis. Meta boxes provide a quick and easy way to enter custom code to each post. It then loads the code into your frontend theme header if the post has custom code. You may also display your custom code directly into your post with the custom_css or custom_js shortcode.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssPnext')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-previousnext-thumbs/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Previousnext-Thumbs</a>
		<a href="#pnext_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-previousnext-thumbs&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pnext_tips_info" class="info_box" style="display:none;">
		<p>Superslider-previousnext-thumbs is a previous-next post, thumbnail navigation creator. Works specifically on the single post pages. Animated rollover controlled with css and from the plugin options page. Can create custom image sizes. Automaitcally insert before or after post content or both. Or you can manually insert into your single post theme file.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ss_postsincat_widget')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-postsincat/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Postsincat</a>
		<a href="#pinc_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-postsincat&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pinc_tips_info" class="info_box" style="display:none;">
		<p>This widget dynamically creates a list of posts from the active category. Displaying the first image and title. It will display the first image in your post as a thumbnail,it looks first for an attached image, then an embedded image then if it finds the image, it grabs the thumbnail version. Oh, and by the way, it's an animated vertical scroller, way cool.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssLogin')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-login/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Login</a>
		<a href="#login_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-login&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="login_tips_info" class="info_box" style="display:none;">
		<p>A tabbed slide in login panel. Theme based, animated, automatic user detection.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssSlim')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://superslider.daivmowbray.com/superslider/superslider-slimbox/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Slimbox</a>
		<a href="#slim_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-slimbox&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="slim_tips_info" class="info_box" style="display:none;">
		<p>Another pop over light box. Theme based, animated, automatic linking, autoplay show built with slimbox2 , uses mootools 1.4.5 java script</p>
		</div></div>
	
		<br style="clear:both;" />
	 </div>
 <h3><?php _e('Services', $plugin_name); ?></h3>
		<p><?php _e('Custom plugins, custom themes, custom solutions: I\'ve been developing WordPress Themes and plugins for many years. If you need a custom solution or simply some help with your set up I am avaiable at reasonable rates. ', $plugin_name); ?><a href="http://www.daivmowbray.com/contact"><?php _e('Just send a note to me, Daiv Mowbray, through this contact form', $plugin_name); ?></a>.</p>

<?php  if( $ispro !== true) { ?>

	<div class="promo_code_form" style="text-align: center;">
	<form name="ssPro_options" method="post" action="<?php //echo $_SERVER['REQUEST_URI'] ?>">
	<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssPro_options'); echo "\n"; 
		?>
    		<label for="op_pro_code">
               <input type="text" class="span-text" name="op_pro_code" id="op_pro_code" size="30" maxlength="200"
			 value="<?php echo ($ssPro_newOptions['pro_code']); ?>" />
               <br /> <?php _e('Enter your SuperSlider Pro code.',$plugin_name); ?></label>	
    <p class="margin-top: 5px;">
	
		<input type="submit" id="updatePro" class="button-primary" value="<?php _e('Enter',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="proaction" id="proaction" value="updatepro" />
		
 	</p>
 	</form>
 	</div>
<?php  } ?> 

</div><!-- close column2   --> 
</div><!-- close wrap to here --> 

<?php

?>