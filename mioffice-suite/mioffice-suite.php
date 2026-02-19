<?php
/**
 * Plugin Name:       MiOffice Suite
 * Plugin URI:        https://mioffice.ai
 * Description:       Embed MiOffice browser-based PDF, image, video, and AI applications on any WordPress page or post using shortcodes. Files never leave the visitor's browser.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            JSVV SOLS LLC
 * Author URI:        https://jsvvsols.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mioffice-suite
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'MIOFFICE_SUITE_VERSION', '1.0.0' );
define( 'MIOFFICE_SUITE_BASE_URL', 'https://mioffice.ai' );

/**
 * Available tool categories and their slugs.
 */
function mioffice_get_tools() {
    return array(
        // PDF Suite
        'merge-pdf'           => array( 'name' => 'Merge PDF',           'category' => 'pdf' ),
        'split-pdf'           => array( 'name' => 'Split PDF',           'category' => 'pdf' ),
        'compress-pdf'        => array( 'name' => 'Compress PDF',        'category' => 'pdf' ),
        'pdf-to-word'         => array( 'name' => 'PDF to Word',         'category' => 'pdf' ),
        'word-to-pdf'         => array( 'name' => 'Word to PDF',         'category' => 'pdf' ),
        'excel-to-pdf'        => array( 'name' => 'Excel to PDF',        'category' => 'pdf' ),
        'pdf-to-jpg'          => array( 'name' => 'PDF to JPG',          'category' => 'pdf' ),
        'jpg-to-pdf'          => array( 'name' => 'JPG to PDF',          'category' => 'pdf' ),
        'rotate-pdf'          => array( 'name' => 'Rotate PDF',          'category' => 'pdf' ),
        'protect-pdf'         => array( 'name' => 'Protect PDF',         'category' => 'pdf' ),
        'unlock-pdf'          => array( 'name' => 'Unlock PDF',          'category' => 'pdf' ),
        'pdf-editor'          => array( 'name' => 'PDF Editor',          'category' => 'pdf' ),

        // Image Suite
        'compress-image'      => array( 'name' => 'Compress Image',      'category' => 'image' ),
        'resize-image'        => array( 'name' => 'Resize Image',        'category' => 'image' ),
        'crop-image'          => array( 'name' => 'Crop Image',          'category' => 'image' ),
        'convert-image'       => array( 'name' => 'Convert Image',       'category' => 'image' ),
        'rotate-image'        => array( 'name' => 'Rotate Image',        'category' => 'image' ),
        'heic-to-jpg'         => array( 'name' => 'HEIC to JPG',         'category' => 'image' ),
        'webp-to-jpg'         => array( 'name' => 'WebP to JPG',         'category' => 'image' ),
        'png-to-jpg'          => array( 'name' => 'PNG to JPG',          'category' => 'image' ),

        // Video Suite
        'compress-video'      => array( 'name' => 'Compress Video',      'category' => 'video' ),
        'convert-video'       => array( 'name' => 'Convert Video',       'category' => 'video' ),
        'video-to-gif'        => array( 'name' => 'Video to GIF',        'category' => 'video' ),
        'video-to-mp3'        => array( 'name' => 'Video to MP3',        'category' => 'video' ),
        'trim-video'          => array( 'name' => 'Trim Video',          'category' => 'video' ),

        // AI Suite
        'remove-background'   => array( 'name' => 'Remove Background',   'category' => 'ai' ),
        'remove-objects'      => array( 'name' => 'Remove Objects',      'category' => 'ai' ),

        // Scanner Suite
        'document-scanner'    => array( 'name' => 'Document Scanner',    'category' => 'scanner' ),
        'receipt-scanner'     => array( 'name' => 'Receipt Scanner',     'category' => 'scanner' ),
        'qr-scanner'          => array( 'name' => 'QR Scanner',          'category' => 'scanner' ),
    );
}

/**
 * Register the [mioffice] shortcode.
 *
 * Usage:
 *   [mioffice tool="merge-pdf"]
 *   [mioffice tool="compress-image" width="100%" height="700"]
 *   [mioffice category="pdf"]   — shows all PDF applications as a grid of links
 */
function mioffice_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'tool'     => '',
            'category' => '',
            'width'    => '100%',
            'height'   => '800',
            'mode'     => 'card',  // 'card' (default, always works) or 'iframe' (requires X-Frame-Options config)
        ),
        $atts,
        'mioffice'
    );

    $tools = mioffice_get_tools();

    // Single tool embed
    if ( ! empty( $atts['tool'] ) ) {
        $slug = sanitize_text_field( $atts['tool'] );

        if ( ! isset( $tools[ $slug ] ) ) {
            return '<p style="color:#c00;font-weight:600;">MiOffice: Unknown application "' . esc_html( $slug ) . '". Check available slugs in the plugin settings.</p>';
        }

        $tool     = $tools[ $slug ];
        $url      = esc_url( MIOFFICE_SUITE_BASE_URL . '/tools/' . $tool['category'] . '/' . $slug );
        $name     = esc_html( $tool['name'] );

        // iframe mode (opt-in)
        if ( $atts['mode'] === 'iframe' ) {
            $width  = esc_attr( $atts['width'] );
            $height = intval( $atts['height'] );

            return sprintf(
                '<div class="mioffice-embed" style="width:%s;margin:1em auto;">
                    <iframe
                        src="%s"
                        width="100%%"
                        height="%dpx"
                        style="border:1px solid #e5e7eb;border-radius:12px;"
                        loading="lazy"
                        allow="camera;clipboard-write"
                        title="%s — MiOffice"
                    ></iframe>
                    <p style="text-align:center;margin-top:8px;font-size:13px;color:#6b7280;">
                        Powered by <a href="%s" target="_blank" rel="noopener noreferrer" style="color:#0B65C2;">MiOffice</a> — files never leave your browser
                    </p>
                </div>',
                $width,
                $url,
                $height,
                $name,
                esc_url( MIOFFICE_SUITE_BASE_URL )
            );
        }

        // Card mode (default — always works, opens in new tab)
        return sprintf(
            '<div class="mioffice-card" style="max-width:400px;margin:1em auto;">
                <a href="%s" target="_blank" rel="noopener noreferrer" style="display:block;padding:24px;border:2px solid #e5e7eb;border-radius:12px;text-decoration:none;color:#111827;text-align:center;transition:border-color 0.2s,box-shadow 0.2s;" onmouseover="this.style.borderColor=\'#0B65C2\';this.style.boxShadow=\'0 4px 12px rgba(11,101,194,0.15)\'" onmouseout="this.style.borderColor=\'#e5e7eb\';this.style.boxShadow=\'none\'">
                    <strong style="display:block;font-size:18px;margin-bottom:6px;color:#0B65C2;">%s</strong>
                    <span style="display:block;font-size:14px;color:#6b7280;margin-bottom:12px;">Process files in your browser — nothing gets uploaded</span>
                    <span style="display:inline-block;padding:8px 20px;background:#0B65C2;color:#fff;border-radius:8px;font-size:14px;font-weight:600;">Open Application &rarr;</span>
                </a>
                <p style="text-align:center;margin-top:8px;font-size:12px;color:#9ca3af;">
                    Powered by <a href="%s" target="_blank" rel="noopener noreferrer" style="color:#0B65C2;">MiOffice</a>
                </p>
            </div>',
            $url,
            $name,
            esc_url( MIOFFICE_SUITE_BASE_URL )
        );
    }

    // Category grid — list all tools in a category as linked cards
    if ( ! empty( $atts['category'] ) ) {
        $category = sanitize_text_field( $atts['category'] );
        $matched  = array();

        foreach ( $tools as $slug => $tool ) {
            if ( $tool['category'] === $category ) {
                $matched[ $slug ] = $tool;
            }
        }

        if ( empty( $matched ) ) {
            return '<p style="color:#c00;font-weight:600;">MiOffice: No applications found for category "' . esc_html( $category ) . '".</p>';
        }

        $category_labels = array(
            'pdf'     => 'PDF Suite',
            'image'   => 'Image Suite',
            'video'   => 'Video Suite',
            'ai'      => 'AI Suite',
            'scanner' => 'Scanner Suite',
        );

        $label = isset( $category_labels[ $category ] ) ? $category_labels[ $category ] : ucfirst( $category );

        $html = '<div class="mioffice-grid" style="margin:1em 0;">';
        $html .= '<h3 style="margin-bottom:12px;font-size:20px;font-weight:700;color:#111827;">MiOffice ' . esc_html( $label ) . '</h3>';
        $html .= '<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;">';

        foreach ( $matched as $slug => $tool ) {
            $url  = esc_url( MIOFFICE_SUITE_BASE_URL . '/tools/' . $tool['category'] . '/' . $slug );
            $name = esc_html( $tool['name'] );

            $html .= sprintf(
                '<a href="%s" target="_blank" rel="noopener noreferrer" style="display:block;padding:16px;border:1px solid #e5e7eb;border-radius:10px;text-decoration:none;color:#111827;transition:border-color 0.2s;" onmouseover="this.style.borderColor=\'#0B65C2\'" onmouseout="this.style.borderColor=\'#e5e7eb\'">
                    <strong style="display:block;font-size:15px;margin-bottom:4px;">%s</strong>
                    <span style="font-size:12px;color:#6b7280;">Open in MiOffice &rarr;</span>
                </a>',
                $url,
                $name
            );
        }

        $html .= '</div>';
        $html .= '<p style="text-align:center;margin-top:10px;font-size:13px;color:#6b7280;">Powered by <a href="' . esc_url( MIOFFICE_SUITE_BASE_URL ) . '" target="_blank" rel="noopener noreferrer" style="color:#0B65C2;">MiOffice</a> — files never leave your browser</p>';
        $html .= '</div>';

        return $html;
    }

    return '<p style="color:#c00;font-weight:600;">MiOffice: Please specify a <code>tool</code> or <code>category</code> attribute. Example: <code>[mioffice tool="merge-pdf"]</code></p>';
}
add_shortcode( 'mioffice', 'mioffice_shortcode' );

/**
 * Add settings page under WordPress admin menu.
 */
function mioffice_admin_menu() {
    add_options_page(
        'MiOffice Suite',
        'MiOffice Suite',
        'manage_options',
        'mioffice-suite',
        'mioffice_settings_page'
    );
}
add_action( 'admin_menu', 'mioffice_admin_menu' );

/**
 * Render the settings/info page.
 */
function mioffice_settings_page() {
    $tools = mioffice_get_tools();
    ?>
    <div class="wrap">
        <h1>MiOffice Suite</h1>
        <p>Embed MiOffice browser-based applications on any page or post using shortcodes.</p>

        <h2>Usage</h2>
        <p>Add a shortcode to any page or post:</p>
        <table class="widefat" style="max-width:700px;">
            <thead>
                <tr>
                    <th>Shortcode</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>[mioffice tool="merge-pdf"]</code></td>
                    <td>Embed a single application (iframe)</td>
                </tr>
                <tr>
                    <td><code>[mioffice tool="compress-image" height="600"]</code></td>
                    <td>Custom height (default: 800px)</td>
                </tr>
                <tr>
                    <td><code>[mioffice category="pdf"]</code></td>
                    <td>Show all PDF applications as a grid</td>
                </tr>
                <tr>
                    <td><code>[mioffice category="image"]</code></td>
                    <td>Show all image applications as a grid</td>
                </tr>
            </tbody>
        </table>

        <h2 style="margin-top:24px;">Available Applications</h2>
        <table class="widefat striped" style="max-width:700px;">
            <thead>
                <tr>
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $tools as $slug => $tool ) : ?>
                <tr>
                    <td><code><?php echo esc_html( $slug ); ?></code></td>
                    <td><?php echo esc_html( $tool['name'] ); ?></td>
                    <td><?php echo esc_html( $tool['category'] ); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 style="margin-top:24px;">Privacy</h2>
        <p>All file processing happens in the visitor's browser via WebAssembly. No files are uploaded to any server. <a href="https://mioffice.ai/privacy" target="_blank" rel="noopener noreferrer">Privacy Policy</a></p>
    </div>
    <?php
}
