=== YouTube Feed ===
Contributors: plumwd
Donate link: http://www.plumeriawebdesign.com
Tags: youtube video feed, youtube shortcode
Requires at least: 2.0.2
Tested up to: 3.5.2
Stable Tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

YouTube Feed allows for easy placement of a YouTube video feed anywhere on your posts, pages, or widgets using a shortcode.

== Description ==

YouTube Feed allows for easy placement of a YouTube video feed anywhere on your posts, pages, or widgets using a shortcode.

* Specify the YouTube video feed
* Specify the number of videos to display
* Set the display to horizonal or vertical
* Set the thumbnail size

== Installation ==

1. Download and unzip the file.
2. Place the entire contents of the directory into your `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Shortcode editor 
2. Live Example 

== Shortcode Usage ==

1. To add a YouTube feed to your posts, pages, or widgets use the following code:
    [plumwd_youtube_display]
2. To add the YouTube Feed plugin to your WordPress theme use the following code inside your template: `echo do_shortcode('[plumwd_youtube_display]');`

The plugin also supports several attributes for the shortcode, below is a listing of the attributes and what their purpose is: 

1.  channel -> this must be set or the feed will not display Usage:
    [plumwd_youtube_display channel="plumwd"]
    
2.  videonum -> The number of videos to display. Will return the most recent videos uploaded to the feed. Usage:
    [plumwd_youtube_display channel="plumwd" videonum="4"]
    
3.  display -> accepts two different options: horizontal or vertical. Usage:
    [plumwd_youtube_display channel="plumwd" display="horizonal"]
    
4.  size -> Choose from four different size options xsmall, small, medium, large. Usage:
    [plumwd_youtube_display channel="plumwd" size="small"]

	== Frequently Asked Questions ==

For help please visit http://www.plumeriawebdesign.com

== Changelog ==

= 1.1.1 =
* Fixed broken path

= 1.1 =
* Changed how the feed is grabbed so that the file is stored locally


= 1.0.1 =
* Fixed footer credits
