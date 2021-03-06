=== Superslider-PreviousNext-Thumbs ===
Contributors: Daiv Mowbray
Plugin URI: http://superslider.daivmowbray.com/superslider/superslider-previousnext-thumbmnails
Donate link: http://superslider.daivmowbray.com/support-me/donate/
Tags: single post, previous, navigation, next, previous next, mootools 1.4, mootools, slider, superslider
Requires at least: 2.6
Tested up to: 3.3.1
Stable tag: 2.1

Automatically adds Next and Previous post thumbnail navigation to your single view post page.


== Description ==

Superslider-previousnext-thumbs is a previous-next post, thumbnail navigation creator. Works specifically on the single post pages.
Animated rollover controlled with css and from the plugin options page. Can create custom image sizes. Automaitcally insert before or 
after post content or both. Or you can manually insert into your single post theme file.


**Features**

* pulls thumbnails from previous and next posts.
* default thumbnails for posts with no images.
* post title size control
* create custom previous-next thumbnails.
* select image size to use in link.
* show before or after your post or both.

**Demos**

This plugin can be seen in use here:

* [Demo 1](http://superslider.daivmowbray.com/2010/superslider-previousnext-thumbs-demo/ "Demo 1")
* [Demo 2](http://superslider.daivmowbray.com/2010/superslider-previousnext-thumbs-demo-2/ "Demo 2")


**credits:**

* mootools - [Mootools](http://mootools.net/ "Your favorite javascript framework")

**Support**

If you have any problems or suggestions regarding this plugin [please speak up](http://wordpress.org/tags/superslider-previousnext-thumbs?forum_id=10 "support forum here at WordPress")

**Other Plugins**
Download These SuperSlider Plugins here:

* [SuperSlider](http://wordpress.org/extend/plugins/superslider/ "SuperSlider")
* [Superslider-PostsinCat](http://wordpress.org/extend/plugins/superslider-postsincat/ "Superslider-PostsinCat")
* [SuperSlider-Media-Pop](http://wordpress.org/extend/plugins/superslider-media-pop// "SuperSlider-Media-Pop")
* [SuperSlider-Image](http://wordpress.org/extend/plugins/superslider-image/ "SuperSlider-Image")
* [SuperSlider-Perpost-Code](http://wordpress.org/extend/plugins/superslider-perpost-code/ "SuperSlider-Perpost-Code")

**NOTICE**

* The downloaded folder's name should be superslider-previousnext-thumbs


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

== Upgrade Notice ==

You may need to re-save your settings/ options when upgrading

== USAGE ==

If you are not sure how this plugin works you may want to read the following.

* First ensure that you have uploaded all of the plugin files into wp-content/plugins/superslider-previousnext-thumbs folder.
* Go to your WordPress admin panel and stop in to the plugins control page. Activate the superslider-previousnext-thumbs plugin.
* Default settings provide for Pnext nav at the end of your page.
* Add optional function call in your single.php file inside your site theme folder.(you will need to deactivate the Automatic insertion.)
* Basic function call: `if(class_exists ('ssPnext') ) { $myssPnext = new ssPnext(); $myssPnext->ss_previous_next_nav();}`
* Complete, recommended function call (to be put inside of php open and close tags): 
`if(class_exists ('ssPnext') ) { $myssPnext = new ssPnext(); $myssPnext->ss_previous_next_nav('true');
    } else {
	echo '<div class="navigation"> <div class="alignleft">';
		 previous_post_link('&laquo; %link');
	echo '</div><div class="alignright">';
	       next_post_link('%link &raquo;');
	echo '</div></div>';
    }`

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

* Please use the support forums here at [WordPress forum for SuperSlider-PreviousNext-Thumbs](http://wordpress.org/tags/superslider-previousnext-thumbs?forum_id=10 "support forum here at WordPress")


== Frequently Asked Questions ==	

there are no Faq's yet

== Changelog ==

* 2.0 (2012/03/27)

  * fixed insert after post content
  * added insert before and after post content
  
* 1.0 (2011/12/15)

  * upgraded for WordPress 3.3 and mootools 1.4.1

* 0.6 (2010/06/02)

  * fixed link to settings page
  * added save options upon deactivation option

* 0.5 (2010/05/23 )

  * Changed the media options page layout

* 0.4 (2010/05/12)

  * Fixed bug, thumb creation user options failed to save correctly.

* 0.3 (2010/03/23)

  * Fixed bug, where content was echoed, instead of returning it for further processing.
  
* 0.2 (2010/02/26)

  * Fixed various bugs
  * upgraded functions for WP 3.0
  * Improved superslider-base integration

* 0.1.0_beta (2010/02/21)

    * first public launch

---------------------------------------------------------------------------