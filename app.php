<?php
/**
 * Plugin Name: Breadcrumbs Builder
 * Plugin URI: https://sygnoos.com
 * Description: Breadcrumbs Builder will allow you to add Breadcrumbss navigation section to your site and your visitors will know current path.
 * Version: 1.0.7
 * Author: Sygnoos
 * Author URI: https://www.sygnoos.com
 * Text Domain: sgbb
 * License: GPLv3
 */

if (!defined('WPINC')) {
    die;
}

require_once(dirname(__FILE__).'/com/config/bootstrap.php');
require_once(dirname(__FILE__).'/com/core/SGBB.php');

global $sgbb;

$sgbb = new SGBB();
$sgbb->app_path = realpath(dirname(__FILE__)).'/';
$sgbb->app_url = plugin_dir_url(__FILE__);
$sgbb->run();
