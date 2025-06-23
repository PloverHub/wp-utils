<?php

namespace PloverHubUtils;

class Utils
{
    /**
     * Fetches the file path residing inside the theme folder.
     *
     * It will first check if the file exists within the child theme.
     * If not, it will attempt to fetch it from the parent theme.
     * If the file is not found in either, it will log an error via error_log.
     *
     * @param string $file_name The name of the file to fetch.
     *
     * @return string The file path if found, otherwise an empty string.
     */
    public static function get_tpl_path(string $file_name): string
    {
        $file_name = ltrim($file_name, '/\\');

        $child_file_path = trailingslashit(get_stylesheet_directory()) . $file_name;
        if (file_exists($child_file_path)) {
            return $child_file_path;
        }

        $parent_file_path = trailingslashit(get_template_directory()) . $file_name;
        if (file_exists($parent_file_path)) {
            return $parent_file_path;
        }

        if (defined('WP_DEBUG') && WP_DEBUG) {
            trigger_error("PloverHubUtils: Cannot locate file: {$file_name}", E_USER_WARNING);
        }

        return '';
    }

    /**
     * Loads a file residing inside the theme folder.
     *
     * It will first check if the file exists within the child theme.
     * If not, it will attempt to load it from the parent theme.
     * If the file is not found in either, it will log an error via error_log.
     *
     * @param string $file_name The name of the file to load.
     */
    public static function load_tpl(string $file_name): void
    {
        $file_name = ltrim($file_name, '/\\');

        // Check in child theme first
        $child_file_path = trailingslashit(get_stylesheet_directory()) . $file_name;
        if (file_exists($child_file_path)) {
            include_once $child_file_path;

            return;
        }

        // Then check in parent theme
        $parent_file_path = trailingslashit(get_template_directory()) . $file_name;
        if (file_exists($parent_file_path)) {
            include_once $parent_file_path;

            return;
        }

        // Log failure
        if (defined('WP_DEBUG') && WP_DEBUG) {
            trigger_error("PloverHubUtils: Cannot load file: {$file_name}", E_USER_WARNING);
        }
    }
}
