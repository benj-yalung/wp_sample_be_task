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

if ( ! shortcode_exists( 'list-portfolio' ) ) {
    add_shortcode( 'list-portfolio', 'listPortfolio' );
}

if ( ! function_exists('listPortfolio') ) {
    /**
     * List the cpt "portfolio"
     */
    function listPortfolio() {
        $portfolios = get_posts(array(
            'post_type' => 'portfolio',
            'posts_per_page' => 2
        ));
        $args = array(
            'portfolios' => $portfolios
        );

        get_template_part( 'template-parts/list-portfolio', args: $args);
    }
}

if ( ! function_exists( 'data_get' ) ) {
    function data_get(mixed $data, string $key, mixed $default = null) {
        foreach ( explode('.', $key) as $segment ) {
            if ( is_object( $data ) ) {
                if ( ! isset( $data->{$segment} ) ) {
                    return $default;
                }

                $data = $data->{$segment};
            } elseif ( is_array( $data ) ) {
                if ( ! isset( $data[$segment] ) ) {
                    return $default;
                }
                $data = $data[$segment];
            } else {
                return $default;
            }
        }

        return $data;
    }
}

if ( ! function_exists( 'curl_request' ) ) {
    function curl_request( string $url, mixed $post_data = null ) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        if ($post_data !== null) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        $output = curl_exec($ch);
        curl_close($ch);
    
        return $output;
    }
}

if ( ! function_exists( 'request_weather_data' ) ) {
    function request_weather_data() {
        $url = 'https://api.open-meteo.com/v1/forecast?latitude=52.52&longitude=13.41&current=temperature_2m,precipitation,cloud_cover,wind_speed_10m';
        return curl_request($url);
    }
}

if ( ! function_exists( 'prepare_weather_data' ) ) {
    function prepare_weather_data(bool $isDisplay = false) {
        $weatherData = json_decode(request_weather_data());

        $windSpeedUnit = data_get($weatherData, 'current_units.wind_speed_10m');
        $windSpeedValue = data_get($weatherData, 'current.wind_speed_10m');

        $temperatureUnit = data_get($weatherData, 'current_units.temperature_2m');
        $temperatureValue = data_get($weatherData, 'current.temperature_2m');

        $cloudUnit = data_get($weatherData, 'current_units.cloud_cover');
        $cloudValue = data_get($weatherData, 'current.cloud_cover');

        $currenTime = data_get($weatherData, 'current.time');

        $urlPrefix = trailingslashit( get_stylesheet_directory_uri() );
        $cloudCovers = array(
            "Clear sky" => array(0, 10, $urlPrefix . 'images/clear_sky.jpg'),
            "Few clouds" => array(11, 25, $urlPrefix . 'images/few_cloud.jpg'),
            "Scattered clouds" => array(26, 50, $urlPrefix . 'images/scatterd_clouds.jpg'),
            "Broken clouds" => array(51, 84, $urlPrefix . 'images/broken_clouds.jpg'),
            "Cloudy" => array(85, 100, $urlPrefix . 'images/cloudy.jpg'),
        );

        $cloudCover = '';
        $cloudImage = '';
        foreach( $cloudCovers as $description => $range ) {
            if ( $cloudValue >= $range[0] && $cloudValue <= $range[1] ) {
                $cloudCover = $description;
                $cloudImage = $range[2];
                break;
            }
        }

        if ($isDisplay) {
            return 'Wind Speed: ' . $windSpeedValue . $windSpeedUnit . ' | ' . 'Temperature: ' . $temperatureValue . $temperatureUnit;
        }

        return array(
            'wind' => $windSpeedValue . $windSpeedUnit,
            'windLabel' => 'Wind Speed: ' . $windSpeedValue . $windSpeedUnit,
            'temperature' => $temperatureValue . $temperatureUnit,
            'temperatureLabel' => 'Temperature: ' . $temperatureValue . $temperatureUnit,
            'cloud' => $cloudValue . $cloudUnit,
            'cloudLabel' => $cloudCover,
            'cloudImage' => $cloudImage,
            'currentTime' => date('F j, Y h:i A', strtotime($currenTime))
        );
    }
}

if ( ! shortcode_exists( 'weather-data' ) ) {
    add_shortcode( 'weather-data', 'weather_data' );

    function weather_data() {
        $args = array(
            'data' => prepare_weather_data()
        );

        get_template_part( 'template-parts/weather-data', args: $args);
    }
}

if ( ! shortcode_exists( 'weather-image' ) ) {
    add_shortcode( 'weather-image', 'weather_image' );

    function weather_image() {
        $args = array(
            'data' => prepare_weather_data()
        );

        get_template_part( 'template-parts/weather-image', args: $args);
    }
}
