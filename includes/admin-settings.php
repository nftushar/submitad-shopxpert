<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Initialize settings
function shopxpert_initialize_settings() {
    register_setting( 'shopxpert_options_group', 'shopxpert_thank_you_message', 'sanitize_textarea_field' );
    register_setting( 'shopxpert_options_group', 'shopxpert_thank_you_color', 'sanitize_hex_color' );
    register_setting( 'shopxpert_options_group', 'shopxpert_thank_you_font_size', 'sanitize_text_field' );
    register_setting( 'shopxpert_options_group', 'shopxpert_thank_you_text_align', 'sanitize_text_field' );

    add_settings_section(
        'shopxpert_main_section',
        esc_html__( 'Thank You Message Settings', 'shopxpert' ),
        'shopxpert_section_text',
        'shopxpert'
    );

    add_settings_field(
        'shopxpert_thank_you_message',
        esc_html__( 'Thank You Message', 'shopxpert' ),
        'shopxpert_thank_you_message_input',
        'shopxpert',
        'shopxpert_main_section'
    );

    add_settings_field(
        'shopxpert_thank_you_color',
        esc_html__( 'Message Color', 'shopxpert' ),
        'shopxpert_thank_you_color_input',
        'shopxpert',
        'shopxpert_main_section'
    );

    add_settings_field(
        'shopxpert_thank_you_font_size',
        esc_html__( 'Message Font Size', 'shopxpert' ),
        'shopxpert_thank_you_font_size_input',
        'shopxpert',
        'shopxpert_main_section'
    );

    add_settings_field(
        'shopxpert_thank_you_text_align',
        esc_html__( 'Message Text Alignment', 'shopxpert' ),
        'shopxpert_thank_you_text_align_input',
        'shopxpert',
        'shopxpert_main_section'
    );
}
add_action( 'admin_init', 'shopxpert_initialize_settings' );

// Section text
function shopxpert_section_text() {
    echo '<p>' . esc_html__( 'Customize the "Thank You" message on the WooCommerce checkout page.', 'shopxpert' ) . '</p>';
}

// Thank you message input
function shopxpert_thank_you_message_input() {
    $message = get_option( 'shopxpert_thank_you_message', '' );
    ?>
    <textarea name="shopxpert_thank_you_message" rows="5" cols="50" class="large-text"><?php echo esc_textarea( $message ); ?></textarea>
    <p class="description"><?php esc_html_e( 'Enter the custom message or HTML snippet for the "Thank You" page.', 'shopxpert' ); ?></p>
    <?php
}

// Color picker input
function shopxpert_thank_you_color_input() {
    $color = get_option( 'shopxpert_thank_you_color', '#000000' );
    ?>
    <input type="text" name="shopxpert_thank_you_color" value="<?php echo esc_attr( $color ); ?>" class="color-picker" data-default-color="#000000" />
    <p class="description"><?php esc_html_e( 'Select the text color for the "Thank You" message.', 'shopxpert' ); ?></p>
    <?php
}

// Font size input
function shopxpert_thank_you_font_size_input() {
    $font_size = get_option( 'shopxpert_thank_you_font_size', '16px' );
    ?>
    <input type="text" name="shopxpert_thank_you_font_size" value="<?php echo esc_attr( $font_size ); ?>" class="regular-text" />
    <p class="description"><?php esc_html_e( 'Enter the font size for the "Thank You" message (e.g., 16px).', 'shopxpert' ); ?></p>
    <?php
}

// Text alignment input
function shopxpert_thank_you_text_align_input() {
    $text_align = get_option( 'shopxpert_thank_you_text_align', 'center' );
    ?>
    <select name="shopxpert_thank_you_text_align">
        <option value="left" <?php selected( $text_align, 'left' ); ?>><?php esc_html_e( 'Left', 'shopxpert' ); ?></option>
        <option value="center" <?php selected( $text_align, 'center' ); ?>><?php esc_html_e( 'Center', 'shopxpert' ); ?></option>
        <option value="right" <?php selected( $text_align, 'right' ); ?>><?php esc_html_e( 'Right', 'shopxpert' ); ?></option>
    </select>
    <p class="description"><?php esc_html_e( 'Select the text alignment for the "Thank You" message.', 'shopxpert' ); ?></p>
    <?php
}

// Add a custom admin menu item
function shopxpert_admin_menu() {
    add_submenu_page(
        'woocommerce',
        esc_html__( 'Thank You Message Customizer', 'shopxpert' ),
        esc_html__( 'Thank You Message Customizer', 'shopxpert' ),
        'manage_options',
        'shopxpert',
        'shopxpert_settings_page'
    );
}
add_action( 'admin_menu', 'shopxpert_admin_menu' );

// Settings page content
function shopxpert_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Thank You Message Customizer', 'shopxpert' ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'shopxpert_options_group' );
            do_settings_sections( 'shopxpert' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
