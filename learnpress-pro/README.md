# LearnPress Pro - WordPress LMS Theme

A modern, feature-rich Learning Management System (LMS) WordPress theme inspired by industry-leading platforms like DeepLearning.AI and SystemDR.

## 🎯 Features

### Design & User Experience
- **Modern Gradient UI**: Eye-catching gradient backgrounds inspired by DeepLearning.AI
- **Clean Professional Design**: Professional tech aesthetic following SystemDR's design patterns
- **Fully Responsive**: Mobile-first design that works seamlessly on all devices
- **Smooth Animations**: Engaging transitions and hover effects
- **Accessible**: WCAG compliant with proper ARIA labels and semantic HTML

### Course Management
- **Custom Post Types**:
  - Courses (`lp_course`)
  - Lessons (`lp_lesson`)
  - Quizzes (`lp_quiz`)
- **Custom Taxonomies**:
  - Course Categories
  - Course Tags
  - Difficulty Levels (Beginner, Intermediate, Advanced)
- **Course Meta**:
  - Pricing (Free or Paid)
  - Duration
  - Student enrollment count
  - Ratings (1-5 stars)
  - Instructor information

### Student Features
- **Student Dashboard**: Personalized dashboard with progress tracking
- **Course Enrollment**: One-click enrollment system with AJAX
- **Progress Tracking**: Visual progress bars and completion status
- **My Courses**: Dedicated page for enrolled courses
- **Recommended Courses**: Smart course recommendations

### Interactive Elements
- **Course Carousel**: Auto-playing featured course slider with touch/swipe support
- **Advanced Filters**: Filter courses by category, difficulty, and price
- **Real-time Search**: Instant course filtering
- **Rating System**: 5-star rating display for courses
- **Social Proof**: Display student enrollment numbers

### User Roles
- **Student**: Basic user role for course enrollment
- **Instructor**: Create and manage courses
- **Administrator**: Full system access

### Additional Features
- **Custom Menus**: Multiple menu locations (Primary, Footer, User Dashboard)
- **Widget Areas**: Customizable sidebar areas
- **Theme Customizer**: Easy customization through WordPress Customizer
  - Custom colors (Primary & Secondary)
  - Hero section text
  - Social proof messaging
  - Course display settings
- **Newsletter Integration**: Built-in newsletter subscription form
- **Custom Database Tables**: Progress tracking with dedicated database tables

## 📋 Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

## 🚀 Installation

### Method 1: Direct Upload

1. Download the theme files
2. Navigate to **WordPress Admin > Appearance > Themes**
3. Click **Add New > Upload Theme**
4. Choose the `learnpress-pro.zip` file
5. Click **Install Now**
6. After installation, click **Activate**

### Method 2: FTP Upload

1. Extract the theme files
2. Upload the `learnpress-pro` folder to `/wp-content/themes/`
3. Navigate to **WordPress Admin > Appearance > Themes**
4. Find **LearnPress Pro** and click **Activate**

## ⚙️ Setup & Configuration

### Initial Setup

1. **Set Up Menus**:
   - Go to **Appearance > Menus**
   - Create menus for Primary, Footer, and User Dashboard locations

2. **Create Pages**:
   - Create a new page titled "Dashboard"
   - Set Template to "Student Dashboard"
   - Create a "My Courses" page
   - Create a "Courses" page and set it as the course archive

3. **Configure Permalinks**:
   - Go to **Settings > Permalinks**
   - Select "Post name" or "Custom Structure"
   - Click **Save Changes**

4. **Customize Your Site**:
   - Go to **Appearance > Customize**
   - Navigate to **LMS Settings** section
   - Customize colors, hero text, and other settings

### Creating Your First Course

1. Navigate to **Courses > Add New**
2. Add course title and description
3. Set featured image (recommended size: 800x400px)
4. Fill in **Course Details**:
   - Price (or mark as free)
   - Duration in hours
   - Number of students
   - Rating (0-5)
5. Assign categories, tags, and difficulty level
6. Publish the course

### Creating Lessons

1. Navigate to **Lessons > Add New**
2. Add lesson title and content
3. Associate with a course using the course selector
4. Publish the lesson

## 🎨 Customization

### Color Scheme

The theme uses CSS custom properties (variables) for easy customization:

```css
:root {
    --primary-blue: #0056d2;
    --primary-blue-dark: #1a73e8;
    --success-green: #10b981;
    --warning-orange: #f59e0b;
    --danger-red: #ef4444;
}
```

### Typography

Default fonts:
- **Body**: Source Sans Pro
- **Headings**: Google Sans
- **Code**: Fira Code

To change fonts, modify the CSS variables in `style.css`:

```css
:root {
    --font-primary: 'Your Font', sans-serif;
    --font-heading: 'Your Heading Font', sans-serif;
}
```

### WordPress Customizer Options

Access via **Appearance > Customize > LMS Settings**:

- **Hero Title**: Main heading on homepage
- **Hero Subtitle**: Subheading text
- **Social Proof Text**: Student count messaging
- **Primary Color**: Main brand color
- **Secondary Color**: Accent color
- **Footer Copyright**: Copyright text
- **Enable Course Ratings**: Toggle rating display
- **Courses Per Page**: Number of courses to display

## 📁 File Structure

```
learnpress-pro/
├── assets/
│   ├── css/
│   ├── js/
│   │   └── main.js
│   └── images/
├── inc/
│   ├── customizer.php
│   └── template-functions.php
├── templates/
│   ├── courses/
│   ├── dashboard/
│   └── partials/
│       └── course-card.php
├── archive-lp_course.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page-dashboard.php
├── single-lp_course.php
├── style.css
└── README.md
```

## 🔌 Recommended Plugins

While LearnPress Pro works standalone, these plugins enhance functionality:

- **Contact Form 7**: For contact forms
- **Yoast SEO**: For SEO optimization
- **WP Mail SMTP**: For reliable email delivery
- **UpdraftPlus**: For backups
- **Wordfence Security**: For security

## 💻 Development

### Custom Post Types

**Courses:**
```php
register_post_type('lp_course', [...]);
```

**Lessons:**
```php
register_post_type('lp_lesson', [...]);
```

**Quizzes:**
```php
register_post_type('lp_quiz', [...]);
```

### Helper Functions

**Check enrollment:**
```php
learnpress_pro_is_enrolled($course_id, $user_id);
```

**Get course instructor:**
```php
learnpress_pro_get_course_instructor($course_id);
```

**Get course progress:**
```php
learnpress_pro_get_course_progress($user_id, $course_id);
```

### Hooks & Filters

**Modify excerpt length:**
```php
add_filter('excerpt_length', 'your_custom_excerpt_length');
```

**Add custom body classes:**
```php
add_filter('body_class', 'your_custom_body_classes');
```

## 🌐 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📱 Responsive Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## 🔒 Security Features

- Nonce verification for all AJAX requests
- Data sanitization and validation
- Escaped output
- Prepared SQL statements
- User capability checks

## 🐛 Troubleshooting

### Courses not displaying

1. Check permalinks: **Settings > Permalinks > Save Changes**
2. Ensure courses are published
3. Clear browser cache

### Enrollment not working

1. Ensure user is logged in
2. Check AJAX URL in browser console
3. Verify nonce is valid

### Styles not loading

1. Clear WordPress cache
2. Hard refresh browser (Ctrl+F5)
3. Check file permissions

## 📄 License

This theme is licensed under the GNU General Public License v2 or later.

## 🤝 Support

For support, please:
1. Check the documentation above
2. Review WordPress.org forums
3. Contact theme support

## 🎉 Credits

- **Design Inspiration**: DeepLearning.AI, SystemDR
- **Fonts**: Google Fonts (Source Sans Pro, Fira Code)
- **Icons**: Unicode emoji

## 📝 Changelog

### Version 1.0.0 (2025-01-XX)
- Initial release
- Course management system
- Student dashboard
- Progress tracking
- Responsive design
- AJAX enrollment
- Course filtering
- Rating system
- User roles (Student, Instructor)
- Theme customizer integration

## 🚧 Roadmap

Future enhancements:
- [ ] Quiz functionality
- [ ] Certificate generation
- [ ] Course reviews and comments
- [ ] Video player integration
- [ ] Payment gateway integration
- [ ] Advanced analytics
- [ ] Mobile app integration
- [ ] Gamification features
- [ ] Forum integration
- [ ] Live class support

---

**Made with ❤️ for WordPress educators and learners worldwide**
