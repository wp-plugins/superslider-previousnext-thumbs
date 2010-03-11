=== Superslider-PreviousNext-Thumbs ===
Contributors: Daiv Mowbray
Plugin URI: http://wp-superslider.com/superslider/superslider-previousnext-thumbmnails
http://wp-superslider.com/support-me/donate/
Tags: single post, previous, navigation, next, previous next, mootools 1.2, mootools, slider, superslider
Requires at least: 2.6
Tested up to: 2.9.2
Stable tag: 0.2

Next, Previous post thumbnail navigation.


== Description ==

Superslider-previousnext-thumbs is a previous-next post, thumbnail navigation creator. Works specifically on the single post pages.
 Animated rollover controlled with css and from the plugin options page. Can create custom image sizes. 


**Features**

* pulls thumbnails from previous and next posts.
* post tile size control
* create custom previous-next thumbnails.
* select image size to use in link.
* thumb links to post/popover/attachment 

**Demos**

This plugin can be seen in use here:

* [Demo 1](http://wp-superslider.com/2010/superslider-previousnext-thumbs-demo/ "Demo 1")
* [Demo 2](http://wp-superslider.com/2010/superslider-previousnext-thumbs-demo-2/ "Demo 2")


**credits:**

* mootools - [Mootools](http://mootools.net/ "Your favorite javascript framework")

**Support**

If you have any problems or suggestions regarding this plugin [please speak up](http://support.wp-superslider.com/forum/superslider-show "support forum")

**Other Plugins**
Download These SuperSlider Plugins here:

* [SuperSlider](http://wordpress.org/extend/plugins/superslider/ "SuperSlider")
* [Superslider-PostsinCat](http://wordpress.org/extend/plugins/superslider-postsincat/ "Superslider-PostsinCat")
* [SuperSlider-MooFlow](http://wordpress.org/extend/plugins/superslider-mooflow/ "SuperSlider-MooFlow")
* [SuperSlider-Login](http://wordpress.org/extend/plugins/superslider-login/ "SuperSlider-Login")

**NOTICE**

* The downloaded folder's name should be superslider-previousnext-thumbs
* Also available for [download from here](http://wp-superslider.com/downloadsuperslider/superslider-previousnext-thumbs-download "previousnext-thumbs plugin home page").
* Probably not compatible with plugins which use jquery. (not tested)


== Screenshots ==

1. ![SlideShow-Pnext options screen](screenshot-1.png "SlideShow-Pnext options screen")
2. ![SuperSlider-Pnext in action](screenshot-2.png "SuperSlider-Pnext in action")
3. ![SuperSlider-Pnext in action](screenshot-3.png "SuperSlider-Pnext in action")
4. ![SuperSlider-Pnext in action](screenshot-4.png "SuperSlider-Pnext in action")

== Installation ==

* Unpack contents to wp-content/plugins/ into a **superslider-previousnext-thumbs** directory
* Activate the plugin,
* Configure global settings for plugin under > settings > SuperSlider-Pnext
* Add optional function call in your single.php file inside your site theme folder. (requires disabling the automatic insertion )
* (optional) move SuperSlider-Pnext plugin sub folder plugin-data to your wp-content folder,
	under  > settings > SuperSlider-Pnext > option group, File Storage - Loading Options
	select "Load css from plugin-data folder, see side note. (Recommended)". This will
	prevent plugin uploads from over writing any css changes you may have made.

== USAGE ==

If you are not sure how this plugin works you may want to read the following.

* First ensure that you have uploaded all of the plugin files into wp-content/plugins/superslider-previousnext-thumbs folder.
* Go to your WordPress admin panel and stop in to the plugins control page. Activate the superslider-previousnext-thumbs plugin.
* Default settings provide for Pnext nav at the end of your page.
* Add optional function call in your single.php file inside your site theme folder.(you will need to deactivate the Automatic insertion.)
* Basic function call: `$myssPnext->ss_previous_next_nav();`
* Complete, recommended function call: 
`<?php 
    if(class_exists ('ssPnext') ) { 
       $myssPnext->ss_previous_next_nav();
    } else {
	echo '<div class="navigation"> <div class="alignleft">';
		 previous_post_link('&laquo; %link');
	echo '</div><div class="alignright">';
	       next_post_link('%link &raquo;');
	echo '</div></div>';
    }
?>`

== OPTIONS AND CONFIGURATIONS ==

Available under > settings > SuperSlider-Pnext

----------



== Themes ==

Create your own graphic and animation theme based on one of these provided.

**Available themes**

* default (Thumbs set to 150px x 150px)
* blue (Thumbs set to 80px x 80px)
* black (Thumbs set to 180px x 30px)
* custom (Thumbs set to 180px x 30px)

== To Do ==

				

== Report Bugs Request / Options / Functions ==

* Please use the support system at http://support.wp-superslider.com
* Or post to the wordpress forums

== Frequently Asked Questions ==	

* Please use the support system at http://support.wp-superslider.com
there are no Faq's yet

== Changelog ==

* 0.2 (2010/02/26)

  * Fixed various bugs
  * upgraded functions for WP 3.0
  * Improved superslider-base integration

* 0.1.0_beta (2010/02/21)

    * first public launch

---------------------------------------------------------------------------