<?php

/*
Plugin Name: Test plugin to learn WP plugin dev
Plugin URI: https://github.com/Prin-S/test-plugin-to-learn-wp-plugin-development
Description: The plugin was created to help me learn WordPress plugin development. It displays a meta box below each post allowing you to add contributors (must be author, editor or administrator) to that post. These contributors are then shown on the front-end.
Author: Prin S
Author URI: https://github.com/Prin-S
Version: 1.0
*/

// Defines plugin filesystem directory path as a constant
define( 'LEARN_WP_PLUGIN_DEV_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Loads certain files on a certain part of the site
if ( is_admin() ) {
    include LEARN_WP_PLUGIN_DEV_PLUGIN_PATH . 'includes/admin-side.php'; // Admin-side
} else {
    include LEARN_WP_PLUGIN_DEV_PLUGIN_PATH . 'includes/front-end.php'; // Front-end
    include LEARN_WP_PLUGIN_DEV_PLUGIN_PATH . 'includes/scripts.php'; // Controls all CSS
}
