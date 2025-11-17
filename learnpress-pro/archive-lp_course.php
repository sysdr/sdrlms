<?php
/**
 * Course Archive Template
 *
 * @package LearnPress_Pro
 */

get_header();
?>

<div class="course-archive">
    <!-- Page Header -->
    <section class="page-header" style="background: var(--gradient-teal); color: var(--color-white); padding: var(--spacing-xl) 0; text-align: center;">
        <div class="container">
            <h1 style="color: var(--color-white);"><?php _e('All Courses', 'learnpress-pro'); ?></h1>
            <p style="font-size: 1.125rem; opacity: 0.95;">
                <?php _e('Choose from our extensive library of courses', 'learnpress-pro'); ?>
            </p>
        </div>
    </section>

    <div class="container" style="padding: var(--spacing-xl) 0;">
        <!-- Course Filters -->
        <div class="course-filters" style="background: var(--gray-50); padding: var(--spacing-lg); border-radius: var(--radius-lg); margin-bottom: var(--spacing-xl); display: flex; gap: var(--spacing-md); flex-wrap: wrap; align-items: center;">
            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs);">
                    <?php _e('Category:', 'learnpress-pro'); ?>
                </label>
                <select id="course-category-filter" style="width: 100%; padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md);">
                    <option value=""><?php _e('All Categories', 'learnpress-pro'); ?></option>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'course_category',
                        'hide_empty' => true,
                    ));
                    if (!is_wp_error($categories)) {
                        foreach ($categories as $category) {
                            echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs);">
                    <?php _e('Difficulty:', 'learnpress-pro'); ?>
                </label>
                <select id="course-difficulty-filter" style="width: 100%; padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md);">
                    <option value=""><?php _e('All Levels', 'learnpress-pro'); ?></option>
                    <option value="beginner"><?php _e('Beginner', 'learnpress-pro'); ?></option>
                    <option value="intermediate"><?php _e('Intermediate', 'learnpress-pro'); ?></option>
                    <option value="advanced"><?php _e('Advanced', 'learnpress-pro'); ?></option>
                </select>
            </div>

            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs);">
                    <?php _e('Price:', 'learnpress-pro'); ?>
                </label>
                <select id="course-price-filter" style="width: 100%; padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md);">
                    <option value=""><?php _e('All Courses', 'learnpress-pro'); ?></option>
                    <option value="free"><?php _e('Free', 'learnpress-pro'); ?></option>
                    <option value="paid"><?php _e('Paid', 'learnpress-pro'); ?></option>
                </select>
            </div>

            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs);">
                    <?php _e('Sort by:', 'learnpress-pro'); ?>
                </label>
                <select id="course-sort-filter" style="width: 100%; padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: var(--radius-md);">
                    <option value="latest"><?php _e('Latest', 'learnpress-pro'); ?></option>
                    <option value="popular"><?php _e('Most Popular', 'learnpress-pro'); ?></option>
                    <option value="rating"><?php _e('Highest Rated', 'learnpress-pro'); ?></option>
                </select>
            </div>
        </div>

        <!-- Course Count -->
        <div style="margin-bottom: var(--spacing-md); color: var(--gray-600);">
            <?php
            global $wp_query;
            printf(__('Showing %d courses', 'learnpress-pro'), $wp_query->found_posts);
            ?>
        </div>

        <!-- Course Grid -->
        <?php if (have_posts()) : ?>
            <div class="course-grid">
                <?php
                while (have_posts()) : the_post();
                    get_template_part('templates/partials/course', 'card');
                endwhile;
                ?>
            </div>

            <!-- Pagination -->
            <?php
            $pagination = paginate_links(array(
                'prev_text' => __('« Previous', 'learnpress-pro'),
                'next_text' => __('Next »', 'learnpress-pro'),
                'type'      => 'array',
            ));

            if ($pagination) :
                ?>
                <nav class="pagination" style="display: flex; justify-content: center; gap: var(--spacing-xs); margin-top: var(--spacing-xl); flex-wrap: wrap;">
                    <?php
                    foreach ($pagination as $page) {
                        echo str_replace('page-numbers', 'page-numbers btn btn-secondary', $page);
                    }
                    ?>
                </nav>
            <?php endif; ?>

        <?php else : ?>
            <!-- No Courses Found -->
            <div style="text-align: center; padding: var(--spacing-2xl) 0;">
                <div style="font-size: 4rem; margin-bottom: var(--spacing-md);">📚</div>
                <h2><?php _e('No courses found', 'learnpress-pro'); ?></h2>
                <p style="color: var(--gray-600); margin-bottom: var(--spacing-xl);">
                    <?php _e('Try adjusting your filters or check back later for new courses', 'learnpress-pro'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/courses')); ?>" class="btn btn-primary">
                    <?php _e('View All Courses', 'learnpress-pro'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
