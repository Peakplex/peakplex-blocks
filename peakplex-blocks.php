<?php
/**
 * Plugin Name: Peakplex Blocks
 * Description: Reusable blocks used across my websites.
 * Version: 1.0.0
 * Author: Peakplex Internet
 */

if (!defined('ABSPATH')) {
    exit;
}

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

require __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

// Build the update checker
$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/Peakplex/peakplex-blocks/',
    __FILE__,
    'peakplex-blocks'
);

// Only for private repo
$updateChecker->setAuthentication('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');

$updateChecker->setBranch('main');