<?php
namespace DynamicIconWidget;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;

if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

class Widget_Dynamic_Icon extends Widget_Base
{
    public function get_name()
    {
        return "dynamic-icon";
    }

    public function get_title()
    {
        return esc_html__("Dynamic Icon", "dynamic-icon-widget");
    }

    public function get_icon()
    {
        return "eicon-favorite";
    }

    public function get_categories()
    {
        return ["basic"];
    }

    public function get_keywords()
    {
        return ["icon", "svg", "dynamic"];
    }

    protected function register_controls()
    {
        $this->start_controls_section("section_icon", [
            "label" => esc_html__("Icon", "dynamic-icon-widget"),
        ]);

        $this->add_control("icon_svg", [
            "label" => esc_html__("Icon SVG", "dynamic-icon-widget"),
            "type" => Controls_Manager::MEDIA,
            "media_type" => "image",
            "description" => esc_html__(
                "Select an SVG file for the icon. The selected media must be a valid SVG attachment in the WordPress media library.",
                "dynamic-icon-widget"
            ),
            "dynamic" => [
                "active" => true,
            ],
        ]);

        $this->add_control("view", [
            "label" => esc_html__("View", "dynamic-icon-widget"),
            "type" => Controls_Manager::SELECT,
            "options" => [
                "default" => esc_html__("Default", "dynamic-icon-widget"),
                "stacked" => esc_html__("Stacked", "dynamic-icon-widget"),
                "framed" => esc_html__("Framed", "dynamic-icon-widget"),
            ],
            "default" => "default",
            "prefix_class" => "elementor-view-",
        ]);

        $this->add_control("shape", [
            "label" => esc_html__("Shape", "dynamic-icon-widget"),
            "type" => Controls_Manager::SELECT,
            "options" => [
                "circle" => esc_html__("Circle", "dynamic-icon-widget"),
                "square" => esc_html__("Square", "dynamic-icon-widget"),
            ],
            "default" => "circle",
            "condition" => [
                "view!" => "default",
            ],
            "prefix_class" => "elementor-shape-",
        ]);

        $this->add_control("link", [
            "label" => esc_html__("Link", "dynamic-icon-widget"),
            "type" => Controls_Manager::URL,
            "dynamic" => [
                "active" => true,
            ],
        ]);

        $this->add_control("aria_label", [
            "label" => esc_html__(
                "Accessible Label (aria-label)",
                "dynamic-icon-widget"
            ),
            "type" => Controls_Manager::TEXT,
            "dynamic" => [
                "active" => true,
            ],
            "description" => esc_html__(
                "Adds an aria-label to the link, for screen reader users. If left blank, the selected SVG attachment's media library title is used as a fallback where available.",
                "dynamic-icon-widget"
            ),
            "condition" => [
                "link[url]!" => "",
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section("section_style_icon", [
            "label" => esc_html__("Icon", "dynamic-icon-widget"),
            "tab" => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control("align", [
            "label" => esc_html__("Alignment", "dynamic-icon-widget"),
            "type" => Controls_Manager::CHOOSE,
            "options" => [
                "start" => [
                    "title" => esc_html__("Start", "dynamic-icon-widget"),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => esc_html__("Center", "dynamic-icon-widget"),
                    "icon" => "eicon-text-align-center",
                ],
                "end" => [
                    "title" => esc_html__("End", "dynamic-icon-widget"),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "classes" => "elementor-control-start-end",
            "selectors_dictionary" => [
                "left" => is_rtl() ? "end" : "start",
                "right" => is_rtl() ? "start" : "end",
            ],
            "default" => "center",
            "selectors" => [
                "{{WRAPPER}} .elementor-icon-wrapper" =>
                    "text-align: {{VALUE}};",
            ],
        ]);

        $this->start_controls_tabs("icon_colors");

        $this->start_controls_tab("icon_colors_normal", [
            "label" => esc_html__("Normal", "dynamic-icon-widget"),
        ]);

        $this->add_control("primary_color", [
            "label" => esc_html__("Primary Color", "dynamic-icon-widget"),
            "type" => Controls_Manager::COLOR,
            "default" => "",
            "selectors" => [
                "{{WRAPPER}}.elementor-view-stacked .elementor-icon" =>
                    "background-color: {{VALUE}};",
                "{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon" =>
                    "color: {{VALUE}}; border-color: {{VALUE}};",
                "{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon svg" =>
                    "fill: {{VALUE}};",
            ],
            "global" => [
                "default" => Global_Colors::COLOR_PRIMARY,
            ],
        ]);

        $this->add_control("secondary_color", [
            "label" => esc_html__("Secondary Color", "dynamic-icon-widget"),
            "type" => Controls_Manager::COLOR,
            "default" => "",
            "condition" => [
                "view!" => "default",
            ],
            "selectors" => [
                "{{WRAPPER}}.elementor-view-framed .elementor-icon" =>
                    "background-color: {{VALUE}};",
                "{{WRAPPER}}.elementor-view-stacked .elementor-icon" =>
                    "color: {{VALUE}};",
                "{{WRAPPER}}.elementor-view-stacked .elementor-icon svg" =>
                    "fill: {{VALUE}};",
            ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab("icon_colors_hover", [
            "label" => esc_html__("Hover", "dynamic-icon-widget"),
        ]);

        $this->add_control("hover_primary_color", [
            "label" => esc_html__("Primary Color", "dynamic-icon-widget"),
            "type" => Controls_Manager::COLOR,
            "default" => "",
            "selectors" => [
                "{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover" =>
                    "background-color: {{VALUE}};",
                "{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover" =>
                    "color: {{VALUE}}; border-color: {{VALUE}};",
                "{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover svg" =>
                    "fill: {{VALUE}};",
            ],
        ]);

        $this->add_control("hover_secondary_color", [
            "label" => esc_html__("Secondary Color", "dynamic-icon-widget"),
            "type" => Controls_Manager::COLOR,
            "default" => "",
            "condition" => [
                "view!" => "default",
            ],
            "selectors" => [
                "{{WRAPPER}}.elementor-view-framed .elementor-icon:hover" =>
                    "background-color: {{VALUE}};",
                "{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover" =>
                    "color: {{VALUE}};",
                "{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover svg" =>
                    "fill: {{VALUE}};",
            ],
        ]);

        $this->add_control("hover_animation", [
            "label" => esc_html__("Hover Animation", "dynamic-icon-widget"),
            "type" => Controls_Manager::HOVER_ANIMATION,
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control("size", [
            "label" => esc_html__("Size", "dynamic-icon-widget"),
            "type" => Controls_Manager::SLIDER,
            "size_units" => ["px", "%", "em", "rem", "vw", "custom"],
            "range" => [
                "px" => [
                    "min" => 6,
                    "max" => 300,
                ],
            ],
            "selectors" => [
                "{{WRAPPER}} .elementor-icon" => "font-size: {{SIZE}}{{UNIT}};",
                "{{WRAPPER}} .elementor-icon svg" =>
                    "height: {{SIZE}}{{UNIT}};",
            ],
            "separator" => "before",
        ]);

        $this->add_control("fit_to_size", [
            "label" => esc_html__("Fit to Size", "dynamic-icon-widget"),
            "type" => Controls_Manager::SWITCHER,
            "description" => esc_html__(
                'Avoid gaps around icons when width and height aren\'t equal',
                "dynamic-icon-widget"
            ),
            "label_off" => esc_html__("Off", "dynamic-icon-widget"),
            "label_on" => esc_html__("On", "dynamic-icon-widget"),
            "selectors" => [
                "{{WRAPPER}} .elementor-icon-wrapper svg" => "width: auto;",
            ],
        ]);

        $this->add_control("icon_padding", [
            "label" => esc_html__("Padding", "dynamic-icon-widget"),
            "type" => Controls_Manager::SLIDER,
            "size_units" => ["px", "%", "em", "rem", "custom"],
            "selectors" => [
                "{{WRAPPER}} .elementor-icon" => "padding: {{SIZE}}{{UNIT}};",
            ],
            "range" => [
                "px" => [
                    "max" => 50,
                ],
                "em" => [
                    "min" => 0,
                    "max" => 5,
                ],
                "rem" => [
                    "min" => 0,
                    "max" => 5,
                ],
            ],
            "condition" => [
                "view!" => "default",
            ],
        ]);

        $this->add_responsive_control("rotate", [
            "label" => esc_html__("Rotate", "dynamic-icon-widget"),
            "type" => Controls_Manager::SLIDER,
            "size_units" => ["deg", "grad", "rad", "turn", "custom"],
            "default" => [
                "unit" => "deg",
            ],
            "tablet_default" => [
                "unit" => "deg",
            ],
            "mobile_default" => [
                "unit" => "deg",
            ],
            "selectors" => [
                "{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg" =>
                    "transform: rotate({{SIZE}}{{UNIT}});",
            ],
        ]);

        $this->add_control("border_width", [
            "label" => esc_html__("Border Width", "dynamic-icon-widget"),
            "type" => Controls_Manager::DIMENSIONS,
            "size_units" => ["px", "%", "em", "rem", "vw", "custom"],
            "selectors" => [
                "{{WRAPPER}} .elementor-icon" =>
                    "border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};",
            ],
            "condition" => [
                "view" => "framed",
            ],
        ]);

        $this->add_responsive_control("border_radius", [
            "label" => esc_html__("Border Radius", "dynamic-icon-widget"),
            "type" => Controls_Manager::DIMENSIONS,
            "size_units" => ["px", "%", "em", "rem", "custom"],
            "selectors" => [
                "{{WRAPPER}} .elementor-icon" =>
                    "border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};",
            ],
            "condition" => [
                "view!" => "default",
            ],
        ]);

        $this->end_controls_section();
    }

    /**
     * Resolve the widget's media control value to a validated SVG attachment ID.
     *
     * Never touches a URL or filesystem path directly - resolution goes only
     * through core WordPress lookups (attachment post + its stored mime type),
     * so there is no path by which an arbitrary URL or stream wrapper can reach
     * a file read.
     *
     * @return int 0 if the settings hold no usable, validated SVG attachment.
     */
    private function get_validated_svg_attachment_id($media)
    {
        if (!is_array($media)) {
            return 0;
        }

        $attachment_id = absint($media["id"] ?? 0);

        if (!$attachment_id && !empty($media["url"])) {
            $attachment_id = attachment_url_to_postid($media["url"]);
        }

        if (
            !$attachment_id ||
            "attachment" !== get_post_type($attachment_id) ||
            "image/svg+xml" !== get_post_mime_type($attachment_id)
        ) {
            return 0;
        }

        return $attachment_id;
    }

    private function render_editor_placeholder()
    {
        ?>
        <div class="elementor-icon-wrapper dynamic-icon-widget__placeholder">
            <div class="elementor-icon" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border:1px dashed #a4afb7;border-radius:3px;color:#a4afb7;font-size:16px;">
                <i class="eicon-image-bold" aria-hidden="true"></i>
            </div>
        </div>
        <?php
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $media = $settings["icon_svg"] ?? [];

        if (!is_array($media) || (empty($media["id"]) && empty($media["url"]))) {
            return; // Nothing selected yet - blank widget, no placeholder needed.
        }

        $attachment_id = $this->get_validated_svg_attachment_id($media);

        if (!$attachment_id) {
            if (Plugin::$instance->editor->is_edit_mode()) {
                $this->render_editor_placeholder();
            }
            return;
        }

        $this->add_render_attribute(
            "wrapper",
            "class",
            "elementor-icon-wrapper"
        );

        $this->add_render_attribute("icon-wrapper", "class", "elementor-icon");

        if (!empty($settings["hover_animation"])) {
            $this->add_render_attribute(
                "icon-wrapper",
                "class",
                "elementor-animation-" . $settings["hover_animation"]
            );
        }

        $icon_tag = "div";

        if (!empty($settings["link"]["url"])) {
            $this->add_link_attributes("icon-wrapper", $settings["link"]);

            $icon_tag = "a";

            // Manual aria_label always wins; otherwise fall back to whatever
            // WordPress already has stored as the attachment's title (which
            // may itself be filename-derived - we don't reprocess it here).
            $accessible_label = !empty($settings["aria_label"])
                ? $settings["aria_label"]
                : get_the_title($attachment_id);

            if (!empty($accessible_label)) {
                $this->add_render_attribute(
                    "icon-wrapper",
                    "aria-label",
                    $accessible_label
                );
            }
        }
        ?>
        <div <?php $this->print_render_attribute_string("wrapper"); ?>>
            <<?php echo $icon_tag; ?> <?php $this->print_render_attribute_string(
     "icon-wrapper"
 ); ?>>
                <span class="dynamic-icon-widget__svg" aria-hidden="true">
                <?php
                // Icons_Manager::render_uploaded_svg_icon() ignores the attributes
                // argument for uploaded SVG icons, so aria-hidden is applied to this
                // wrapper rather than passed to render_icon().
                Icons_Manager::render_icon([
                    "library" => "svg",
                    "value" => ["id" => $attachment_id],
                ]);
                ?>
                </span>
            </<?php echo $icon_tag; ?>>
        </div>
        <?php
    }

    protected function content_template()
    {
        ?>
        <#
        var media = settings.icon_svg || {};

        if ( ! media.id && ! media.url ) {
            return;
        }

        var icon = { library: 'svg', value: { id: media.id, url: media.url } },
            iconHTML = elementor.helpers.renderIcon( view, icon, {}, 'div', 'object' );

        if ( ! iconHTML || ! iconHTML.value ) { #>
            <div class="elementor-icon-wrapper dynamic-icon-widget__placeholder">
                <div class="elementor-icon" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border:1px dashed #a4afb7;border-radius:3px;color:#a4afb7;font-size:16px;">
                    <i class="eicon-image-bold" aria-hidden="true"></i>
                </div>
            </div>
        <# } else {
            var iconTag = 'div';

            if ( settings.link && settings.link.url ) {
                view.addRenderAttribute( 'link_url', 'href', elementor.helpers.sanitizeUrl( settings.link.url ) );
                iconTag = 'a';

                if ( settings.aria_label ) {
                    view.addRenderAttribute( 'link_url', 'aria-label', settings.aria_label );
                }
            }

            view.addRenderAttribute( 'icon', 'class', 'elementor-icon' );

            if ( settings.hover_animation ) {
                view.addRenderAttribute( 'icon', 'class', 'elementor-animation-' + settings.hover_animation );
            }
            #>
            <div class="elementor-icon-wrapper">
                <{{{ iconTag }}} {{{ view.getRenderAttributeString( 'icon' ) }}} {{{ view.getRenderAttributeString( 'link_url' ) }}}>
                    <span class="dynamic-icon-widget__svg" aria-hidden="true">{{{ iconHTML.value }}}</span>
                </{{{ iconTag }}}>
            </div>
        <# } #>
        <?php
    }
}
