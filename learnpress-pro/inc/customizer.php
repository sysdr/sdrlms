<?php
/**
 * Theme Customizer
 *
 * @package LearnPress_Pro
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add customizer settings
 */
function learnpress_pro_customize_register($wp_customize) {

    // Add LMS Settings Section
    $wp_customize->add_section('learnpress_pro_settings', array(
        'title'    => __('LMS Settings', 'learnpress-pro'),
        'priority' => 30,
    ));

    // Hero Section Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('The new way to learn starts here', 'learnpress-pro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'learnpress-pro'),
        'section' => 'learnpress_pro_settings',
        'type'    => 'text',
    ));

    // Hero Section Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => __('Master new skills with world-class courses taught by industry experts', 'learnpress-pro'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'learnpress-pro'),
        'section' => 'learnpress_pro_settings',
        'type'    => 'textarea',
    ));

    // Social Proof Text
    $wp_customize->add_setting('social_proof_text', array(
        'default'           => __('Join over 7 million learners worldwide', 'learnpress-pro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('social_proof_text', array(
        'label'   => __('Social Proof Text', 'learnpress-pro'),
        'section' => 'learnpress_pro_settings',
        'type'    => 'text',
    ));

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#0056d2',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'   => __('Primary Color', 'learnpress-pro'),
        'section' => 'learnpress_pro_settings',
    )));

    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#10b981',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'   => __('Secondary Color', 'learnpress-pro'),
        'section' => 'learnpress_pro_settings',
    )));

    // Footer Copyright Text
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => sprintf(__('© %s. All rights reserved.', 'learnpress-pro'), date('Y')),
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_copyright', array(
        'label'   => __('Footer Copyright', 'learnpress-pro'),
        'section' => 'learnpress_pro_settings',
        'type'    => 'text',
    ));

    // Enable/Disable Course Ratings
    $wp_customize->add_setting('enable_course_ratings', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('enable_course_ratings', array(
        'label'   => __('Enable Course Ratings', 'learnpress-pro'),
        'section' => 'learnpress_pro_settings',
        'type'    => 'checkbox',
    ));

    // Courses Per Page
    $wp_customize->add_setting('courses_per_page', array(
        'default'           => 12,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('courses_per_page', array(
        'label'       => __('Courses Per Page', 'learnpress-pro'),
        'section'     => 'learnpress_pro_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 50,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'learnpress_pro_customize_register');

/**
 * Output custom CSS
 */
function learnpress_pro_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#0056d2');
    $secondary_color = get_theme_mod('secondary_color', '#10b981');

    ?>
    <style type="text/css">
        :root {
            --primary-blue: <?php echo esc_attr($primary_color); ?>;
            --success-green: <?php echo esc_attr($secondary_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'learnpress_pro_customizer_css');
