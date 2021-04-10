<?php

if(!defined('ABSPATH')) die();


function mctw_whatsapp_url( $phone, $text) {
    $cadenaConvert = str_replace(" ", "%20", $text);
    return "https://api.whatsapp.com/send?phone=34".$phone."&text=". $cadenaConvert;
}

function mctw_position_button($position) {
    if($position === 'left') {
        echo 'left: 25px;';
    } else {
        echo 'right: 25px;';
    }
}

function mctw_position_button_keyframes($position) {
    if($position === 'left') {
        echo '
            @keyframes whatsapp-animation {
                0% {
                    transform: translateX(-1000px);				
                }

                50% {
                    transform: translateX(-500px);				
                }

                100% {
                    transform: translateY(0);
                }
            }
        ';
    } else {
        echo '
            @keyframes whatsapp-animation {
                0% {
                    transform: translateX(1000px);				
                }

                50% {
                    transform: translateX(500px);				
                }

                100% {
                    transform: translateY(0);
                }
            }
        ';
    }
}

function mctw_icon_size($size) {
    echo '
        width: '.$size.'px;
        height: '.$size.'px;
    ';
}

add_action( 'wp_footer', function() {

    $options = get_option( 'mctw_settings' );
    if( ! $options['phone_number'] ) {
        return;
    }
    ?>

    <style>
        .ea-whatsapp {
            position: fixed;
            bottom: 10px;
            <?php mctw_position_button( $options['position_button'] ); ?>
            <?php mctw_icon_size( $options['icon_size'] ); ?>
            z-index: 9999;
            opacity: 1;
            animation: whatsapp-animation 3s ease;
		}
		
		<?php mctw_position_button_keyframes( $options['position_button'] ); ?>
    </style>

    <a href="<?php echo esc_url( mctw_whatsapp_url($options['phone_number'],$options['welcome_text']) ) ?>" target="_blank" rel="noopener noreferrer">
        <img class="ea-whatsapp" src="<?php echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) ) . 'images/whatsapp-icon.png'; ?>" alt="whatsapp-icon">
    </a>

    <?php
});