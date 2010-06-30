<?php
/*
Copyright 2008 daiv Mowbray

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
$Pnext_domain = 'superslider-Pnext';

	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', $Pnext_domain) );
		}
		if (isset($_POST['set_defaults']))  {
			check_admin_referer('Pnext_options');
			$Pnext_OldOptions = array(
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
				"pnext_location"   =>  "loop_end",
				'delete_options' => ''
				);

			update_option('ssPnext_options', $Pnext_OldOptions);
				
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'Pnext Default Options reloaded.', $Pnext_domain) . '</strong></p></div>';
			
		}
		elseif ($_POST['action'] == 'update' ) {
			
			check_admin_referer('Pnext_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'Pnext Options saved.', $Pnext_domain) . '</strong></p></div>';
			
			$Pnext_newOptions = array(
				'load_moo'		=> $_POST['op_load_moo'],
				'css_load'		=> $_POST['op_css_load'],
				'css_theme'		=> $_POST["op_css_theme"],
				'morph_Pnext'	=> $_POST["op_morph_Pnext"],
				//'opacity'		=> $_POST["op_overlayOpacity"],
				'resize_dur'	=> $_POST["op_resize_duration"],
				'trans_type'	=> $_POST["op_trans_type"],
				'trans_typeout'	=> $_POST["op_trans_typeout"],
				'Pnext_class'	=> $_POST["op_Pnext_class"],
				'thumb_w'	    => $_POST["op_thumb_w"],
				'thumb_h'	    => $_POST["op_thumb_h"],
				'thumb_crop'	=> $_POST["op_thumb_crop"],				
				'previous_text'	=> $_POST["op_previous_text"],
				'next_text'	    => $_POST["op_next_text"],
				'title_length'	        => $_POST["op_title_length"],
				'excluded_categories'	=> $_POST["op_excluded_categories"],
				'post_in_cat'	=> $_POST["op_post_in_cat"],				
				'thumbsize'	    => $_POST["op_thumbsize"],
				'num_ran'	    => $_POST["op_num_ran"],
				'make_thumb'	=> $_POST["op_make_thumb"],
				'auto_insert'	=> $_POST["op_auto_insert"],
				'pnext_location'=> $_POST["op_pnext_location"],
				'delete_options'	=> $_POST["op_delete_options"]
			);	

		update_option('ssPnext_options', $Pnext_newOptions);
        
        update_option('prenext_size_w', $Pnext_newOptions[thumb_w] );
		update_option('prenext_size_h', $Pnext_newOptions[thumb_h] );
		if ($Pnext_newOptions[thumb_crop] == 'true') $c = '1'; else  
		$c = '0';
		update_option('prenext_crop', $c);
		}	

		$Pnext_newOptions = get_option('ssPnext_options');   

	/**
	*	Let's get some variables for multiple instances
	*/
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl'); 
?>

<div class="wrap">
<form name="Pnext_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('Pnext_options'); echo "\n"; ?>
		
<div style="">
<a href="http://wp-superslider.com/">
<img src="<?php echo $site ?>/wp-content/plugins/superslider-previousnext-thumbs/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
  <h2 style="display:inline; position: relative;">SuperSlider-PreviousNext-Thumbnails Options</h2>
 </div><br style="clear:both;" />
 <script type="text/javascript">
// <![CDATA[

function create_ui_tabs() {


    jQuery(function() {
        var selector = '#ssslider';
            if ( typeof jQuery.prototype.selector === 'undefined' ) {
            // We have jQuery 1.2.x, tabs work better on UL
            selector += ' > ul';
        }
        jQuery( selector ).tabs({ fxFade: true, fxSpeed: 'slow' });

    });
}

jQuery(document).ready(function(){
        create_ui_tabs();
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
        <li class="ui-tabs-selected"><a href="#fragment-2"><span>Various options</span></a></li>
        <li class="ui-state-default"><a href="#fragment-3"><span>Transition Options</span></a></li>
        <li class="ui-state-default"><a href="#fragment-4"><span>Thumbnail options</span></a></li>
        <li <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	class="ss-state-default" ><a href="#fragment-5"><span>File storage</span></a></li>
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
		<legend><b><?php _e(' Themes',$Pnext_domain); ?>:</b></legend>
	<table width="100%" cellpadding="10" align="center">
	<tr>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-previousnext-thumbs/admin/img/default.png" alt="default" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-previousnext-thumbs/admin/img/blue.png" alt="blue" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-previousnext-thumbs/admin/img/black.png" alt="black" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-previousnext-thumbs/admin/img/custom.png" alt="custom" border="0" width="110" height="25" /></td>
	</tr>
	<tr>
		<td><label for="op_css_theme1">
			 <input type="radio"  name="op_css_theme" id="op_css_theme1"
			 <?php if($Pnext_newOptions['css_theme'] == "default") echo $checked; ?> value="default" />
			<?php _e(' For thumbnails of 150 x 150 px.',$Pnext_domain); ?></label>
		</td>
		<td> <label for="op_css_theme2">
			 <input type="radio"  name="op_css_theme" id="op_css_theme2"
			 <?php if($Pnext_newOptions['css_theme'] == "blue") echo $checked; ?> value="blue" />
			 <?php _e(' For thumbnails of 80 x 80 px.',$Pnext_domain); ?></b></label>
  		</td>
		<td><label for="op_css_theme3">
			 <input type="radio"  name="op_css_theme" id="op_css_theme3"
			 <?php if($Pnext_newOptions['css_theme'] == "black") echo $checked; ?> value="black" />
			 <?php _e(' For thumbnails of 180 x 30 px.',$Pnext_domain); ?></label>
  		</td>
		<td> <label for="op_css_theme4">
			 <input type="radio"  name="op_css_theme" id="op_css_theme4"
			 <?php if($Pnext_newOptions['css_theme'] == "custom") echo $checked; ?> value="custom" />
			<?php _e(' For thumbnails of 180 x 30 px.',$Pnext_domain); ?></label>
     </td>
	</tr>
	</table>

  </fieldset>
  </div>
</div><!--  close frag 1-->
 
<div id="fragment-2" class="ss-tabs-panel">
	
<h3 class="title">Various</h3>
<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   			<legend><b><?php _e(' Placement options'); ?>:</b></legend>
  	<ul style="list-style-type: none;"> 
  		 	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_post_in_cat">
		 <input type="checkbox" class="span-text" name="op_post_in_cat" id="op_post_in_cat"
		  <?php if($Pnext_newOptions['post_in_cat'] == "true") echo $checked; ?>  value="true" />
		  <?php _e('Only show posts from the active category'); ?></label> <br />
		  <span class="setting-description"><?php _e(' Unselected will display all posts from all categories.',$Pnext_domain); ?></span>		 
	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_auto_insert">
		 <input type="checkbox" class="span-text" name="op_auto_insert" id="op_auto_insert"
		  <?php if($Pnext_newOptions['auto_insert'] == "on") echo $checked; ?>  value="on" />
		  <?php _e('Automatically insert Pnext navigation into your single posts page'); ?></label> <br />
		  <span class="setting-description"><?php _e(' Unselected will require manual insertion of the required function into your single.php theme file.',$Pnext_domain); ?></span>		 
	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">	
	<label for="op_pnext_location"><?php _e(' Pnext placement on your page.',$Pnext_domain); ?></label>
		<select name="op_pnext_location" id="op_pnext_location">
			  <option <?php if($Pnext_newOptions['pnext_location'] == "content_before") echo $selected; ?> id="content_before" value='content_before'> before content</option>
			  <option <?php if($Pnext_newOptions['pnext_location'] == "content_after") echo $selected; ?> id="content_after" value='content_after'> after content</option>
		<!--the_content, the_posts, comment_form, -->
		</select>
	</li>
	
     </ul>
   </fieldset>
  
<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;">
   			<legend><b><?php _e(' Text options'); ?>:</b></legend>
  		 <ul style="list-style-type: none;">  
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_next_text"><?php _e('next text'); ?>:
		 <input type="text" class="span-text" name="op_next_text" id="op_next_text" size="45" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['next_text']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Text to display upon roll over next title.',$Pnext_domain); ?></span>
		 
	</li>
        <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_previous_text"><?php _e('previous text'); ?>:
		 <input type="text" class="span-text" name="op_previous_text" id="op_previous_text" size="45" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['previous_text']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Text to display upon roll over previous title.',$Pnext_domain); ?></span>
		 
	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_title_length"><?php _e('Title length'); ?>:
		 <input type="text" class="span-text" name="op_title_length" id="op_title_length" size="3" maxlength="3"
		 value="<?php echo ($Pnext_newOptions['title_length']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Limit the number of letters in your titles.',$Pnext_domain); ?></span>
		 
	</li>
	<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_excluded_categories"><?php _e('Exclude categories'); ?>:
		 <input type="text" class="span-text" name="op_excluded_categories" id="op_excluded_categories" size="30" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['excluded_categories']); ?>" /></label> 
		  <span class="setting-description"><?php _e(' Exclude as a list of comma seperated category ID numbers.',$Pnext_domain); ?></span>
	</li>
	
     </ul>
   </fieldset>
</div><!-- close frag2 --> 

	<div id="fragment-3" class="ss-tabs-panel">
	<h3 class="title">Pnext Transition Options</h3>
	
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- options start -->
   <legend><b><?php _e(' Personalize Transitions',$Pnext_domain); ?>:</b></legend>

   <ul style="list-style-type: none;">
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_morph_Pnext">
		 <input type="checkbox" 
		 <?php if($Pnext_newOptions['morph_Pnext'] == "on") echo $checked; ?> name="op_morph_Pnext" id="op_morph_Pnext" />
		 <?php _e('Turn Morph Pnext image on'); ?></label>		 
	  </li>
	  
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_trans_type"><?php _e(' Transition type',$Pnext_domain); ?>:   </label>  
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
		<label for="op_trans_typeout"><?php _e(' Transition action.',$Pnext_domain); ?></label>
		<select name="op_trans_typeout" id="op_trans_typeout">
			 <option <?php if($Pnext_newOptions['trans_typeout'] == "easeIn") echo $selected; ?> id="easeIn" value='easeIn'> ease in</option>
			 <option <?php if($Pnext_newOptions['trans_typeout'] == "easeOut") echo $selected; ?> id="easeOut" value='easeOut'> ease out</option>
			 <option <?php if($Pnext_newOptions['trans_typeout'] == "easeInOut") echo $selected; ?> id="easeInOut" value='easeInOut'> ease in out</option>     
		</select><br />
		<span class="setting-description"><?php _e(' IN is the begginning of transition. OUT is the end of transition.',$Pnext_domain); ?></span>
     </li>   
	 <!--<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_overlayOpacity"><?php _e(' Overlay opacity '); ?>:
		 <input type="text" class="span-text" name="op_overlayOpacity" id="op_overlayOpacity" size="3" maxlength="3"
		 value="<?php echo ($Pnext_newOptions['opacity']); ?>" /></label> 
		 <span class="setting-description"><?php _e('   (default 0.7)',$Pnext_domain); ?></span>
	 </li>-->
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_resize_duration"><?php _e(' Transition time '); ?>:
		 <input type="text" class="span-text" name="op_resize_duration" id="op_resize_duration" size="3" maxlength="6"
		 value="<?php echo ($Pnext_newOptions['resize_dur']); ?>" /></label> 
		 <span class="setting-description"><?php _e('  In milliseconds, ie: 1000 = 1 second, (default 500)',$Pnext_domain); ?></span>
	</li>
	<li>
		 <label for="op_Pnext_class"><?php _e('Pnext thumbnail class'); ?>:
		 <input type="text" class="span-text" name="op_Pnext_class" id="op_Pnext_class" size="30" maxlength="300"
		 value="<?php echo ($Pnext_newOptions['Pnext_class']); ?>" /></label> 
		 <br /><span class="setting-description"><?php _e(' Add a class for the thumbnail.',$Pnext_domain); ?></span>
		 
	</li>
      	 

     </ul>
  </fieldset>
  </div><!--  close frag 3-->
		
	<div id="fragment-4" class="ss-tabs-panel">
	<h3 class="title">Thumbnail</h3>
		  
		  <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- options start -->
   <legend><b><?php _e(' Personalize thumbnails',$Pnext_domain); ?>:</b></legend>
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
		 <span class="setting-description"><?php _e(' Which image size to use in your Previous next navigation. ',$Pnext_domain); ?></span>
	  </li>
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
	   <span class="setting-description">
	   <?php _e(' Different thumbnail sizes effect the plugin themes. Each theme is set for a different Image size. You may have to edit the theme css file to suit your image size. ',$Pnext_domain); ?>
	   </span>
	  </li>
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
	   <label for="op_make_thumb">
		      <input type="checkbox" <?php if($Pnext_newOptions['make_thumb'] == "on") echo $checked; ?> value="on" name="op_make_thumb" id="op_make_thumb" />
		      <?php _e('Make thumbnail. '); ?></label>	
	       <br /><span class="setting-description"><?php _e('If you want to have custom sized Prenext thumbnails, turn the Make thumbnail on, save your options, then select the prenext option from the Thumbnail Size options list above.<br /> The SuperSlider-Pnext plugin can create additional Prenext thumbnails. This happens upon image upload. So to create Prenext thumbs for previously uploaded images you would need to install the <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" >Regenerate thumnails plugin</a>.',$Pnext_domain); ?></span><br />
		 
		 <label for="op_thumb_w"><?php _e(' Width '); ?>:
             <input type="text" class="span-text" name="op_thumb_w" id="op_thumb_w" size="3" maxlength="5"
             value="<?php echo get_option('prenext_size_w'); ?>" /> px.</label> 
             <span class="setting-description"><?php _e('  ',$Pnext_domain); ?></span>
		  <label for="op_thumb_h"><?php _e(' Height '); ?>:
             <input type="text" class="span-text" name="op_thumb_h" id="op_thumb_h" size="3" maxlength="5"
             value="<?php echo get_option('prenext_size_h'); ?>" /> px.</label> 
             <span class="setting-description"><?php _e('  ',$Pnext_domain); ?></span>
		 <label for="op_thumb_crop">
			<input type="checkbox" name="op_thumb_crop" id="op_thumb_crop"
			<?php if( get_option('prenext_crop') == "1") echo $checked; ?> value="true" />
			<?php _e(' Create cropped, unsellected leaves the image proportional. ',$Pnext_domain); ?></label>
			<br /><span class="setting-description"><?php _e('(These image settings are also available on the <a href="options-media.php">Media Settings page</a>).',$ssShow_domain); ?></span>
	  </li>
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
             <label for="op_num_ran"><?php _e(' Number of Random '); ?>:
             <input type="text" class="span-text" name="op_num_ran" id="op_num_ran" size="3" maxlength="5"
             value="<?php echo ($Pnext_newOptions['num_ran']); ?>" /> images.</label> <br />
             <span class="setting-description"><?php _e(' How many random images to pick from, if there are no images attached or imbeded in the post. And you don\'t have default category thumbnail images created. 
             To create default category thumbnails: for each category add an image with the name <b>cat-yourCatSlugName-previous.jpg</b> and <b>cat-yourCatSlugName-next.jpg</b> to the folder <b>plugin-data/superslider/ssPnext/Pnext-thumbs/</b>. 
             Categories with no Pnext image will display one of the random thumbnails.',$Pnext_domain); ?></span>
         </li>
     </ul>
   </fieldset>
</div><!-- close frag4 -->

<div id="fragment-5" class="ss-tabs-panel">
	
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
    	<?php _e(' Load Mootools 1.2 into your theme header.',$Pnext_domain); ?></label>
    	
	</li>
	
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
  
    	<label for="op_css_load1">
			<input type="radio" name="op_css_load" id="op_css_load1"
			<?php if($Pnext_newOptions['css_load'] == "default") echo $checked; ?> value="default" />
			<?php _e(' Load css from default location. Pnext plugin folder.',$Pnext_domain); ?></label><br />
    	<label for="op_css_load2">
			<input type="radio" name="op_css_load"  id="op_css_load2"
			<?php if($Pnext_newOptions['css_load'] == "pluginData") echo $checked; ?> value="pluginData" />
			<?php _e(' Load css from plugin-data folder, see side note. (Recommended)',$Pnext_domain); ?></label><br />
    	<label for="op_css_load3">
			<input type="radio" name="op_css_load"  id="op_css_load3"
			<?php if($Pnext_newOptions['css_load'] == "off") echo $checked; ?> value="off" />
			<?php _e(' Don\'t load css, manually add to your theme css file.',$Pnext_domain); ?></label>

    </li>
    </ul>
     </fieldset>
    
		<p>
		<?php _e(' If your theme or any other plugin loads the mootools 1.2 javascript framework into your file header, you can de-activate it here.',$Pnext_domain); ?></p><p><?php _e(' Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$Pnext_domain); ?></p></td>
	</div><!-- close frag 8 -->
</div><!--  close tabs -->
<p>
<label for="op_delete_options">
		      <input type="checkbox" <?php if($Pnext_newOptions['delete_options'] == "on") echo $checked; ?> name="op_delete_options" id="op_delete_options" />
		      <?php _e('Remove options. '); ?></label>	
		 <br /><span class="setting-description"><?php _e('Select to have the plugin options removed from the data base upon deactivation.'); ?></span>
		 <br />
</p>
<p class="submit">
		<input type="submit" name="set_defaults" value="<?php _e(' Reload Default Options',$Pnext_domain); ?> &raquo;" />
		<input type="submit" id="update2" class="button-primary" value="<?php _e(' Update options',$Pnext_domain); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form>
</div>
<?php
	echo "";
?>