<?php
/*
Plugin Name: NaNoWriMo Word Count tracker
Version: 0.2
Plugin URI: http://darrenmeehan.me/wordpress/nanowrimo-tracker/
Description: Tracks your progress in National Novel Writing Month. This WordPress plugin presumes you're using a blog which is only being used for your NaNoWriMo entry.
Author: Darren Meehan
Author URI: http://darrenmeehan.me
Tags: admin, tracking, post
*/

// Thanks to Joost de Valk from Yoast.com, for the Blog Metrics plugin which helped with handling post stats -  http://yoast.com/wordpress/blog-metrics/
// Credit for a lot of this code goes to Matt for his famour Hello Dolly plugin.


/**

TODO 

Currently the plugin counts all words, from every post, by every user.

-create options to allow user to decide on the categories/post type and user to include.
-need to decide on whether drafts should be included
-widget showing more info
-shortcode showing more info

**/

// This just echoes the output, we'll position it later
function dm_tracker_output() {	
	
	global $wpdb;
	
	$postsquery = "SELECT COUNT(ID) FROM $wpdb->posts p WHERE p.post_type = 'post' AND p.post_status='publish' AND name='$desired_category'"; 
	$dm_words		= $wpdb->get_var($postsquery);
	echo "<p id='dm_tracker'>Your NaNoWriMo progress: <b>$dm_words</b>/50,000</p>";
}

 // meta.meta_value >= '{$today}'


// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'dm_tracker_output' );

// We need some CSS to position the paragraph
function dm_tracker_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#dm_tracker {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;		
		margin: 0;
		font-size: 12px;
	}
	</style>
	";
}

add_action( 'admin_head', 'dm_tracker_css' );