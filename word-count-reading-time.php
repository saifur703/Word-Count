<?php

/*
Plugin Name: Word Count & Reading Time
Plugin URI: https://github.com/saifur703/Word-Count
Author: Saifur Rahman
Author URI: https://github.com/saifur703/
Description: Count Words and Reading Time from any WordPress post.
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: word-count
Domain Path: /languages
 */

/**
 * Activation hook
 */
function word_count_activation_hook()
{

}
register_activation_hook(__FILE__, "word_count_activation_hook");

/**
 * Deactivation hook
 */
function word_count_deactivation_hook()
{

}
register_deactivation_hook(__FILE__, "word_count_deactivation_hook");

/**
 * Load text domain
 */
function word_count_load_text_domain()
{
    load_plugin_textdomain("word-count", false, dirname(__FILE__) . "/languages");
}
add_action("plugin_loaded", "word_count_load_text_domain");

/**
 * Count Words from any post
 */
function word_count_count_words($content)
{
    $stripped_content = strip_tags($content);
    $word_number = str_word_count($stripped_content);
    $label = __("Total Number of Words", "word-count");

    $label = apply_filters("word_count_heading", $label);
    $tag = apply_filters("word_count_tag", "h2");
    $content .= sprintf('<%s>%s: %s</%s>', $tag, $label, $word_number, $tag);

    return $content;
}
add_filter("the_content", "word_count_count_words");

/**
 * Reading time
 */
function word_count_reading_time($content)
{
    $stripped_content = strip_tags($content);
    $word_number = str_word_count($stripped_content);

    $reading_minute = floor($word_number / 200);
    $reading_seconds = floor($word_number % 200 / (200 / 60));

    $is_visible = apply_filters("word_count_display_reading_time", 1);

    if ($is_visible) {
        $label = __("Total Reading Time", "word-count");
        $label = apply_filters("word_count_reading_time_heading", $label);
        $tag = apply_filters("word_count_reading_time_tag", "h2");

        $content .= sprintf('<%s>%s: %s minutes %s seconds</%s>', $tag, $label, $reading_minute, $reading_seconds, $tag);

    }

    return $content;
}
add_filter("the_content", "word_count_reading_time");