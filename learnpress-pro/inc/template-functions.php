<?php
/**
 * Template Functions
 *
 * @package LearnPress_Pro
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get formatted course duration
 */
function learnpress_pro_get_course_duration($course_id) {
    $duration = get_post_meta($course_id, '_lp_course_duration', true);
    if (!$duration) {
        return '';
    }

    if ($duration < 1) {
        return sprintf(__('%d minutes', 'learnpress-pro'), $duration * 60);
    } elseif ($duration == 1) {
        return __('1 hour', 'learnpress-pro');
    } else {
        return sprintf(__('%s hours', 'learnpress-pro'), $duration);
    }
}

/**
 * Get course price display
 */
function learnpress_pro_get_price_html($course_id) {
    $is_free = get_post_meta($course_id, '_lp_course_is_free', true);
    $price = get_post_meta($course_id, '_lp_course_price', true);

    if ($is_free == '1') {
        return '<span class="course-price free">' . __('Free', 'learnpress-pro') . '</span>';
    } elseif ($price) {
        return '<span class="course-price">$' . number_format($price, 2) . '</span>';
    }

    return '';
}

/**
 * Get total enrolled courses for user
 */
function learnpress_pro_get_user_enrolled_count($user_id = 0) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }

    global $wpdb;
    $count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key LIKE '_lp_enrolled_course_%%'",
        $user_id
    ));

    return intval($count);
}

/**
 * Custom excerpt length
 */
function learnpress_pro_excerpt_length($length) {
    return is_singular('lp_course') ? 50 : 25;
}
add_filter('excerpt_length', 'learnpress_pro_excerpt_length');

/**
 * Custom excerpt more
 */
function learnpress_pro_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'learnpress_pro_excerpt_more');

/**
 * Add body classes for LMS pages
 */
function learnpress_pro_body_classes($classes) {
    if (is_singular('lp_course')) {
        $classes[] = 'single-course-page';
    }

    if (is_post_type_archive('lp_course')) {
        $classes[] = 'course-archive-page';
    }

    if (is_page_template('page-dashboard.php')) {
        $classes[] = 'dashboard-page';
    }

    return $classes;
}
add_filter('body_class', 'learnpress_pro_body_classes');

/**
 * Pagination
 */
function learnpress_pro_pagination() {
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) {
        return;
    }

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    echo '<div class="pagination">';

    if ($paged > 1) {
        echo '<a href="' . get_pagenum_link($paged - 1) . '" class="page-link prev">« ' . __('Previous', 'learnpress-pro') . '</a>';
    }

    for ($i = 1; $i <= $max; $i++) {
        $class = ($i == $paged) ? 'page-link current' : 'page-link';
        echo '<a href="' . get_pagenum_link($i) . '" class="' . $class . '">' . $i . '</a>';
    }

    if ($paged < $max) {
        echo '<a href="' . get_pagenum_link($paged + 1) . '" class="page-link next">' . __('Next', 'learnpress-pro') . ' »</a>';
    }

    echo '</div>';
}

/**
 * Get user's enrolled courses
 */
function learnpress_pro_get_user_courses($user_id = 0, $limit = -1) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }

    global $wpdb;
    $enrolled = $wpdb->get_results($wpdb->prepare(
        "SELECT meta_key FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key LIKE '_lp_enrolled_course_%%'",
        $user_id
    ));

    $course_ids = array();
    foreach ($enrolled as $meta) {
        $course_id = str_replace('_lp_enrolled_course_', '', $meta->meta_key);
        $course_ids[] = intval($course_id);
    }

    if (empty($course_ids)) {
        return array();
    }

    $args = array(
        'post_type'      => 'lp_course',
        'post__in'       => $course_ids,
        'posts_per_page' => $limit,
    );

    return new WP_Query($args);
}

/**
 * Display star rating
 */
function learnpress_pro_star_rating($rating, $echo = true) {
    $rating = floatval($rating);
    $full_stars = floor($rating);
    $half_star = ($rating - $full_stars) >= 0.5;
    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

    $output = '<div class="star-rating" title="' . sprintf(__('Rated %s out of 5', 'learnpress-pro'), $rating) . '">';

    for ($i = 0; $i < $full_stars; $i++) {
        $output .= '<span class="star full">★</span>';
    }

    if ($half_star) {
        $output .= '<span class="star half">★</span>';
    }

    for ($i = 0; $i < $empty_stars; $i++) {
        $output .= '<span class="star empty">☆</span>';
    }

    $output .= '</div>';

    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}
