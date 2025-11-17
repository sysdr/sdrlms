/**
 * LearnPress Pro Main JavaScript
 *
 * @package LearnPress_Pro
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {

        // Mobile Menu Toggle
        $('.mobile-menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('active');
        });

        // User Menu Dropdown
        $('.user-profile-link').on('click', function(e) {
            e.preventDefault();
            $('.user-dropdown').toggleClass('active');
        });

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.user-menu-wrapper').length) {
                $('.user-dropdown').removeClass('active');
            }
        });

        // Course Carousel
        initCourseCarousel();

        // Course Filters
        initCourseFilters();

        // Course Enrollment
        initCourseEnrollment();

        // Smooth Scroll
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 600);
            }
        });

        // Newsletter Form
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            var email = $(this).find('input[type="email"]').val();

            // Add your newsletter subscription logic here
            alert('Thank you for subscribing with: ' + email);
            $(this).find('input[type="email"]').val('');
        });

        // Progress Bar Animation
        animateProgressBars();
    });

    /**
     * Initialize Course Carousel
     */
    function initCourseCarousel() {
        var carousel = $('.course-carousel');
        if (!carousel.length) return;

        var track = carousel.find('.carousel-track');
        var cards = track.find('.course-card');
        var dotsContainer = carousel.find('.carousel-dots');

        if (cards.length === 0) return;

        var currentIndex = 0;
        var cardsPerView = getCardsPerView();
        var totalSlides = Math.ceil(cards.length / cardsPerView);

        // Create dots
        for (var i = 0; i < totalSlides; i++) {
            dotsContainer.append('<button class="carousel-dot" data-index="' + i + '"></button>');
        }
        dotsContainer.find('.carousel-dot').first().addClass('active');

        // Update carousel position
        function updateCarousel(index) {
            currentIndex = index;
            var cardWidth = cards.first().outerWidth(true);
            var offset = -currentIndex * cardWidth * cardsPerView;
            track.css('transform', 'translateX(' + offset + 'px)');

            dotsContainer.find('.carousel-dot').removeClass('active');
            dotsContainer.find('.carousel-dot[data-index="' + currentIndex + '"]').addClass('active');
        }

        // Next button
        carousel.find('.carousel-next').on('click', function() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateCarousel(currentIndex);
        });

        // Previous button
        carousel.find('.carousel-prev').on('click', function() {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateCarousel(currentIndex);
        });

        // Dot navigation
        dotsContainer.on('click', '.carousel-dot', function() {
            var index = $(this).data('index');
            updateCarousel(index);
        });

        // Auto-play
        var autoplayInterval = setInterval(function() {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateCarousel(currentIndex);
        }, 5000);

        // Pause on hover
        carousel.on('mouseenter', function() {
            clearInterval(autoplayInterval);
        });

        carousel.on('mouseleave', function() {
            autoplayInterval = setInterval(function() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel(currentIndex);
            }, 5000);
        });

        // Responsive
        $(window).on('resize', function() {
            cardsPerView = getCardsPerView();
            totalSlides = Math.ceil(cards.length / cardsPerView);
            updateCarousel(0);
        });
    }

    /**
     * Get cards per view based on screen size
     */
    function getCardsPerView() {
        var width = $(window).width();
        if (width < 768) return 1;
        if (width < 1024) return 2;
        return 3;
    }

    /**
     * Initialize Course Filters
     */
    function initCourseFilters() {
        var filters = {
            category: $('#course-category-filter'),
            difficulty: $('#course-difficulty-filter'),
            price: $('#course-price-filter')
        };

        // Bind change events
        $.each(filters, function(key, filter) {
            filter.on('change', function() {
                filterCourses();
            });
        });

        function filterCourses() {
            var selectedCategory = filters.category.val();
            var selectedDifficulty = filters.difficulty.val();
            var selectedPrice = filters.price.val();

            $('.course-card').each(function() {
                var card = $(this);
                var show = true;

                // Filter by category
                if (selectedCategory) {
                    var categories = card.data('categories') || '';
                    if (categories.indexOf(selectedCategory) === -1) {
                        show = false;
                    }
                }

                // Filter by difficulty
                if (selectedDifficulty) {
                    var difficulty = card.find('.badge-difficulty').text().toLowerCase();
                    if (difficulty !== selectedDifficulty) {
                        show = false;
                    }
                }

                // Filter by price
                if (selectedPrice) {
                    var isFree = card.find('.badge-free').length > 0;
                    if (selectedPrice === 'free' && !isFree) {
                        show = false;
                    } else if (selectedPrice === 'paid' && isFree) {
                        show = false;
                    }
                }

                // Show or hide card
                if (show) {
                    card.fadeIn(300);
                } else {
                    card.fadeOut(300);
                }
            });
        }
    }

    /**
     * Initialize Course Enrollment
     */
    function initCourseEnrollment() {
        $('.enroll-course-btn').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            var courseId = button.data('course-id');

            // Disable button
            button.prop('disabled', true).text('Enrolling...');

            // AJAX request
            $.ajax({
                url: learnpressProAjax.ajax_url,
                type: 'POST',
                data: {
                    action: 'learnpress_enroll_course',
                    course_id: courseId,
                    nonce: learnpressProAjax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        button.text('Enrolled!').addClass('btn-success');

                        // Show success message
                        showNotification('success', response.data.message);

                        // Redirect to dashboard after 1 second
                        setTimeout(function() {
                            window.location.href = button.closest('.course-sidebar').find('.btn-primary').attr('href');
                        }, 1000);
                    } else {
                        button.prop('disabled', false).text('Enroll Now');
                        showNotification('error', response.data.message);
                    }
                },
                error: function() {
                    button.prop('disabled', false).text('Enroll Now');
                    showNotification('error', 'An error occurred. Please try again.');
                }
            });
        });
    }

    /**
     * Show Notification
     */
    function showNotification(type, message) {
        var notification = $('<div class="notification notification-' + type + '">' + message + '</div>');

        $('body').append(notification);

        setTimeout(function() {
            notification.addClass('show');
        }, 100);

        setTimeout(function() {
            notification.removeClass('show');
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }

    /**
     * Animate Progress Bars
     */
    function animateProgressBars() {
        $('.progress-fill').each(function() {
            var progressBar = $(this);
            var targetWidth = progressBar.css('width');

            progressBar.css('width', '0');

            setTimeout(function() {
                progressBar.css('width', targetWidth);
            }, 300);
        });
    }

    /**
     * Lazy Load Images
     */
    function lazyLoadImages() {
        var images = $('img[data-src]');

        images.each(function() {
            var img = $(this);
            var src = img.data('src');

            img.attr('src', src).removeAttr('data-src');
        });
    }

    // Window Load
    $(window).on('load', function() {
        lazyLoadImages();
    });

    // Scroll Events
    var lastScrollTop = 0;
    $(window).on('scroll', function() {
        var scrollTop = $(this).scrollTop();

        // Header scroll effect
        if (scrollTop > 100) {
            $('.site-header').addClass('scrolled');
        } else {
            $('.site-header').removeClass('scrolled');
        }

        lastScrollTop = scrollTop;
    });

})(jQuery);

// Add notification styles dynamically
(function() {
    var style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            font-weight: 600;
            z-index: 10000;
            opacity: 0;
            transform: translateX(100px);
            transition: all 0.3s ease;
        }
        .notification.show {
            opacity: 1;
            transform: translateX(0);
        }
        .notification-success {
            background: #10b981;
            color: white;
        }
        .notification-error {
            background: #ef4444;
            color: white;
        }
        .site-header.scrolled {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            min-width: 200px;
            margin-top: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .user-dropdown a {
            display: block;
            padding: 0.75rem 1rem;
            color: #374151;
            transition: background 0.2s;
        }
        .user-dropdown a:hover {
            background: #f3f4f6;
        }
        .user-menu-wrapper {
            position: relative;
        }
        @media (max-width: 768px) {
            .main-navigation {
                display: none;
            }
            .main-navigation.active {
                display: block;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            }
            .main-navigation ul {
                flex-direction: column;
            }
            .mobile-menu-toggle {
                display: block;
                background: none;
                border: none;
                cursor: pointer;
            }
            .mobile-menu-toggle span {
                display: block;
                width: 25px;
                height: 3px;
                background: #374151;
                margin: 5px 0;
                transition: 0.3s;
            }
        }
    `;
    document.head.appendChild(style);
})();
