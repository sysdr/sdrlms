<?php
/**
 * LearnPress Pro Theme Functions
 *
 * @package LearnPress_Pro
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme Constants
define('LEARNPRESS_PRO_VERSION', '1.0.0');
define('LEARNPRESS_PRO_THEME_DIR', get_template_directory());
define('LEARNPRESS_PRO_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function learnpress_pro_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary'   => __('Primary Menu', 'learnpress-pro'),
        'footer'    => __('Footer Menu', 'learnpress-pro'),
        'user-menu' => __('User Dashboard Menu', 'learnpress-pro'),
    ));

    // Add image sizes
    add_image_size('course-thumbnail', 400, 250, true);
    add_image_size('course-featured', 800, 400, true);
    add_image_size('instructor-avatar', 100, 100, true);
}
add_action('after_setup_theme', 'learnpress_pro_setup');

/**
 * Enqueue Scripts and Styles
 */
function learnpress_pro_scripts() {
    // Main stylesheet
    wp_enqueue_style('learnpress-pro-style', get_stylesheet_uri(), array(), LEARNPRESS_PRO_VERSION);

    // Google Fonts
    wp_enqueue_style('learnpress-pro-fonts', 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&family=Fira+Code:wght@400;500&display=swap', array(), null);

    // Main JavaScript
    wp_enqueue_script('learnpress-pro-main', LEARNPRESS_PRO_THEME_URI . '/assets/js/main.js', array('jquery'), LEARNPRESS_PRO_VERSION, true);

    // Localize script for AJAX
    wp_localize_script('learnpress-pro-main', 'learnpressProAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('learnpress_pro_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'learnpress_pro_scripts');

/**
 * Register Custom Post Types
 */
function learnpress_pro_register_post_types() {
    // Course Post Type
    register_post_type('lp_course', array(
        'labels' => array(
            'name'               => __('Courses', 'learnpress-pro'),
            'singular_name'      => __('Course', 'learnpress-pro'),
            'add_new'            => __('Add New Course', 'learnpress-pro'),
            'add_new_item'       => __('Add New Course', 'learnpress-pro'),
            'edit_item'          => __('Edit Course', 'learnpress-pro'),
            'new_item'           => __('New Course', 'learnpress-pro'),
            'view_item'          => __('View Course', 'learnpress-pro'),
            'search_items'       => __('Search Courses', 'learnpress-pro'),
            'not_found'          => __('No courses found', 'learnpress-pro'),
            'not_found_in_trash' => __('No courses found in trash', 'learnpress-pro'),
        ),
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-book-alt',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments'),
        'rewrite'             => array('slug' => 'courses'),
        'capability_type'     => 'post',
    ));

    // Lesson Post Type
    register_post_type('lp_lesson', array(
        'labels' => array(
            'name'               => __('Lessons', 'learnpress-pro'),
            'singular_name'      => __('Lesson', 'learnpress-pro'),
            'add_new'            => __('Add New Lesson', 'learnpress-pro'),
            'add_new_item'       => __('Add New Lesson', 'learnpress-pro'),
            'edit_item'          => __('Edit Lesson', 'learnpress-pro'),
            'new_item'           => __('New Lesson', 'learnpress-pro'),
            'view_item'          => __('View Lesson', 'learnpress-pro'),
            'search_items'       => __('Search Lessons', 'learnpress-pro'),
        ),
        'public'              => true,
        'has_archive'         => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'             => array('slug' => 'lessons'),
        'capability_type'     => 'post',
    ));

    // Quiz Post Type
    register_post_type('lp_quiz', array(
        'labels' => array(
            'name'               => __('Quizzes', 'learnpress-pro'),
            'singular_name'      => __('Quiz', 'learnpress-pro'),
            'add_new'            => __('Add New Quiz', 'learnpress-pro'),
            'edit_item'          => __('Edit Quiz', 'learnpress-pro'),
        ),
        'public'              => true,
        'has_archive'         => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-text-page',
        'supports'            => array('title', 'editor'),
        'rewrite'             => array('slug' => 'quizzes'),
        'capability_type'     => 'post',
    ));
}
add_action('init', 'learnpress_pro_register_post_types');

/**
 * Register Custom Taxonomies
 */
function learnpress_pro_register_taxonomies() {
    // Course Category
    register_taxonomy('course_category', 'lp_course', array(
        'labels' => array(
            'name'          => __('Course Categories', 'learnpress-pro'),
            'singular_name' => __('Course Category', 'learnpress-pro'),
            'search_items'  => __('Search Categories', 'learnpress-pro'),
            'all_items'     => __('All Categories', 'learnpress-pro'),
            'edit_item'     => __('Edit Category', 'learnpress-pro'),
            'update_item'   => __('Update Category', 'learnpress-pro'),
            'add_new_item'  => __('Add New Category', 'learnpress-pro'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'course-category'),
    ));

    // Course Tag
    register_taxonomy('course_tag', 'lp_course', array(
        'labels' => array(
            'name'          => __('Course Tags', 'learnpress-pro'),
            'singular_name' => __('Course Tag', 'learnpress-pro'),
            'search_items'  => __('Search Tags', 'learnpress-pro'),
            'all_items'     => __('All Tags', 'learnpress-pro'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'course-tag'),
    ));

    // Difficulty Level
    register_taxonomy('course_difficulty', 'lp_course', array(
        'labels' => array(
            'name'          => __('Difficulty Levels', 'learnpress-pro'),
            'singular_name' => __('Difficulty Level', 'learnpress-pro'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'difficulty'),
    ));
}
add_action('init', 'learnpress_pro_register_taxonomies');

/**
 * Add Custom User Roles
 */
function learnpress_pro_add_roles() {
    // Instructor Role
    add_role('lp_instructor', __('Instructor', 'learnpress-pro'), array(
        'read'                   => true,
        'edit_posts'             => true,
        'delete_posts'           => true,
        'publish_posts'          => true,
        'upload_files'           => true,
        'edit_published_posts'   => true,
        'delete_published_posts' => true,
    ));

    // Student Role
    add_role('lp_student', __('Student', 'learnpress-pro'), array(
        'read' => true,
    ));
}
add_action('init', 'learnpress_pro_add_roles');

/**
 * Register Widget Areas
 */
function learnpress_pro_widgets_init() {
    register_sidebar(array(
        'name'          => __('Course Sidebar', 'learnpress-pro'),
        'id'            => 'course-sidebar',
        'description'   => __('Add widgets for course pages', 'learnpress-pro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __('Dashboard Sidebar', 'learnpress-pro'),
        'id'            => 'dashboard-sidebar',
        'description'   => __('Add widgets for student dashboard', 'learnpress-pro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'learnpress_pro_widgets_init');

/**
 * Custom Meta Boxes for Courses
 */
function learnpress_pro_add_course_meta_boxes() {
    add_meta_box(
        'course_details',
        __('Course Details', 'learnpress-pro'),
        'learnpress_pro_course_details_callback',
        'lp_course',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'learnpress_pro_add_course_meta_boxes');

function learnpress_pro_course_details_callback($post) {
    wp_nonce_field('learnpress_pro_course_details', 'learnpress_pro_course_details_nonce');

    $price = get_post_meta($post->ID, '_lp_course_price', true);
    $duration = get_post_meta($post->ID, '_lp_course_duration', true);
    $students = get_post_meta($post->ID, '_lp_course_students', true);
    $rating = get_post_meta($post->ID, '_lp_course_rating', true);
    $is_free = get_post_meta($post->ID, '_lp_course_is_free', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="course_price"><?php _e('Price ($)', 'learnpress-pro'); ?></label></th>
            <td><input type="number" id="course_price" name="course_price" value="<?php echo esc_attr($price); ?>" step="0.01" /></td>
        </tr>
        <tr>
            <th><label for="course_is_free"><?php _e('Free Course', 'learnpress-pro'); ?></label></th>
            <td><input type="checkbox" id="course_is_free" name="course_is_free" value="1" <?php checked($is_free, '1'); ?> /></td>
        </tr>
        <tr>
            <th><label for="course_duration"><?php _e('Duration (hours)', 'learnpress-pro'); ?></label></th>
            <td><input type="number" id="course_duration" name="course_duration" value="<?php echo esc_attr($duration); ?>" /></td>
        </tr>
        <tr>
            <th><label for="course_students"><?php _e('Number of Students', 'learnpress-pro'); ?></label></th>
            <td><input type="number" id="course_students" name="course_students" value="<?php echo esc_attr($students); ?>" /></td>
        </tr>
        <tr>
            <th><label for="course_rating"><?php _e('Rating (0-5)', 'learnpress-pro'); ?></label></th>
            <td><input type="number" id="course_rating" name="course_rating" value="<?php echo esc_attr($rating); ?>" step="0.1" min="0" max="5" /></td>
        </tr>
    </table>
    <?php
}

function learnpress_pro_save_course_details($post_id) {
    if (!isset($_POST['learnpress_pro_course_details_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['learnpress_pro_course_details_nonce'], 'learnpress_pro_course_details')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('course_price', 'course_duration', 'course_students', 'course_rating');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_lp_' . $field, sanitize_text_field($_POST[$field]));
        }
    }

    $is_free = isset($_POST['course_is_free']) ? '1' : '0';
    update_post_meta($post_id, '_lp_course_is_free', $is_free);
}
add_action('save_post_lp_course', 'learnpress_pro_save_course_details');

/**
 * User Progress Tracking Functions
 */
function learnpress_pro_track_lesson_completion($user_id, $lesson_id, $course_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'lp_user_progress';

    $wpdb->replace(
        $table_name,
        array(
            'user_id'     => $user_id,
            'lesson_id'   => $lesson_id,
            'course_id'   => $course_id,
            'status'      => 'completed',
            'completed_at' => current_time('mysql'),
        ),
        array('%d', '%d', '%d', '%s', '%s')
    );
}

function learnpress_pro_get_course_progress($user_id, $course_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'lp_user_progress';

    $total_lessons = wp_count_posts('lp_lesson')->publish;
    $completed_lessons = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE user_id = %d AND course_id = %d AND status = 'completed'",
        $user_id,
        $course_id
    ));

    return $total_lessons > 0 ? ($completed_lessons / $total_lessons) * 100 : 0;
}

/**
 * Create Database Tables for Progress Tracking
 */
function learnpress_pro_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'lp_user_progress';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        course_id bigint(20) NOT NULL,
        lesson_id bigint(20) NOT NULL,
        status varchar(20) NOT NULL,
        completed_at datetime DEFAULT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY user_lesson (user_id, lesson_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'learnpress_pro_create_tables');

/**
 * AJAX Handler for Course Enrollment
 */
function learnpress_pro_enroll_course() {
    check_ajax_referer('learnpress_pro_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => __('You must be logged in to enroll.', 'learnpress-pro')));
    }

    $course_id = intval($_POST['course_id']);
    $user_id = get_current_user_id();

    // Add user to course enrollment
    $enrolled = add_user_meta($user_id, '_lp_enrolled_course_' . $course_id, time(), true);

    if ($enrolled) {
        // Increment student count
        $students = get_post_meta($course_id, '_lp_course_students', true);
        update_post_meta($course_id, '_lp_course_students', intval($students) + 1);

        wp_send_json_success(array('message' => __('Successfully enrolled!', 'learnpress-pro')));
    } else {
        wp_send_json_error(array('message' => __('Already enrolled or error occurred.', 'learnpress-pro')));
    }
}
add_action('wp_ajax_learnpress_enroll_course', 'learnpress_pro_enroll_course');

/**
 * Check if user is enrolled in course
 */
function learnpress_pro_is_enrolled($course_id, $user_id = 0) {
    if (!$user_id) {
        $user_id = get_current_user_id();
    }
    return metadata_exists('user', $user_id, '_lp_enrolled_course_' . $course_id);
}

/**
 * Get Course Instructor
 */
function learnpress_pro_get_course_instructor($course_id) {
    $course = get_post($course_id);
    return get_userdata($course->post_author);
}

/**
 * Template Helper Functions
 */
function learnpress_pro_course_rating_html($rating, $count = 0) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '★';
        } else {
            $stars .= '☆';
        }
    }
    echo '<div class="course-rating">';
    echo '<span class="rating-stars">' . $stars . '</span>';
    if ($count > 0) {
        echo '<span class="rating-count">(' . number_format($rating, 1) . ')</span>';
    }
    echo '</div>';
}

/**
 * Include additional files
 */
require_once LEARNPRESS_PRO_THEME_DIR . '/inc/template-functions.php';
require_once LEARNPRESS_PRO_THEME_DIR . '/inc/customizer.php';
