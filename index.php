<?php
/*
Plugin Name: YouTube Feed
Plugin URI: http://www.plumeriawebdesign.com/youtube-feed-plugin/
Description: Add a YouTube Feed list to your site
Author: Elke Hinze, Plumeria Web Design
Version: 1.1
Author URI: http://www.plumeriawebdesign.com
*/
function plumwd_youtube_feed_menu(){
  $file = dirname(__FILE__) . '/index.php';
  $plugin_dir = plugin_dir_url($file);
  
  add_menu_page('YouTube Feed', 'YouTube Feed', 'manage_options', 'youtubefeed-options', 'youtube_feed_settings', $plugin_dir.'images/youtube-16.png');
}
add_action('admin_menu', 'plumwd_youtube_feed_menu');

function youtube_feed_settings() {
 $plugin_url = plugins_url();
?>
 <div id="wrap">
<h1 id="youtubeh1">YouTube Feed</h1>
<div class="youtube-feed-welcome">
<p><?php _e('This is where you will find the reference for the YouTube Feed options.  YouTube Feed is a very simple plugin, consisting of a configurable shortcode allowing you to embed
a YouTube Feed anywhere on your WordPress site via a shortcode.','youtubefeed' ) ?></p>
<p>The shortcode outputs a series of thumbnails taken directly from the specified YouTube feed and displays them in order from newest to oldest. While it does not play the video on screen,
it links to the video at YouTube.</p>
<ul>
<li>To add a YouTube feed to your posts, pages, or widgets use the following shortcode:<br/><code>[plumwd_youtube_display]</code></li>
<li>To add the YouTube Feed plugin to your WordPress theme use the following shortcode inside your template:<br/><code>echo do_shortcode('[plumwd_youtube_display]');</code></li>
</ul>

The plugin also supports several attributes for the shortcode, below is a listing of the attributes and what their purpose is:
<ol>
<li>channel -&gt; this <strong>must</strong> be set or the feed will not display. Usage:<br/><code>[plumwd_youtube_display channel="plumwd"]</code></li>
<li>videonum -&gt; The number of videos to display. Will return the most recent videos uploaded to the feed. Usage:<br/><code>[plumwd_youtube_display channel="plumwd" videonum="4"]</code></li>
<li>display -&gt; accepts two different options: horizontal or vertical. Usage:<br/><code>[plumwd_youtube_display channel="plumwd" display="horizonal"]</code></li>
<li>size -&gt; Choose from four different size options xsmall, small, medium, large. Usage:<br/><code>[plumwd_youtube_display channel="plumwd" size="small"]</code></li>
</ol>
</div>
<div style="width:35%;float:right;">
  <div class="metabox-holder postbox" style="padding-top:0;margin:10px;cursor:auto;width:30%;float:left;min-width:320px">
    <h3 class="hndle" style="cursor: auto;"><span><?php  _e( 'Thank you for using YouTube Feed', 'youtubefeed' ); ?></span></h3>
    <div class="inside youtubefeed">
      <img src="<?php echo $plugin_url;?>/youtubefeed/images/banner.jpg" alt="YouTube Feed Banner" />
  	  <?php _e( 'Please support Plumeria Web Design so we can continue making rocking plugins for you. If you enjoy this plugin, please consider offering a small donation. We also look forward
	  to your comments and suggestions so that we may further improve our plugins to better serve you.', 'youtubefeed' ); ?>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="SLYFNBZU8V87W">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

    </div>
  </div>
</div>
</div>
<?php	
}


function plumwd_youtube_shortcodes() {
	add_shortcode( 'plumwd_youtube_display', 'display_plumwd_youtube_feed');
}
add_action('init', 'plumwd_youtube_shortcodes');

function display_plumwd_youtube_feed($atts) {
  $file = dirname(__FILE__) . '/index.php';
  $plugin_dir = plugin_dir_path($file);
	
  extract(shortcode_atts(array('videonum' => '', 'channel' => '', 'display' => '', 'size' => ''), $atts));
  
  if ($videonum == "") {
	$videonum = 4;  
  }
  
  $videourl = "https://gdata.youtube.com/feeds/api/users/$channel/uploads?v=2&alt=json";
  $ch = curl_init($videourl);
  $fp = fopen($plugin_dir."videos.json", "w");

  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_HEADER, 0);

  curl_exec($ch);
  curl_close($ch);
  fclose($fp);
  
  $videos = file_get_contents($plugin_dir."videos.json");	
  $obj = json_decode($videos, true);
  $feed = $obj['feed'];
  $entries = $feed['entry'];
  $row = array(); 
  $thumbsize = 0;
  
  switch($size) {
	case "xsmall":
	  $thumbsize = 0;  
	  break;  
	case "small":
	  $thumbsize = 1;
	  break;
	case "medium":
	  $thumbsize = 2;
	  break;
	case "large":
	  $thumbsize = 3;
	  break;
	default:
	  $thumbsize = 0;
  }

  foreach($entries as $key => $val) {
   $row[$key]['title'] = $val['title']['$t'];
   $row[$key]['link'] = $val['link'][0]['href'];
   $row[$key]['published'] = $val['published']['$t'];
   $row[$key]['thumbnail'] = $val['media$group']['media$thumbnail'][$thumbsize]['url'];
  }
  
  if ($display == "") {
	$display = "vertical";  
  }
  
  if ($display == "horizontal") {
	$width = (100/$videonum)-1;  
	$liwidth = "style=\"width: ".$width."%;\" ";
  } else {
	$liwidth = "style=\"width: 100%;\" ";  
  }

  echo "<ul id=\"youtube_feed\" class=\"".$display."\">\n";
  for ($i = 0; $i < $videonum; $i++) {
   echo "<li ".$liwidth.">";
   echo "<a href=\"".$row[$i]['link']."\">\n";
   echo "<img src=\"".$row[$i]['thumbnail']."\" alt=\"".$row[$i]['title']."\" title=\"".$row[$i]['title']."\" />";
   echo "</a>";
   echo "</li>\n";
  }
  echo "</ul>\n";
}

//let's make the button to add the shortcode
function add_button_sc_plumwd_youtube() {
 add_filter('mce_external_plugins', 'add_plugin_sc_plumwd_youtube');  
 add_filter('mce_buttons', 'register_button_sc_plumwd_youtube');  
}
add_action('init', 'add_button_sc_plumwd_youtube');

//we need to register our button
function register_button_sc_plumwd_youtube($pyt_buttons) {
array_push($pyt_buttons, "plumwd_youtube_display");
return $pyt_buttons;  
}

function add_plugin_sc_plumwd_youtube($pyt_plugin_array) {
$plugin_url = plugins_url();
$script_url = $plugin_url.'/youtube-video-feed/scripts/shortcode.js';
$pyt_plugin_array['plumwd_youtube_display'] = $script_url; 
return $pyt_plugin_array;
}

function plumwd_yt_enqueue_scripts() {
  $file = dirname(__FILE__) . '/index.php';
  $plugin_dir = plugin_dir_url($file);

  wp_register_style('plumwd-youtube-feed', $plugin_dir.'css/youtubestyle.css', '', '', 'screen');
  wp_enqueue_style('plumwd-youtube-feed');
}
add_action('wp_enqueue_scripts', 'plumwd_yt_enqueue_scripts');
function plumwd_youtube_feed_admin_footer_text($my_footer_text) {
  $plugin_url = plugins_url();
  $my_footer_text = "<span class=\"credit\"><img src=\"$plugin_url/youtubefeed/images/plumeria.png\" alt=\"Plumeria Web Design Logo\"/><a href=\"http://www.plumeriawebdesign.com/youtube-feed-plugin\">YouTube Feed</a>. Developed by <a href=\"http://www.plumeriawebdesign.com\">Plumeria Web Design</a></span>";
	return $my_footer_text;
}

if(isset($_GET['page'])) {
  if ($_GET['page'] == "youtubefeed-options") {
    add_filter('admin_footer_text', 'plumwd_youtube_feed_admin_footer_text');
  }
}

function plumwd_youtube_feed_enqueue_scripts() {
  $file = dirname(__FILE__) . '/index.php';
  $plugin_dir = plugin_dir_url($file);

  wp_register_style('plumwd-youtube-feed', $plugin_dir.'css/admin-style.css', '', '', 'screen');
  wp_enqueue_style('plumwd-youtube-feed');
}
add_action('admin_enqueue_scripts', 'plumwd_youtube_feed_enqueue_scripts');

?>