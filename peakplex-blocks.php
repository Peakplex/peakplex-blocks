<?php
/**
 * Plugin Name: Peakplex Blocks
 * Description: Reusable blocks used across my websites.
 * Version: 1.0.6
 * Author: Peakplex Internet
 * Author URI: https://peakplex.com
 * Icon: icon-256x256.png
 */

if (!defined('ABSPATH')) {
    exit;
}

// Require the plugin update checker library first
require __DIR__ . '/plugin-update-checker-master/plugin-update-checker.php';

// Build the update checker using fully-qualified class name
$updateChecker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
    'https://github.com/Peakplex/peakplex-blocks/',
    __FILE__,
    'peakplex-blocks'
);

// Check the main branch for updates
$updateChecker->setBranch('main');