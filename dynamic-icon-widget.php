<?php
/**
 * Plugin Name: Dynamic Icon Widget
 * Description: A custom Elementor widget to dynamically select SVG icons.
 * Version: 1.1.0
 * Author: Luke
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Requires Plugins: elementor
 * Text Domain: dynamic-icon-widget
 */

namespace DynamicIconWidget;

if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

const MINIMUM_ELEMENTOR_VERSION = "3.5.0";

// Register the widget with Elementor
function register_dynamic_icon_widget($widgets_manager)
{
    require_once __DIR__ . "/widgets/dynamic-icon.php";
    $widgets_manager->register(new Widget_Dynamic_Icon());
}

function init_plugin()
{
    if (!did_action("elementor/loaded")) {
        add_action(
            "admin_notices",
            __NAMESPACE__ . "\\admin_notice_missing_elementor"
        );
        return;
    }

    if (version_compare(ELEMENTOR_VERSION, MINIMUM_ELEMENTOR_VERSION, "<")) {
        add_action(
            "admin_notices",
            __NAMESPACE__ . "\\admin_notice_minimum_elementor_version"
        );
        return;
    }

    add_action(
        "elementor/widgets/register",
        __NAMESPACE__ . "\\register_dynamic_icon_widget"
    );
}
add_action("plugins_loaded", __NAMESPACE__ . "\\init_plugin");

function admin_notice_missing_elementor()
{
    if (!current_user_can("activate_plugins")) {
        return;
    }
    ?>
    <div class="notice notice-warning">
        <p>
            <?php esc_html_e(
                "Dynamic Icon Widget requires Elementor to be installed and active.",
                "dynamic-icon-widget"
            ); ?>
        </p>
    </div>
    <?php
}

function admin_notice_minimum_elementor_version()
{
    if (!current_user_can("activate_plugins")) {
        return;
    }
    ?>
    <div class="notice notice-warning">
        <p>
            <?php
            printf(
                /* translators: %s: Required Elementor version. */
                esc_html__(
                    "Dynamic Icon Widget requires Elementor version %s or greater.",
                    "dynamic-icon-widget"
                ),
                esc_html(MINIMUM_ELEMENTOR_VERSION)
            );
            ?>
        </p>
    </div>
    <?php
}
