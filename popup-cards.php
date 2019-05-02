<?php
/*
Plugin Name: Popup Cards WordPress plugin
Plugin URI: https://github.com/maximmas/popup-cards
Description: Popup Cards with randomized subscription form
Version: 1.0
Author: Maxim Maslov
Author URI: maximmaslov.ru
Text domain: cj
Domain Path: /languages
*/

require_once ( plugin_dir_path( __FILE__ ) . '/admin/settings-page.php' );
require_once ( plugin_dir_path( __FILE__ ) . '/classes/class-cj-database.php' );

/**
* Scripts and styles
*
*/
add_action( 'wp_enqueue_scripts', 'cj_scripts' );
function cj_scripts() {

    wp_enqueue_script( 'cj_magnific', plugin_dir_url( __FILE__ ) . 'assets/libs/magnific-popup/magnific-popup.min.js', array( 'jquery'), null, 'footer' );
    wp_enqueue_script( 'cj_cookie', plugin_dir_url( __FILE__ ) . 'assets/libs/cookie.js', array(), null, 'footer' );
    wp_enqueue_script( 'cj_script', plugin_dir_url( __FILE__ ) . 'assets/js/common.js', array( 'jquery', 'cj_magnific', 'cj_cookie' ), null, 'footer' );

    wp_localize_script( 'jquery', 'CJ_AjaxHandler', array( 'cj_ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

    $style_libs = array( 'cj_magnific_style');
    wp_enqueue_style( 'cj_magnific_style', plugin_dir_url( __FILE__ ) . 'assets/libs/magnific-popup/magnific-popup.min.css' );
    wp_enqueue_style( 'cj_style', plugin_dir_url( __FILE__ ) . 'assets/css/main.css', $style_libs );
    wp_style_add_data( 'cj_style', 'rtl', 'replace' );
    
    wp_enqueue_style( 'cj_google_fonts', 'https://fonts.googleapis.com/css?family=Roboto', false );

};

add_action( 'admin_enqueue_scripts', 'cj_admin_scripts' );
function cj_admin_scripts()
{
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'cj_admin_script', plugin_dir_url( __FILE__ ) . 'admin/js/admin-scripts.js', array('wp-color-picker'), false, true );
    wp_enqueue_style( 'cj_admin_style', plugin_dir_url( __FILE__ ) . 'admin/css/admin_style.css' ) ;
    wp_style_add_data( 'cj_admin_style', 'rtl', 'replace' );
};

add_action( 'wp_head', 'cj_popup_style' );
function cj_popup_style(){
    $options    = get_option( 'cj_options' );
    $color_bg   = ( !empty( $options['color_bg'] ) ) ? $options['color_bg'] : '#FFF';
    $color_text = ( !empty( $options['color_text'] ) ) ? $options['color_text'] : '#FFF';
    
    $style = "<style>";
    $style .= "#cj_modal{";
    $style .= "background-color : {$color_bg};";
    $style .= "color: {$color_text}; }";
    $style .= "#cj_modal h3, #cj_modal .card_text{";
    $style .= "color: {$color_text}; }";
    $style .= "</style>";

    echo $style;
    
}

/**
 * Creating table for users data
 *
 */
register_activation_hook(__FILE__, 'cj_plugin_activation');
function cj_plugin_activation() {
    CJ_Database::table_create();
}


/**
 * Ajax handler
 *
 */
add_action( 'wp_ajax_handler', 'cj_form_handler' );
add_action( 'wp_ajax_nopriv_handler', 'cj_form_handler' );
function cj_form_handler(){
    
    $data = array(
        'name'  => isset( $_POST['name'] ) ? $_POST['name'] : 'no name',
        'email' => isset( $_POST['email'] ) ? $_POST['email'] : 'no email'
    );
    
    $is_saved = CJ_Database::save_user( $data );
    $result = ( $is_saved ) ? 1 : 0;
    echo( $result );
    wp_die();

};


  /***
 * Shortcode registration
 * [popup_cards]
 *
 */
add_shortcode('popup_cards', 'cj_popup_register');
function cj_popup_register( $atts ){
    ob_start();
    include ( plugin_dir_path( __FILE__ ) . 'includes/modal_template.php' );
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
};
