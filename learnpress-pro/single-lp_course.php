<?php
/**
 * Single Course Template
 *
 * @package LearnPress_Pro
 */

get_header();

while (have_posts()) : the_post();
    $course_id = get_the_ID();
    $price = get_post_meta($course_id, '_lp_course_price', true);
    $duration = get_post_meta($course_id, '_lp_course_duration', true);
    $students = get_post_meta($course_id, '_lp_course_students', true);
    $rating = get_post_meta($course_id, '_lp_course_rating', true);
    $is_free = get_post_meta($course_id, '_lp_course_is_free', true);
    $difficulty = wp_get_post_terms($course_id, 'course_difficulty');
    $instructor = learnpress_pro_get_course_instructor($course_id);
    $is_enrolled = learnpress_pro_is_enrolled($course_id);
    ?>

    <article id="course-<?php the_ID(); ?>" <?php post_class('single-course'); ?>>

        <!-- Course Hero -->
        <section class="course-hero" style="background: var(--gradient-purple); color: var(--color-white); padding: var(--spacing-2xl) 0;">
            <div class="container">
                <div style="max-width: 800px;">
                    <!-- Breadcrumbs -->
                    <div class="breadcrumbs" style="margin-bottom: var(--spacing-md); opacity: 0.9;">
                        <a href="<?php echo esc_url(home_url('/')); ?>" style="color: var(--color-white);"><?php _e('Home', 'learnpress-pro'); ?></a>
                        <span> / </span>
                        <a href="<?php echo esc_url(home_url('/courses')); ?>" style="color: var(--color-white);"><?php _e('Courses', 'learnpress-pro'); ?></a>
                        <span> / </span>
                        <span><?php the_title(); ?></span>
                    </div>

                    <h1 style="color: var(--color-white); margin-bottom: var(--spacing-md);"><?php the_title(); ?></h1>

                    <div class="course-excerpt" style="font-size: 1.125rem; margin-bottom: var(--spacing-lg); opacity: 0.95;">
                        <?php the_excerpt(); ?>
                    </div>

                    <div class="course-meta-info" style="display: flex; gap: var(--spacing-lg); flex-wrap: wrap; align-items: center;">
                        <?php if ($rating) : ?>
                            <div class="course-rating">
                                <span class="rating-stars" style="color: var(--warning-orange);">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo $i <= $rating ? '★' : '☆';
                                    }
                                    ?>
                                </span>
                                <span><?php echo number_format($rating, 1); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($students) : ?>
                            <div>
                                <strong><?php echo number_format($students); ?></strong> <?php _e('students enrolled', 'learnpress-pro'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($duration) : ?>
                            <div>
                                <strong><?php echo esc_html($duration); ?></strong> <?php _e('hours', 'learnpress-pro'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($difficulty)) : ?>
                            <div>
                                <?php _e('Level:', 'learnpress-pro'); ?> <strong><?php echo esc_html($difficulty[0]->name); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($instructor) : ?>
                        <div class="course-instructor-info" style="margin-top: var(--spacing-lg); display: flex; align-items: center; gap: var(--spacing-md);">
                            <?php echo get_avatar($instructor->ID, 64); ?>
                            <div>
                                <div style="font-size: 0.875rem; opacity: 0.9;"><?php _e('Created by', 'learnpress-pro'); ?></div>
                                <div style="font-size: 1.125rem; font-weight: 600;"><?php echo esc_html($instructor->display_name); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <div class="container" style="margin-top: var(--spacing-2xl);">
            <div style="display: grid; grid-template-columns: 1fr 380px; gap: var(--spacing-xl);">
                <!-- Main Content -->
                <div class="course-main-content">
                    <!-- Course Thumbnail -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="course-featured-image" style="margin-bottom: var(--spacing-xl);">
                            <?php the_post_thumbnail('course-featured', array('style' => 'width: 100%; height: auto; border-radius: var(--radius-lg);')); ?>
                        </div>
                    <?php endif; ?>

                    <!-- About Course -->
                    <section class="course-description">
                        <h2><?php _e('About This Course', 'learnpress-pro'); ?></h2>
                        <div class="course-content">
                            <?php the_content(); ?>
                        </div>
                    </section>

                    <div class="spacer-medium"></div>

                    <!-- What You'll Learn -->
                    <section class="course-objectives">
                        <h2><?php _e("What You'll Learn", 'learnpress-pro'); ?></h2>
                        <ul style="list-style: none; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-sm);">
                            <li style="display: flex; gap: var(--spacing-sm);"><span style="color: var(--success-green);">✓</span> Build real-world projects</li>
                            <li style="display: flex; gap: var(--spacing-sm);"><span style="color: var(--success-green);">✓</span> Master key concepts</li>
                            <li style="display: flex; gap: var(--spacing-sm);"><span style="color: var(--success-green);">✓</span> Get hands-on experience</li>
                            <li style="display: flex; gap: var(--spacing-sm);"><span style="color: var(--success-green);">✓</span> Earn a certificate</li>
                        </ul>
                    </section>

                    <div class="spacer-medium"></div>

                    <!-- Course Curriculum (Sample) -->
                    <section class="course-curriculum">
                        <h2><?php _e('Course Curriculum', 'learnpress-pro'); ?></h2>
                        <?php
                        // Get lessons associated with this course
                        $lessons = new WP_Query(array(
                            'post_type'      => 'lp_lesson',
                            'posts_per_page' => -1,
                            'meta_query'     => array(
                                array(
                                    'key'   => '_lp_course_id',
                                    'value' => $course_id,
                                ),
                            ),
                        ));

                        if ($lessons->have_posts()) :
                            echo '<div class="curriculum-list">';
                            $lesson_num = 1;
                            while ($lessons->have_posts()) : $lessons->the_post();
                                ?>
                                <div class="curriculum-item" style="padding: var(--spacing-md); border: 1px solid var(--gray-200); border-radius: var(--radius-md); margin-bottom: var(--spacing-sm); display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                                        <span style="background: var(--gray-100); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                            <?php echo $lesson_num++; ?>
                                        </span>
                                        <span><?php the_title(); ?></span>
                                    </div>
                                    <span style="color: var(--gray-600); font-size: 0.875rem;">15 min</span>
                                </div>
                                <?php
                            endwhile;
                            echo '</div>';
                            wp_reset_postdata();
                        else :
                            echo '<p>' . __('Curriculum coming soon...', 'learnpress-pro') . '</p>';
                        endif;
                        ?>
                    </section>
                </div>

                <!-- Sidebar -->
                <aside class="course-sidebar">
                    <div class="course-sidebar-sticky" style="position: sticky; top: 100px;">
                        <div style="background: var(--color-white); padding: var(--spacing-lg); border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
                            <!-- Price -->
                            <div style="margin-bottom: var(--spacing-lg);">
                                <?php if ($is_free == '1') : ?>
                                    <div style="font-size: 2rem; font-weight: 700; color: var(--success-green);">
                                        <?php _e('Free', 'learnpress-pro'); ?>
                                    </div>
                                <?php elseif ($price) : ?>
                                    <div style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">
                                        $<?php echo number_format($price, 2); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Enroll Button -->
                            <?php if (is_user_logged_in()) : ?>
                                <?php if ($is_enrolled) : ?>
                                    <a href="<?php echo esc_url(home_url('/dashboard')); ?>" class="btn btn-primary" style="width: 100%; margin-bottom: var(--spacing-md);">
                                        <?php _e('Go to Course', 'learnpress-pro'); ?>
                                    </a>
                                <?php else : ?>
                                    <button class="btn btn-gradient enroll-course-btn" data-course-id="<?php echo esc_attr($course_id); ?>" style="width: 100%; margin-bottom: var(--spacing-md);">
                                        <?php _e('Enroll Now', 'learnpress-pro'); ?>
                                    </button>
                                <?php endif; ?>
                            <?php else : ?>
                                <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="btn btn-gradient" style="width: 100%; margin-bottom: var(--spacing-md);">
                                    <?php _e('Sign In to Enroll', 'learnpress-pro'); ?>
                                </a>
                            <?php endif; ?>

                            <!-- Course Features -->
                            <div style="border-top: 1px solid var(--gray-200); padding-top: var(--spacing-md);">
                                <h4 style="margin-bottom: var(--spacing-md);"><?php _e('This course includes:', 'learnpress-pro'); ?></h4>
                                <ul style="list-style: none;">
                                    <li style="display: flex; gap: var(--spacing-sm); margin-bottom: var(--spacing-sm);">
                                        <span>📹</span> <span><?php echo esc_html($duration ?: '10'); ?> hours video</span>
                                    </li>
                                    <li style="display: flex; gap: var(--spacing-sm); margin-bottom: var(--spacing-sm);">
                                        <span>📄</span> <span><?php _e('Downloadable resources', 'learnpress-pro'); ?></span>
                                    </li>
                                    <li style="display: flex; gap: var(--spacing-sm); margin-bottom: var(--spacing-sm);">
                                        <span>♾️</span> <span><?php _e('Lifetime access', 'learnpress-pro'); ?></span>
                                    </li>
                                    <li style="display: flex; gap: var(--spacing-sm); margin-bottom: var(--spacing-sm);">
                                        <span>📱</span> <span><?php _e('Mobile & desktop', 'learnpress-pro'); ?></span>
                                    </li>
                                    <li style="display: flex; gap: var(--spacing-sm); margin-bottom: var(--spacing-sm);">
                                        <span>🏆</span> <span><?php _e('Certificate of completion', 'learnpress-pro'); ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div class="spacer-large"></div>

    </article>

<?php
endwhile;

get_footer();
?>
