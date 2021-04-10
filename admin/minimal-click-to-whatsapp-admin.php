<?php

if(!defined('ABSPATH')) die();

add_action( 'admin_menu', 'mctw_add_submenu');
function mctw_add_submenu() {
    add_options_page( 
        __( 'Configure minimal click to Whatsapp', 'minimal-click-to-whatsapp' ),
        __( 'Minimal click to Whatsapp', 'minimal-click-to-whatsapp' ),
        'manage_options',
        'mctw_minimal_click_to_whatsapp',
        'mctw_minimal_click_to_whatsapp_settings'
    );
}

//Settings Form
function mctw_minimal_click_to_whatsapp_settings() {
    ?>

    <div class="wrap">
        <h2><?php esc_html_e( 'Minimal click to Whatsapp', 'minimal-click-to-whatsapp' ); ?></h2>
        <form action="options.php" method="POST">
            <?php
            settings_fields( 'mctw_settings_groups' );
            do_settings_sections( 'mctw_minimal_click_to_whatsapp' );
            submit_button();
            ?>
        </form>
    </div>

    <?php
}



add_action( 'admin_init', 'mctw_minimal_click_to_whatsapp_init' );
function mctw_minimal_click_to_whatsapp_init() {
    //Register the setting ARRAY
    register_setting( 'mctw_settings_groups', 'mctw_settings', 'mctw_sanitize_settings' );

    //Create New Section
    add_settings_section( 'mctw_section', esc_html__( 'Settings', 'minimal-click-to-whatsapp' ), '', 'mctw_minimal_click_to_whatsapp' );

    //Add Fields
    add_settings_field( 'mctw_phone_number', esc_html__( 'Phone Number', 'minimal-click-to-whatsapp' ), 'mctw_phone_number_callback', 'mctw_minimal_click_to_whatsapp', 'mctw_section' );
    add_settings_field( 'mctw_welcome_text', esc_html__( 'Welcome text', 'minimal-click-to-whatsapp' ), 'mctw_welcome_text_callback', 'mctw_minimal_click_to_whatsapp', 'mctw_section' );
    add_settings_field( 'mctw_position_button', esc_html__( 'Position Button', 'minimal-click-to-whatsapp' ), 'mctw_position_button_callback', 'mctw_minimal_click_to_whatsapp', 'mctw_section' );
    add_settings_field( 'mctw_icon_size', esc_html__( 'Whatsapp Icon Size', 'minimal-click-to-whatsapp' ), 'mctw_icon_size_callback', 'mctw_minimal_click_to_whatsapp', 'mctw_section' );
}


/**
 * SANITIZE AND VALIDATE
 */
function mctw_sanitize_settings( $input ) {
    $input['phone_number'] = absint( $input['phone_number'] );
    $input['icon_size'] = absint( $input['icon_size'] );
    $welcome_text = preg_replace( "/(\r|\n)/", " ", $input['welcome_text'] );
    $input['welcome_text'] = sanitize_textarea_field( $welcome_text );

    if( $input['icon_size'] === 0 ) {
        $input['icon_size'] = 42; 
    }

    if( $input['phone_number'] === 0 ) {
        $input['phone_number'] = ''; 
    }

    return $input;
}


/**
 * SECTION DESCRIPTION
 */


/**
 * INPUTS FORM
 */
function mctw_phone_number_callback() {
    $options = get_option('mctw_settings');
    if( isset( $options['phone_number'] ) ) {
        $value = $options['phone_number'];
    } elseif( $options['phone_number'] === 0 ) {
        $value = '';
    }
    ?>
    <input type="number" name="mctw_settings[phone_number]" value="<?php esc_attr_e( $value ); ?>">
    <p class="description"><?php esc_html_e( 'Phone number to Whatsapp', 'minimal-click-to-whatsapp' ); ?></p>
    <?php
}

function mctw_welcome_text_callback() {
    $options = get_option('mctw_settings');
    if( isset( $options['welcome_text'] ) ) {
        $value = $options['welcome_text'];
    }
    ?>
    <textarea name="mctw_settings[welcome_text]" id="mctw-welcome-text" class="regular-text" rows="3"><?php echo esc_textarea( $value ); ?></textarea>
    <p class="description"><?php _e( 'Enter the welcome text to start Whatsapp conversation', 'minimal-click-to-whatsapp' ); ?></p>
    <?php
}

function mctw_position_button_callback() {
    $options = get_option('mctw_settings');
    ?>
    <label>
        <input type="radio" name="mctw_settings[position_button]" value="right" <?php checked( $options['position_button'] === 'right' ); ?> >
        <span><?php esc_html_e( 'Right', 'minimal-click-to-whatsapp' ); ?></span>
    </label>
    <label>
        <input type="radio" name="mctw_settings[position_button]" value="left" <?php checked( $options['position_button'] === 'left' ); ?> >
        <span><?php esc_html_e( 'Left', 'minimal-click-to-whatsapp' ); ?></span>
    </label>
    <?php
}

function mctw_icon_size_callback() {
    $options = get_option('mctw_settings');
    if( isset( $options['icon_size'] ) ) {
        $value = $options['icon_size'];
    }else {
        $value = 42;
    }
    ?>
    <input type="number" name="mctw_settings[icon_size]" value="<?php esc_attr_e( $value ); ?>">
    <p class="description"><?php esc_html_e( 'Whatsapp icon size in px (Default: 42px)', 'minimal-click-to-whatsapp' ); ?></p>
    <?php
}