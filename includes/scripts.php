<?php

// Loads CSS only on front-end of posts
function lwppd_load_scripts() {
	if ( is_single() ) {
		wp_enqueue_style( 'lwppd-css', plugins_url('css/plugin-stylesheet.css', __FILE__ ), array(), '1.0.0' );
	}
}
add_action( 'wp_enqueue_scripts', 'lwppd_load_scripts' );
