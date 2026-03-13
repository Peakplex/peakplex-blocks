<?php
/**
 * Plugin Name: Peakplex Blocks
 * Description: Reusable blocks used across my websites.
 * Version: 1.1.4
 * Author: Peakplex Internet
 * Author URI: https://peakplex.com
 * Icon: icon-128x128.png
 * Icon-2x: icon-256x256.png
 */

if (!defined('ABSPATH')) exit;

// Require the plugin update checker library
require __DIR__ . '/plugin-update-checker-master/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

// ------------------------------
// 1. Build the update checker for GitHub public repo
// ------------------------------
$updateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/Peakplex/peakplex-blocks', // public GitHub repo URL
    __FILE__,
    'peakplex-blocks'
);

$updateChecker->setBranch('main'); // track main branch or master

// ------------------------------
// 2. Force fast update checks for testing / immediate detection
// ------------------------------
add_action('admin_init', function() {
    if (current_user_can('update_plugins')) {
        delete_site_transient('update_plugins');
    }
});

// ------------------------------
// 3. Load ACF JSON field groups
// ------------------------------
add_filter('acf/settings/load_json', function($paths) {
    $paths[] = plugin_dir_path(__FILE__) . 'acf-json';
    return $paths;
});

// ------------------------------
// 4. Auto-register all blocks in /blocks
// ------------------------------
add_action('acf/init', function() {
    if (!function_exists('acf_register_block_type')) return;

    $blocks_dir = plugin_dir_path(__FILE__) . 'blocks/';
    $folders = array_filter(glob($blocks_dir . '*'), 'is_dir');

    foreach ($folders as $folder) {
        $slug = basename($folder);
        $template = $folder . '/template.php';

        acf_register_block_type([
            'name' => $slug,
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'render_template' => file_exists($template) ? $template : '',
            'category' => 'layout',
            'mode' => 'auto',
            'supports' => ['align' => true, 'anchor' => true],
        ]);
    }
});

// ------------------------------
// 5. Allow plugin blocks even if theme disables blocks
// ------------------------------
add_filter('allowed_block_types_all', function($allowed_blocks, $editor_context) {
    $blocks_dir = plugin_dir_path(__FILE__) . 'blocks/';
    $folders = array_filter(glob($blocks_dir . '*'), 'is_dir');

    $plugin_blocks = array_map(function($folder) {
        return 'acf/' . basename($folder);
    }, $folders);

    return array_merge($allowed_blocks ?: [], $plugin_blocks);
}, 10, 2);

// ------------------------------
// 6. Enqueue block CSS/JS for frontend + editor
// ------------------------------
add_action('enqueue_block_assets', function() {
    $blocks_dir = plugin_dir_path(__FILE__) . 'blocks/';

    foreach (glob($blocks_dir . '*/**/*.css') as $css) {
        wp_enqueue_style(
            'peakplex-' . basename($css, '.css'),
            plugins_url('blocks/' . basename(dirname($css)) . '/' . basename($css), __FILE__),
            [],
            filemtime($css)
        );
    }

    foreach (glob($blocks_dir . '*/**/*.js') as $js) {
        wp_enqueue_script(
            'peakplex-' . basename($js, '.js'),
            plugins_url('blocks/' . basename(dirname($js)) . '/' . basename($js), __FILE__),
            ['wp-blocks', 'wp-element', 'wp-editor'],
            filemtime($js),
            true
        );
    }
});