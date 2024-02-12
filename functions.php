<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'hello-elementor','hello-elementor','hello-elementor-theme-style','hello-elementor-header-footer' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

// Check if CPT UI is active
if ( ! is_plugin_active( 'custom-post-type-ui/custom-post-type-ui.php' ) ) {
    // The CPT UI plugin is not active, add an admin notice
    add_action( 'admin_notices', 'cptui_plugin_not_active_notice' );
}

// Check if ACF is active
if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
    // The ACF plugin is not active, add an admin notice
    add_action( 'admin_notices', 'acf_plugin_not_active_notice' );
}

// Admin notice for CPT UI plugin
function cptui_plugin_not_active_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'The CPT UI plugin is not active. Please activate it to use all features of this theme.', 'text-domain' ); ?></p>
    </div>
    <?php
}

// Admin notice for ACF plugin
function acf_plugin_not_active_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'The ACF plugin is not active. Please activate it to use all features of this theme.', 'text-domain' ); ?></p>
    </div>
    <?php
}

if ( ! function_exists('listPortfolio') ) {
    /**
     * List the cpt "portfolio"
     */
    function listPortfolio() {
        // TODO: Get portfolio post types
    }
}
