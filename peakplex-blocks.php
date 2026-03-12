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

require __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/Peakplex/peakplex-blocks/',
    __FILE__,
    'peakplex-blocks'
);

// If your repo is private, authenticate with a GitHub Personal Access Token
$updateChecker->setAuthentication('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');

$updateChecker->setBranch('main');