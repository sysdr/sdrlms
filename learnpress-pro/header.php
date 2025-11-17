<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <!-- Logo -->
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation -->
            <nav class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => 'learnpress_pro_default_menu',
                ));
                ?>
            </nav>

            <!-- Header CTA -->
            <div class="header-cta">
                <?php if (is_user_logged_in()) : ?>
                    <?php $current_user = wp_get_current_user(); ?>
                    <div class="user-menu-wrapper">
                        <a href="<?php echo esc_url(home_url('/dashboard')); ?>" class="user-profile-link">
                            <?php echo get_avatar($current_user->ID, 32); ?>
                            <span><?php echo esc_html($current_user->display_name); ?></span>
                        </a>
                        <div class="user-dropdown">
                            <a href="<?php echo esc_url(home_url('/dashboard')); ?>"><?php _e('Dashboard', 'learnpress-pro'); ?></a>
                            <a href="<?php echo esc_url(home_url('/my-courses')); ?>"><?php _e('My Courses', 'learnpress-pro'); ?></a>
                            <a href="<?php echo esc_url(get_edit_profile_url()); ?>"><?php _e('Profile', 'learnpress-pro'); ?></a>
                            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php _e('Logout', 'learnpress-pro'); ?></a>
                        </div>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url(wp_login_url()); ?>" class="btn btn-secondary">
                        <?php _e('Sign In', 'learnpress-pro'); ?>
                    </a>
                    <a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn-primary">
                        <?php _e('Get Started', 'learnpress-pro'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" aria-label="Toggle Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<?php
/**
 * Default menu fallback
 */
function learnpress_pro_default_menu() {
    echo '<ul class="primary-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'learnpress-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/courses')) . '">' . __('Explore Courses', 'learnpress-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">' . __('About', 'learnpress-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">' . __('Contact', 'learnpress-pro') . '</a></li>';
    echo '</ul>';
}
?>
