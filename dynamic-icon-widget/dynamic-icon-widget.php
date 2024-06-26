<?php
/**
 * Plugin Name: Dynamic Icon Widget
 * Description: A custom Elementor widget to dynamically select SVG icons.
 * Version: 1.0
 * Author: Luke
 */

if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

// Register the widget with Elementor
function register_dynamic_icon_widget($widgets_manager)
{
    require_once __DIR__ . "/widgets/dynamic-icon.php";
    $widgets_manager->register(new \Elementor\Widget_Dynamic_Icon());
}
add_action(
    "elementor/widgets/widgets_registered",
    "register_dynamic_icon_widget"
);
