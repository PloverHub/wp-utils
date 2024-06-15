<?php

namespace ClaraPressComponents;

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
    public static function get_theme_file_path(string $file_name): string
    {
        $child_file_path = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $file_name;
        if (file_exists($child_file_path)) {
            return $child_file_path;
        }

        $parent_file_path = get_template_directory() . DIRECTORY_SEPARATOR . $file_name;
        if (file_exists($parent_file_path)) {
            return $parent_file_path;
        }

        error_log('Cannot load file: ' . $file_name);

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
    public static function load_theme_file(string $file_name): void
    {
        $child_file_path = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $file_name;
        $parent_file_path = get_template_directory() . DIRECTORY_SEPARATOR . $file_name;

        if (file_exists($child_file_path)) {
            include $child_file_path;
        } elseif (file_exists($parent_file_path)) {
            include $parent_file_path;
        } else {
            error_log('Cannot load file at: ' . $file_name);
        }
    }
}
