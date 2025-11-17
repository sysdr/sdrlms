<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- About Section -->
            <div class="footer-section">
                <h4><?php _e('About', 'learnpress-pro'); ?></h4>
                <p><?php bloginfo('description'); ?></p>
                <?php if (has_custom_logo()) : ?>
                    <div class="footer-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4><?php _e('Quick Links', 'learnpress-pro'); ?></h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-links',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => 'learnpress_pro_footer_menu',
                ));
                ?>
            </div>

            <!-- Courses -->
            <div class="footer-section">
                <h4><?php _e('Popular Categories', 'learnpress-pro'); ?></h4>
                <ul class="footer-links">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'course_category',
                        'number'   => 5,
                        'orderby'  => 'count',
                        'order'    => 'DESC',
                    ));
                    if (!empty($categories) && !is_wp_error($categories)) :
                        foreach ($categories as $category) :
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </li>
                        <?php
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>

            <!-- Contact/Newsletter -->
            <div class="footer-section">
                <h4><?php _e('Stay Connected', 'learnpress-pro'); ?></h4>
                <p><?php _e('Subscribe to our newsletter for updates', 'learnpress-pro'); ?></p>
                <form class="newsletter-form" action="#" method="post">
                    <input type="email" name="email" placeholder="<?php esc_attr_e('Your email', 'learnpress-pro'); ?>" required>
                    <button type="submit" class="btn btn-primary"><?php _e('Subscribe', 'learnpress-pro'); ?></button>
                </form>
                <div class="social-links">
                    <!-- Add social media links here -->
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'learnpress-pro'); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * Default footer menu fallback
 */
function learnpress_pro_footer_menu() {
    echo '<ul class="footer-links">';
    echo '<li><a href="' . esc_url(home_url('/courses')) . '">' . __('Courses', 'learnpress-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">' . __('About', 'learnpress-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">' . __('Contact', 'learnpress-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/privacy-policy')) . '">' . __('Privacy Policy', 'learnpress-pro') . '</a></li>';
    echo '</ul>';
}
?>
