=== Yo! Manga Jquery-ui AutoComplete Search ===
Contributors: RajLaksh
Tags: jquery-ui,jquery,autocomplete,posts,light-weighted,search,post,plugin-options  
Requires at least: 3.2
Donate link: 
Tested up to: 4.1
Stable tag: trunk
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

It's Light-Weighted Jquery-Ui AutoComplete Search.

== Description ==

Want to show suggestion in default search box. This is the option it's light-weighed jquery-ui autocomplete search

== Installation ==

You can either install it automatically from the WordPress admin, or do it manually:

1. Unzip the archive and put the `yo_manga_auto_complete` folder into your plugins folder (/wp-content/plugins/).
1. Activate the plugin from the Plugins menu.

= Usage =

Go to *WP-Admin -> Plugins -> Yo! Manga Autocomplete Search* for configuration.

= Styling the CSS =

If you need to configure the CSS style of Yo! Manga AutoComplete Search, you can copy the `auto_complete.css` file from the plugin directory to your theme's directory and make your modifications there. This way, you won't lose your changes when you update the plugin.

== Upgrade Notice ==

Added Options Page.

== Screenshots ==

1. Default appearance
2. Options page

== Frequently Asked Questions ==

= Error on activation: "Parse error: syntax error, unexpected..." =

Make sure your host is running PHP 5. The only foolproof way to do this is to add this line to wp-config.php (after the opening `<?php` tag):

`var_dump(PHP_VERSION);`

= When I go to homepage its does not work why =

You're using Different id for Search Filed. Default is #s  == id="s"

== Changelog ==

= 1.2 =

Updated No Image Image file.

= 1.1 =

Updated Options Page 

= 1.0 = 

Fixed Options page

= 0.9 =

Update Search Query.

= 0.8 =
* Custom Design of Jquery-Ui AutoComplete search.