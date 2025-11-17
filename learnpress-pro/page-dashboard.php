<?php
/**
 * Template Name: Student Dashboard
 *
 * @package LearnPress_Pro
 */

// Redirect if not logged in
if (!is_user_logged_in()) {
    wp_redirect(wp_login_url(get_permalink()));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$user_id = $current_user->ID;
?>

<div class="dashboard">
    <div class="container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1><?php printf(__('Welcome back, %s!', 'learnpress-pro'), esc_html($current_user->display_name)); ?></h1>
            <p><?php _e('Track your progress and continue learning', 'learnpress-pro'); ?></p>
        </div>

        <!-- Dashboard Stats -->
        <div class="dashboard-stats">
            <?php
            // Get enrolled courses count
            global $wpdb;
            $enrolled_courses = $wpdb->get_results($wpdb->prepare(
                "SELECT meta_key FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key LIKE '_lp_enrolled_course_%%'",
                $user_id
            ));
            $enrolled_count = count($enrolled_courses);

            // Calculate completion stats (mock data for demo)
            $completed_courses = floor($enrolled_count * 0.3); // 30% completed
            $in_progress = $enrolled_count - $completed_courses;
            ?>

            <div class="stat-card">
                <div class="stat-value"><?php echo $enrolled_count; ?></div>
                <div class="stat-label"><?php _e('Enrolled Courses', 'learnpress-pro'); ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?php echo $in_progress; ?></div>
                <div class="stat-label"><?php _e('In Progress', 'learnpress-pro'); ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?php echo $completed_courses; ?></div>
                <div class="stat-label"><?php _e('Completed', 'learnpress-pro'); ?></div>
            </div>

            <div class="stat-card">
                <div class="stat-value">
                    <?php echo $enrolled_count > 0 ? round(($completed_courses / $enrolled_count) * 100) : 0; ?>%
                </div>
                <div class="stat-label"><?php _e('Average Progress', 'learnpress-pro'); ?></div>
            </div>
        </div>

        <!-- Continue Learning -->
        <?php if ($enrolled_count > 0) : ?>
            <section class="dashboard-section">
                <h2><?php _e('Continue Learning', 'learnpress-pro'); ?></h2>

                <div class="course-grid">
                    <?php
                    // Get enrolled courses
                    $enrolled_course_ids = array();
                    foreach ($enrolled_courses as $meta) {
                        $course_id = str_replace('_lp_enrolled_course_', '', $meta->meta_key);
                        $enrolled_course_ids[] = intval($course_id);
                    }

                    if (!empty($enrolled_course_ids)) {
                        $my_courses = new WP_Query(array(
                            'post_type'      => 'lp_course',
                            'post__in'       => $enrolled_course_ids,
                            'posts_per_page' => 6,
                        ));

                        if ($my_courses->have_posts()) :
                            while ($my_courses->have_posts()) : $my_courses->the_post();
                                ?>
                                <div class="course-card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('course-thumbnail', array('class' => 'course-thumbnail')); ?>
                                        </a>
                                    <?php endif; ?>

                                    <div class="course-content">
                                        <h3 class="course-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>

                                        <?php
                                        // Mock progress calculation
                                        $progress = rand(10, 90);
                                        ?>
                                        <div class="course-progress-info" style="margin: var(--spacing-md) 0;">
                                            <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-xs);">
                                                <span style="font-size: 0.875rem; color: var(--gray-600);"><?php _e('Progress', 'learnpress-pro'); ?></span>
                                                <span style="font-size: 0.875rem; font-weight: 600; color: var(--primary-blue);"><?php echo $progress; ?>%</span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: <?php echo $progress; ?>%;"></div>
                                            </div>
                                        </div>

                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="width: 100%;">
                                            <?php _e('Continue', 'learnpress-pro'); ?>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                    }
                    ?>
                </div>

                <div style="text-align: center; margin-top: var(--spacing-xl);">
                    <a href="<?php echo esc_url(home_url('/my-courses')); ?>" class="btn btn-outline">
                        <?php _e('View All My Courses', 'learnpress-pro'); ?>
                    </a>
                </div>
            </section>

            <div class="spacer-large"></div>
        <?php endif; ?>

        <!-- Recommended Courses -->
        <section class="dashboard-section">
            <h2><?php _e('Recommended for You', 'learnpress-pro'); ?></h2>

            <div class="course-grid">
                <?php
                $recommended = new WP_Query(array(
                    'post_type'      => 'lp_course',
                    'posts_per_page' => 3,
                    'post__not_in'   => $enrolled_course_ids,
                    'orderby'        => 'rand',
                ));

                if ($recommended->have_posts()) :
                    while ($recommended->have_posts()) : $recommended->the_post();
                        get_template_part('templates/partials/course', 'card');
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <div style="text-align: center; margin-top: var(--spacing-xl);">
                <a href="<?php echo esc_url(home_url('/courses')); ?>" class="btn btn-gradient">
                    <?php _e('Explore All Courses', 'learnpress-pro'); ?>
                </a>
            </div>
        </section>

        <?php if ($enrolled_count === 0) : ?>
            <!-- Empty State -->
            <div style="text-align: center; padding: var(--spacing-2xl) 0;">
                <div style="font-size: 4rem; margin-bottom: var(--spacing-md);">📚</div>
                <h2><?php _e("You haven't enrolled in any courses yet", 'learnpress-pro'); ?></h2>
                <p style="color: var(--gray-600); margin-bottom: var(--spacing-xl);">
                    <?php _e('Start your learning journey by exploring our course catalog', 'learnpress-pro'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/courses')); ?>" class="btn btn-gradient">
                    <?php _e('Browse Courses', 'learnpress-pro'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
