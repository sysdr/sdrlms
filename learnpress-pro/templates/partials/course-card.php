<?php
/**
 * Course Card Partial
 *
 * @package LearnPress_Pro
 */

$course_id = get_the_ID();
$price = get_post_meta($course_id, '_lp_course_price', true);
$duration = get_post_meta($course_id, '_lp_course_duration', true);
$students = get_post_meta($course_id, '_lp_course_students', true);
$rating = get_post_meta($course_id, '_lp_course_rating', true);
$is_free = get_post_meta($course_id, '_lp_course_is_free', true);
$difficulty = wp_get_post_terms($course_id, 'course_difficulty');
$instructor = learnpress_pro_get_course_instructor($course_id);
?>

<div class="course-card" data-course-id="<?php echo esc_attr($course_id); ?>">
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('course-thumbnail', array('class' => 'course-thumbnail')); ?>
        </a>
    <?php else : ?>
        <div class="course-thumbnail" style="background: var(--gradient-teal); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
            📚
        </div>
    <?php endif; ?>

    <div class="course-content">
        <div class="course-meta">
            <?php if (!empty($difficulty)) : ?>
                <span class="badge badge-difficulty"><?php echo esc_html($difficulty[0]->name); ?></span>
            <?php endif; ?>

            <?php if ($is_free == '1') : ?>
                <span class="badge badge-free"><?php _e('Free', 'learnpress-pro'); ?></span>
            <?php elseif ($price) : ?>
                <span class="badge badge-price">$<?php echo esc_html(number_format($price, 2)); ?></span>
            <?php endif; ?>

            <?php if ($duration) : ?>
                <span class="badge badge-duration"><?php echo esc_html($duration); ?> hrs</span>
            <?php endif; ?>
        </div>

        <h3 class="course-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <div class="course-description">
            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
        </div>

        <?php if ($instructor) : ?>
            <div class="course-instructor">
                <?php echo get_avatar($instructor->ID, 32, '', '', array('class' => 'instructor-avatar')); ?>
                <span class="instructor-name"><?php echo esc_html($instructor->display_name); ?></span>
            </div>
        <?php endif; ?>

        <div class="course-footer">
            <div class="course-rating">
                <?php if ($rating) : ?>
                    <span class="rating-stars">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $rating ? '★' : '☆';
                        }
                        ?>
                    </span>
                    <span class="rating-count">(<?php echo number_format($rating, 1); ?>)</span>
                <?php endif; ?>
            </div>

            <?php if ($students) : ?>
                <div class="course-students">
                    <span><?php echo number_format($students); ?> <?php _e('students', 'learnpress-pro'); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="width: 100%; margin-top: var(--spacing-md);">
            <?php _e('View Course', 'learnpress-pro'); ?>
        </a>
    </div>
</div>
