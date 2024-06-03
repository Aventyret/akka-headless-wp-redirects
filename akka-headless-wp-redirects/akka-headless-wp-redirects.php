<?php
/*
Plugin Name: Akka Headless WP – Redirects
Plugin URI: https://github.com/aventyret/akka-wp/blob/main/plugins/akka-headless-wp-redirects
Description: Redirects plugin for Akka
Author: Mediakooperativet, Äventyret
Author URI: https://aventyret.com
Version: 0.3.9
*/

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
    die('Invalid URL');
}

if (defined('AKKA_HEADLESS_WP_REDIRECTS'))
{
    die('Invalid plugin access');
}

define('AKKA_HEADLESS_WP_REDIRECTS',  __FILE__ );
define('AKKA_HEADLESS_WP_REDIRECTS_DIR', plugin_dir_path( __FILE__ ));
define('AKKA_HEADLESS_WP_REDIRECTS_URI', plugin_dir_url( __FILE__ ));
define('AKKA_HEADLESS_WP_REDIRECTS_VER', "0.3.9");

require_once(AKKA_HEADLESS_WP_REDIRECTS_DIR . 'includes/ahw-redirects.php');
require_once(AKKA_HEADLESS_WP_REDIRECTS_DIR . 'includes/ahw-redirects-acf-fields.php');
require_once(AKKA_HEADLESS_WP_REDIRECTS_DIR . 'public/ahw-redirects-hooks.php');
