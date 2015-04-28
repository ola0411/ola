<?php
/*
Plugin Name: Yo! Manga Jquery-ui AutoComplete Search
Plugin URI: 
Description: Its jquery Ui-Autocomplete Custom Search. Light Weighted. 
Author: Yo! Manga
Version: 1.2
Author URI: http://www.yomanga.com/
License: GPLv2 or later (http://www.gnu.org/licenses/gpl-2.0.html) 
*/

defined('ABSPATH') or die("No script kiddies please!");

// define images and ajax
$plugins_files_dir = plugin_dir_url( __FILE__ );
$auto_complete_url = admin_url( 'admin-ajax.php' );
$yo_manga_no_img = plugins_url('images/no-img.png', __FILE__ );

define('yo_manga_ajx_dir',$plugins_files_dir);
define('yo_manga_ajx_path', $auto_complete_url);
define('yo_manga_no_img', $yo_manga_no_img);

$yo_manga_ajx_get = get_option('yo_manga_ajx_settings');

// get autocomplete is enable
$autocomplete_on = $yo_manga_ajx_get['turn_on'];

if(!empty($autocomplete_on) && isset($autocomplete_on) ) {

// Load AutoComplete JavaScripts
function yo_manga_ajx_js_load() {
wp_enqueue_script('jquery-ui-core',array('jquery'));
wp_enqueue_script('jquery-ui-autocomplete',array('jquery'));
wp_enqueue_script('yo_manga_auto_complete',yo_manga_ajx_dir . 'auto_complete.js',array('jquery'));
wp_enqueue_style('yo_manga_auto_complete_css',yo_manga_ajx_dir . 'auto_complete.css');
}
add_action('wp_enqueue_scripts','yo_manga_ajx_js_load');
}
?>
<?php
// Plugins Options

function yo_manga_ajx_options() {
add_plugins_page('Yo! Manga Autocomplete', 'Yo! Manga AutoComplete', 'read', 'yo_manga_ajx', 'yo_manga_ajx_options_page');
}
add_action( 'admin_menu', 'yo_manga_ajx_options' );

// Register Plugins Settings
function yo_manga_ajx_settings_register(){
register_setting( 'plugins_settings', 'yo_manga_ajx_settings' , 'yo_manga_ajx_validate' );

add_settings_section( 'ajx_setting', 'Turn On/off AutoComplete', '__return_false', 'yo_manga_ajx' );

add_settings_section( 'search_settings', 'Main Settings', '__return_false', 'yo_manga_ajx' );

add_settings_field( 'turn_on', 'Enable AutoComplete Search', 'turn_on_ajx', 'yo_manga_ajx', 'ajx_setting' );

add_settings_field( 'search_box', 'Default Search Box', 'search_box_ajx', 'yo_manga_ajx', 'search_settings' );

add_settings_field( 'min_length', 'Minimum Length', 'min_length_ajx', 'yo_manga_ajx', 'search_settings' );

global $options;
$options = get_option( 'yo_manga_ajx_settings' );

function turn_on_ajx() {
global $options;
$get_on = $options['turn_on'];
?>
<input type='checkbox' name='yo_manga_ajx_settings[turn_on]' value='1' <?php checked( 1 == $get_on ); ?>/>
<?php
}

function min_length_ajx() {
global $options;
echo "<input type='text' name='yo_manga_ajx_settings[min_length]' value='".esc_attr($options['min_length'])."' size='40'/>";
}

function search_box_ajx() {
global $options;
echo "<input type='text' name='yo_manga_ajx_settings[search_box]' value='".esc_attr($options['search_box'])."' size='40'/>";
}

} 
add_action( 'admin_init', 'yo_manga_ajx_settings_register' );


function yo_manga_ajx_settings_exist( ) { 

//Default Values
$default_options = get_option('yo_manga_ajx_settings',array());

$default_value = array(
	'turn_on' => '1',
	'search_box' => "#s",
	'min_length' => "1"
);

$new_options = wp_parse_args( $default_options, $default_value );


if( false == get_option( 'yo_manga_ajx_settings' ) ) { 
add_option('yo_manga_ajx_settings',$default_value);
}
}
register_activation_hook( __FILE__, 'yo_manga_ajx_settings_exist' );

//start settings page
function yo_manga_ajx_options_page() { ?>

<h1>Yo! Manga AutoComplete Options</h1>

<?php if( isset($_GET['settings-updated']) ) { ?>
<div id="message" class="updated">
<p><strong><?php _e('Settings saved.','Yo! Manga') ?></strong></p>
</div>
<?php } ?>
<form method="post" action="options.php">

<?php settings_fields( 'plugins_settings' ); 
do_settings_sections('yo_manga_ajx'); 
submit_button();
?>
</form>


<?php
} 
// Validation 
function yo_manga_ajx_validate ($input) {
$input['turn_on'] = absint($input['turn_on']);
$input['search_box'] = sanitize_text_field($input['search_box']);
$input['min_length'] = absint($input['min_length']);
return $input;
}
?>
<?php
// Define Java Script Variables
function yo_manga_define() {
$get_default_vers = get_option( 'yo_manga_ajx_settings' );
$min_length = $get_default_vers['min_length'];
$search_filed = $get_default_vers['search_box'];
echo "<script type='text/javascript'>\r\n";  ?>
var ajx_path = '<?php echo yo_manga_ajx_path; ?>'; 
var url = '<?php echo home_url(); ?>';
var no_img = '<?php echo yo_manga_no_img; ?>';
var min_Length = '<?php echo $min_length; ?>';
var search_box = '<?php echo $search_filed; ?>';
<?php  echo "</script>\r\n ";
}
add_action('wp_head','yo_manga_define');

// Get Post Results 
function yo_manga_search_results() {

if(empty($_REQUEST['term'])){
echo "[ ]";
die();
}
else {
global $wpdb;

$keyword = esc_html($_REQUEST['term']);

$search_value = sanitize_text_field($keyword);

$posts_resutls = $wpdb->get_results( 
	"
	SELECT * 
	FROM $wpdb->posts
	WHERE post_title COLLATE UTF8_GENERAL_CI LIKE '$search_value%' and post_status = 'publish' and post_type = 'post'
	order by post_title
	limit 20
	"
, ARRAY_A);
if($wpdb->num_rows == 0) {
$posts_resutls = $wpdb->get_results( 
	"
	SELECT * 
	FROM $wpdb->posts
	WHERE post_title COLLATE UTF8_GENERAL_CI LIKE '%$search_value%' and post_status = 'publish' and post_type = 'post'
	order by post_title
	limit 20
	"
, ARRAY_A);
}
if(!empty($posts_resutls)) {

foreach($posts_resutls as $row) {
$post_id = $row['ID'];

$attach_img = wp_get_attachment_url( get_post_thumbnail_id($post_id, 'thumbnail'));

if(empty($attach_img)) {
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $row['post_content'], $matches);

$thumb_img = !empty($matches[1][0]) ? $matches[1][0] : "";
}
else {
$thumb_img = $attach_img;
}
if($thumb_img) {
$img = $thumb_img;
}
else {
$img = yo_manga_no_img;
}
$post_timer = get_the_time('F j, Y \a\t g:ia', $post_id);
$post_name = $row['post_title'];
$post_url = get_permalink($post_id);
$post_date = $post_timer;
$post_author = $row['post_author'];

$user_data = $wpdb->get_results( 
	"
	SELECT * 
	FROM $wpdb->users
	WHERE id = '$post_author' 
	"
, ARRAY_A);

foreach($user_data as $poster_info) {
$poster_name = $poster_info['user_login'];
}


$post_list[] = array("title" => "$post_name","slug" => "$post_url","pubdate" => "$post_date","post_author" => "$poster_name","post_img" => "$img");
}
echo json_encode($post_list);
die();
}
else { echo "No Results Found!"; die();}
}
}
add_action('wp_ajax_autocompleteCallback', 'yo_manga_search_results');
add_action('wp_ajax_nopriv_autocompleteCallback', 'yo_manga_search_results');
?>