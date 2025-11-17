<?php
/**
 * The main template file
 *
 * @package LearnPress_Pro
 */

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title"><?php _e('The new way to learn starts here', 'learnpress-pro'); ?></h1>
        <p class="hero-subtitle"><?php _e('Master new skills with world-class courses taught by industry experts', 'learnpress-pro'); ?></p>

        <div class="hero-cta">
            <a href="<?php echo esc_url(home_url('/courses')); ?>" class="btn btn-gradient">
                <?php _e('Explore Courses', 'learnpress-pro'); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn btn-outline">
                <?php _e('Learn More', 'learnpress-pro'); ?>
            </a>
        </div>

        <div class="social-proof">
            <?php
            $total_students = wp_count_posts('lp_course');
            printf(__('Join over %s learners worldwide', 'learnpress-pro'), '<strong>7 million</strong>');
            ?>
        </div>
    </div>
</section>

<div class="spacer-medium"></div>

<!-- Featured Courses -->
<section class="featured-courses">
    <div class="container">
        <h2 class="text-center"><?php _e('Featured Courses', 'learnpress-pro'); ?></h2>
        <p class="text-center mb-xl"><?php _e('Start learning with our most popular courses', 'learnpress-pro'); ?></p>

        <div class="course-carousel">
            <div class="carousel-track">
                <?php
                $featured_courses = new WP_Query(array(
                    'post_type'      => 'lp_course',
                    'posts_per_page' => 6,
                    'meta_key'       => '_lp_course_students',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                ));

                if ($featured_courses->have_posts()) :
                    while ($featured_courses->have_posts()) : $featured_courses->the_post();
                        get_template_part('templates/partials/course', 'card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('No courses found.', 'learnpress-pro') . '</p>';
                endif;
                ?>
            </div>

            <div class="carousel-controls">
                <button class="carousel-btn carousel-prev" aria-label="Previous">‹</button>
                <button class="carousel-btn carousel-next" aria-label="Next">›</button>
            </div>

            <div class="carousel-dots"></div>
        </div>
    </div>
</section>

<div class="spacer-large"></div>

<!-- All Courses Grid -->
<section class="all-courses">
    <div class="container">
        <h2 class="text-center"><?php _e('Browse All Courses', 'learnpress-pro'); ?></h2>

        <!-- Course Filters -->
        <div class="course-filters">
            <div class="filter-group">
                <label><?php _e('Category:', 'learnpress-pro'); ?></label>
                <select id="course-category-filter">
                    <option value=""><?php _e('All Categories', 'learnpress-pro'); ?></option>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'course_category',
                        'hide_empty' => true,
                    ));
                    foreach ($categories as $category) :
                        ?>
                        <option value="<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label><?php _e('Difficulty:', 'learnpress-pro'); ?></label>
                <select id="course-difficulty-filter">
                    <option value=""><?php _e('All Levels', 'learnpress-pro'); ?></option>
                    <option value="beginner"><?php _e('Beginner', 'learnpress-pro'); ?></option>
                    <option value="intermediate"><?php _e('Intermediate', 'learnpress-pro'); ?></option>
                    <option value="advanced"><?php _e('Advanced', 'learnpress-pro'); ?></option>
                </select>
            </div>

            <div class="filter-group">
                <label><?php _e('Price:', 'learnpress-pro'); ?></label>
                <select id="course-price-filter">
                    <option value=""><?php _e('All Courses', 'learnpress-pro'); ?></option>
                    <option value="free"><?php _e('Free', 'learnpress-pro'); ?></option>
                    <option value="paid"><?php _e('Paid', 'learnpress-pro'); ?></option>
                </select>
            </div>
        </div>

        <div class="course-grid" id="courses-container">
            <?php
            $args = array(
                'post_type'      => 'lp_course',
                'posts_per_page' => 12,
                'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
            );

            $courses_query = new WP_Query($args);

            if ($courses_query->have_posts()) :
                while ($courses_query->have_posts()) : $courses_query->the_post();
                    get_template_part('templates/partials/course', 'card');
                endwhile;
            else :
                echo '<p class="no-courses">' . __('No courses found. Check back soon!', 'learnpress-pro') . '</p>';
            endif;
            ?>
        </div>

        <?php
        // Pagination
        if ($courses_query->max_num_pages > 1) :
            ?>
            <div class="pagination">
                <?php
                echo paginate_links(array(
                    'total'   => $courses_query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'prev_text' => __('« Previous', 'learnpress-pro'),
                    'next_text' => __('Next »', 'learnpress-pro'),
                ));
                ?>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>

<div class="spacer-large"></div>

<!-- Stats Section -->
<section class="stats-section" style="background: var(--gray-50); padding: var(--spacing-2xl) 0;">
    <div class="container">
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-value"><?php echo wp_count_posts('lp_course')->publish; ?></div>
                <div class="stat-label"><?php _e('Courses Available', 'learnpress-pro'); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-value">7M+</div>
                <div class="stat-label"><?php _e('Active Learners', 'learnpress-pro'); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-value">50+</div>
                <div class="stat-label"><?php _e('Expert Instructors', 'learnpress-pro'); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-value">4.8★</div>
                <div class="stat-label"><?php _e('Average Rating', 'learnpress-pro'); ?></div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
