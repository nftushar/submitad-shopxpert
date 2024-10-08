<?php
/**
 * Plugin Name: ShopXpert
 * Plugin URI: https://github.com/nftushar/shopxpert
 * Description: Customize the "Thank You" message on the WooCommerce checkout page with options for color, size, and position.
 * Version: 1.0.0
 * Author: NF Tushar
 * Author URI: https://github.com/nftushar
 * License: GPL-2.0-or-later
 * Text Domain: shopxpert
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


// Define plugin constants.
define( 'SHOPXPERT_VERSION', '1.0.0' );
define( 'SHOPXPERT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SHOPXPERT_PLUGIN_URL', plugins_url( '', __FILE__ ) );

// Include necessary files only in the admin area.
if ( is_admin() ) {
    require_once SHOPXPERT_PLUGIN_DIR . 'includes/admin-settings.php';
}


 


// Register activation hook.
function shopxpert_plugin_activate() {
    // Ensure user has proper capability.
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }

    // Add default options with proper sanitization.
    add_option( 'shopxpert_thank_you_message', sanitize_text_field( __( 'Thank you for your purchase!', 'shopxpert' ) ) );
    add_option( 'shopxpert_thank_you_color', '#000000' );
    add_option( 'shopxpert_thank_you_font_size', '16px' );
    add_option( 'shopxpert_thank_you_text_align', 'center' );
}
register_activation_hook( __FILE__, 'shopxpert_plugin_activate' );

// Register deactivation hook.
function shopxpert_deactivate() {
    // Ensure user has proper capability.
    if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }

    // Remove options.
    delete_option( 'shopxpert_thank_you_message' );
    delete_option( 'shopxpert_thank_you_color' );
    delete_option( 'shopxpert_thank_you_font_size' );
    delete_option( 'shopxpert_thank_you_text_align' );
}
register_deactivation_hook( __FILE__, 'shopxpert_deactivate' );

// Enqueue styles and scripts.
function shopxpert_enqueue_scripts( $hook_suffix ) {
    // Only enqueue scripts on the admin settings page.
    $current_screen = get_current_screen();
    if ( $current_screen && 'woocommerce_page_shopxpert' === $current_screen->id ) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'shopxpert-script', SHOPXPERT_PLUGIN_URL . '/js/scripts.js', array( 'jquery', 'wp-color-picker' ), SHOPXPERT_VERSION, true );
    }
}
add_action( 'admin_enqueue_scripts', 'shopxpert_enqueue_scripts' );

// Add custom "Thank You" message to WooCommerce checkout.
function shopxpert_add_thank_you_message() {
    $message = get_option( 'shopxpert_thank_you_message', __( 'Thank you for your purchase!', 'shopxpert' ) );
    $color = sanitize_hex_color( get_option( 'shopxpert_thank_you_color', '#000000' ) );
    $font_size = sanitize_text_field( get_option( 'shopxpert_thank_you_font_size', '16px' ) );
    $text_align = sanitize_text_field( get_option( 'shopxpert_thank_you_text_align', 'center' ) );

    if ( ! empty( $message ) ) {
        echo '<div class="shopxpert-thank-you-message" style="color: ' . esc_attr( $color ) . '; font-size: ' . esc_attr( $font_size ) . '; text-align: ' . esc_attr( $text_align ) . ';">' . wp_kses_post( $message ) . '</div>';
    }
}
add_action( 'woocommerce_thankyou', 'shopxpert_add_thank_you_message', 20 );

