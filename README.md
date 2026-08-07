# Dynamic Icon Widget for Elementor

This plugin adds a custom "Dynamic Icon" widget to Elementor, which allows you to dynamically select an SVG icon. It retains most the functionality of the default Elementor Icon widget.

## Requirements

- Elementor 3.5.0 or later.
- The selected icon must be a **valid SVG attachment in the WordPress media library** (its stored mime type must be `image/svg+xml`). Anything else - a non-SVG image, an external URL, an unresolvable dynamic value - is treated as invalid and nothing is rendered on the frontend.
- WordPress blocks SVG uploads by default. Elementor's own "Enable Unfiltered File Uploads" setting (Elementor → Settings → Advanced) is one supported way to safely upload SVGs, since it sanitizes them at upload time - but it isn't the only route; any SVG that reaches the media library through a properly sanitized workflow will work.

## Features

- Select an SVG file dynamically, including via Elementor dynamic tags (e.g. ACF image fields, featured image).
- Customize the view (Default, Stacked, Framed).
- Add a link to the icon, with an optional accessible label for icon-only links.
- Style the icon with color, size, padding, border, rotation, and hover effects.

## Installation

1. Download the repo root files as a zip.
2. Install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.

## Usage

1. In Elementor, search for the "Dynamic Icon" widget.
2. Drag and drop the widget to your desired location on the page.
3. Under the "Content" tab, upload or select your SVG file.
4. Customize the view, shape, link, and accessible label settings as needed.
5. Under the "Style" tab, adjust the icon's alignment, colors, size, padding, border, rotation, and hover effects.
