# LearnPress Pro - Installation Guide

This guide will walk you through installing and setting up the LearnPress Pro WordPress theme.

## Prerequisites

Before you begin, ensure you have:

- ✅ WordPress 6.0 or higher installed
- ✅ PHP 7.4 or higher
- ✅ MySQL 5.6 or higher
- ✅ Administrator access to your WordPress site
- ✅ Basic knowledge of WordPress administration

## Step-by-Step Installation

### Step 1: Download the Theme

1. Download the `learnpress-pro` theme folder
2. If downloaded as a ZIP file, keep it zipped for WordPress upload method
3. If you have the folder, you can use FTP method

### Step 2: Install the Theme

#### Option A: WordPress Admin Upload (Recommended for beginners)

1. Log in to your WordPress admin panel
2. Navigate to **Appearance → Themes**
3. Click the **Add New** button at the top
4. Click **Upload Theme**
5. Click **Choose File** and select the `learnpress-pro.zip` file
6. Click **Install Now**
7. Wait for the installation to complete
8. Click **Activate** to activate the theme

#### Option B: FTP Upload (For advanced users)

1. Unzip the `learnpress-pro.zip` file on your computer
2. Connect to your server via FTP (using FileZilla, Cyberduck, or similar)
3. Navigate to `/wp-content/themes/` directory
4. Upload the entire `learnpress-pro` folder
5. Go to **WordPress Admin → Appearance → Themes**
6. Find LearnPress Pro and click **Activate**

### Step 3: Configure Permalinks

**Important:** This step is crucial for custom post types to work properly.

1. Go to **Settings → Permalinks**
2. Select **Post name** (recommended) or **Custom Structure**
3. Click **Save Changes**
4. Visit your site to ensure pages load correctly

### Step 4: Create Required Pages

Create these essential pages for your LMS:

#### Dashboard Page
1. Go to **Pages → Add New**
2. Title: "Dashboard" or "Student Dashboard"
3. In **Page Attributes** box, select **Template: Student Dashboard**
4. Publish the page

#### Courses Page
1. Go to **Pages → Add New**
2. Title: "Courses"
3. Leave as default template
4. Publish the page
5. Optional: Go to **Settings → Reading** and set this as your posts page for courses

#### My Courses Page
1. Go to **Pages → Add New**
2. Title: "My Courses"
3. Publish the page

### Step 5: Set Up Navigation Menus

1. Go to **Appearance → Menus**
2. Click **create a new menu**
3. Name it "Primary Menu"
4. Add the following pages:
   - Home
   - Courses
   - Dashboard (for logged-in users)
   - About
   - Contact
5. Under **Menu Settings**, check **Primary Menu**
6. Click **Save Menu**

Create a second menu for the footer:
1. Click **create a new menu**
2. Name it "Footer Menu"
3. Add pages like:
   - About
   - Contact
   - Privacy Policy
   - Terms of Service
4. Under **Menu Settings**, check **Footer Menu**
5. Click **Save Menu**

### Step 6: Customize Your Site

1. Go to **Appearance → Customize**
2. Navigate to **LMS Settings** section
3. Configure:
   - **Hero Title**: Your main headline
   - **Hero Subtitle**: Supporting text
   - **Social Proof Text**: e.g., "Join over 10,000 learners"
   - **Primary Color**: Your brand color
   - **Secondary Color**: Accent color
   - **Enable Course Ratings**: Toggle on/off
   - **Courses Per Page**: Number of courses to display (default: 12)
4. Click **Publish** to save changes

### Step 7: Set Up Your Site Identity

1. In Customizer, go to **Site Identity**
2. Upload your **Site Icon** (favicon) - 512x512px recommended
3. Upload your **Logo** - 200x60px recommended
4. Click **Publish**

### Step 8: Create Your First Course

1. Go to **Courses → Add New**
2. Enter course title (e.g., "Introduction to Web Development")
3. Add course description in the editor
4. Set a **Featured Image** (800x400px recommended)
5. Scroll down to **Course Details** meta box:
   - **Price**: Enter price or mark as Free
   - **Duration**: Hours of content (e.g., 10)
   - **Number of Students**: Starting number (e.g., 0)
   - **Rating**: Initial rating 0-5 (e.g., 4.5)
6. On the right sidebar:
   - Select **Course Category**
   - Add **Course Tags**
   - Select **Difficulty Level**
7. Click **Publish**

### Step 9: Create Course Categories

1. Go to **Courses → Course Categories**
2. Create categories like:
   - Web Development
   - Data Science
   - Business
   - Design
   - Marketing
3. Add description and save

### Step 10: Create Difficulty Levels

1. Go to **Courses → Difficulty Levels**
2. Add these levels:
   - Beginner
   - Intermediate
   - Advanced
3. Save each one

### Step 11: Add Lessons to Your Course

1. Go to **Lessons → Add New**
2. Enter lesson title (e.g., "Introduction to HTML")
3. Add lesson content
4. Set a featured image (optional)
5. Publish the lesson

*Note: For full lesson-course association, you may need to add custom fields or use a plugin*

### Step 12: Test User Registration

1. If not already enabled, go to **Settings → General**
2. Check **Anyone can register**
3. Set **New User Default Role** to "Student" (if available) or "Subscriber"
4. Save changes
5. Test registration flow by creating a test account

### Step 13: Create Test Enrollment

1. Log in as a test student
2. Navigate to a course
3. Click **Enroll Now**
4. Verify enrollment works
5. Check Dashboard to see enrolled course

## Post-Installation Configuration

### Recommended Settings

#### WordPress Settings

**General Settings** (Settings → General)
- Site Title: Your LMS name
- Tagline: Your LMS description
- WordPress Address & Site Address: Verify correct URLs
- Email Address: Your admin email

**Reading Settings** (Settings → Reading)
- Your homepage displays: Select "A static page"
- Homepage: Select your home/landing page
- Posts page: Can leave blank or select Courses page

**Discussion Settings** (Settings → Discussion)
- Configure comment settings as preferred
- Consider enabling comments for courses for Q&A

### Security Recommendations

1. Install a security plugin (Wordfence, iThemes Security)
2. Enable SSL certificate (HTTPS)
3. Use strong passwords
4. Regular backups (UpdraftPlus, BackupBuddy)
5. Keep WordPress and theme updated

### Performance Optimization

1. Install a caching plugin (WP Super Cache, W3 Total Cache)
2. Optimize images (Smush, ShortPixel)
3. Use a CDN (Cloudflare, StackPath)
4. Enable GZIP compression
5. Minimize plugins

### SEO Setup

1. Install Yoast SEO or Rank Math
2. Submit sitemap to Google Search Console
3. Configure meta descriptions
4. Set up Google Analytics

## Troubleshooting

### Common Issues

**Issue: Courses not showing**
- Solution: Go to Settings → Permalinks → Save Changes (flush permalinks)

**Issue: Enrollment button doesn't work**
- Solution: Ensure user is logged in, check browser console for errors

**Issue: Styles broken or not loading**
- Solution: Clear cache, hard refresh (Ctrl+F5), check file permissions

**Issue: 404 errors on course pages**
- Solution: Re-save permalinks, ensure theme is activated

**Issue: Dashboard page is blank**
- Solution: Ensure you selected the "Student Dashboard" template

**Issue: Images not displaying**
- Solution: Check file permissions on uploads folder, regenerate thumbnails

### Getting Help

If you encounter issues:

1. Check the [README.md](README.md) file
2. Review WordPress debug log (enable WP_DEBUG)
3. Disable plugins one by one to check conflicts
4. Switch to default WordPress theme to isolate issue
5. Check server error logs
6. Contact support with detailed error information

## Next Steps

After installation, consider:

1. **Content Creation**
   - Add more courses
   - Create course curriculum
   - Add instructor profiles

2. **Customization**
   - Customize colors to match brand
   - Add custom CSS if needed
   - Create child theme for advanced modifications

3. **Integration**
   - Connect email marketing (Mailchimp, ConvertKit)
   - Add payment gateway (for paid courses)
   - Connect analytics tools

4. **Marketing**
   - Set up SEO
   - Create landing pages
   - Add lead magnets
   - Implement email sequences

## Resources

- [WordPress Codex](https://codex.wordpress.org/)
- [WordPress Support Forums](https://wordpress.org/support/)
- Theme Documentation: README.md

## Maintenance

### Regular Tasks

**Weekly:**
- Review new user registrations
- Check for spam comments
- Monitor site performance

**Monthly:**
- Update WordPress core
- Update plugins
- Review analytics
- Backup database

**Quarterly:**
- Review and update content
- Check broken links
- Optimize database
- Review security logs

---

**Congratulations!** Your LearnPress Pro LMS is now set up and ready to use. Start creating courses and building your learning platform! 🎉
