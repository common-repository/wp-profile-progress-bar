<?php 

/*
	Plugin Name: WP Profile Progress Bar
	Version: 1.0
	Author: Rajesh Kumar Sharma
	Author URI: http://sitextensions.com
	Description: This plugin enables you to show the progress bar for profile competeness. This plugin also provides you the shortcode [wp-profile-progress-bar].
	Tags: WP Profile progress bar, progress bar, profile complete, complete profile in percent.
*/

add_shortcode('wp-profile-progress-bar', 'wp_profile_progress_bar');
function wp_profile_progress_bar(){
	if(is_user_logged_in()){

		$user_id = get_current_user_id();
		$userdata = get_userdata($user_id);

		$userdata = $userdata->data;
		$total_fields = count((array)$userdata);

		$usermeta = get_user_meta($user_id);
		$total_fields = $total_fields + count($usermeta);

		$filled_fields = 0;
		foreach ($userdata as $key => $value) {
			# code...
			if($value != ''){
				$filled_fields++;
			}
		}

		if(!empty($usermeta)){
			foreach ($usermeta as $key => $value) {
				# code...
				if(isset($value[0]) && $value[0] != ''){
					$filled_fields++;
				}
			}
		}

		$profile_complete = (($filled_fields / $total_fields) * 100);
		$profile_complete = round($profile_complete);

		$style = '<style>
					.progress{border:1px solid #ebebeb; padding:3px; text-align: center; font-size:11px;}
					.progress-bar{background-color:#ebebeb;}
				</style>';
		
		return $style . '<div class="progress">
				  	<div class="progress-bar" role="progressbar" aria-valuenow="'.$profile_complete.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$profile_complete.'%">
				    	'.$profile_complete.'%
				  	</div>
				</div>';
	}
	else{
		return 'Please login to show progress bar.';
	}
}