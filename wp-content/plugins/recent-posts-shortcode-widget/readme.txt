=== Recent Posts Shortcode & Widget ===
Contributors: rajros
Donate link: https://rahul841984.wixsite.com/rajros
Tags: recent posts, latest posts, latest posts shortcode, posts, recent posts shortcode, recent posts widget, excerpt, widgets, shortcode, featured image, taxonomy, widget, sidebar, category, thumbnail, meta key, post tag, post type
Requires at least: 3.3
Tested up to: 4.9.4
Stable tag: 1.8
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


Display list of recent posts and latest posts or random posts using the [recentposts-sc] shortcode in any page or in sidebar widgets.


== Description ==
The "Recent Posts Shortcode & Widget" helps users to easily display latest posts in a page or in sidebar by just using simple shortcode [recentposts-sc] 
By default it displays "latest posts" or "recent posts" which can be changed to display "random posts", display by 'title' etc using 'orderby'.

= Options and Features Includes =

All Parameters/Shortcodes can be seen in FAQ: 
*  [FAQ](https://wordpress.org/plugins/recent-posts-shortcode-widget/faq/)

*  Featured Image
*  Auto generates and adds featured image using first image of the post if no featured image is found
*  Custom excerpt length
*  Limit number of posts
*  Posts from specific category
*  Posts from multiple categories (comma separated)
*  Posts from specific author
*  Post type option
*  Order/Display by date, name etc.
*  Display post date.
*  Display specific posts using post IDS (comma separated)
*  Display/filter posts by tag
*  Display/filter posts by meta key and meta values
*  Custom "Read more" label option.
*  Display default/custom image size instead of featured image (like thumbnail, medium etc)


= How to Use =

*  Basic: [recentposts-sc] (by default 3 latest posts)
*  For sidebar also use [recentposts-sc] in text widgets (refer screenshots as well for further help)

**Advanced Parameters:**

* **numberofposts (Number of posts)**
Limit/Specify the number of posts you want to display
Default: 3
Example: [recentposts-sc numberofposts="6"]


* **post_type (Post Type)** 
Specify which post type you want to use. For example posts or pages
Default type: post
Example: [recentposts-sc post_type="page"]


* **get_cat_name (Category Name)**
If you want to display category name in list of posts
Default: False
Example: [recentposts-sc get_cat_name="true"]


* **excerptlength (Custom Excerpt Length)**
Define custom excerpt length
Example: [recentposts-sc excerptlength="30"]


* **enable_excerpt (Show/hide Excerpt display)** 
Sometimes you may not want to display excerpt and only like to keep title and image. To turn off/disable excerpts use enable_excerpt="false" (default is true)
Example: [recentposts-sc enable_excerpt="false"]

* **image_size (Display default/custom image size instead of featured image)** 
Select image size like thumbnail, medium etc (by default featured image is displayed)
use image_size (default is false)
Example: [recentposts-sc image_size="thumbnail"] or [recentposts-sc image_size="medium"]
You can also use any custom image size if present in your website.


* **category (Posts from specific Category/categories)** 
Filter posts from single category or multiple categories
Example single category: [recentposts-sc category="lesson"]
Example multiple categories: [recentposts-sc category="lesson,lesson2,lesson3"]


* **author (Posts from specific author)** 
Filter posts from specific author
Example: [recentposts-sc author="admin"]


More Parameters/Shortcodes can be seen in FAQ: 
*  [FAQ](https://wordpress.org/plugins/recent-posts-shortcode-widget/faq/).

= Support =

*  [Forum support](https://wordpress.org/support/plugin/recent-posts-shortcode-widget)
*  [Rate/Review the plugin](http://wordpress.org/support/view/plugin-reviews/recent-posts-shortcode-widget)

> Developed by rajros


== Installation ==

= Automatic Installation =

1. Log in to WordPress admin panel and go to Plugins -> Add New
2. Type 'Recent Posts Shortcode & Widget' in the search box and click on search button.
3. From the search results find 'Recent Posts Shortcode & Widget' plugin.
4. Click on "Install Now"
5. Once installed click on "activate" button/link to activate the plugin.
6. Add the shortcode [recentposts-sc] to a page/post or in text widget for sidebar.

= Manual Installation =

1. Download the plugin from the wordpress plugin page.
2. Unzip the plugin and upload "recentpostssc" folder into your plugins directory.
4. Log in to WordPress admin panel and click the Plugins menu.
5. From the list of plugins on the plugin page find "Recent Posts Shortcode & Widget" plugin and then click to activate the plugin.
6. Add the shortcode [recentposts-sc] to a page/post or in text widget for sidebar.


== Frequently Asked Questions ==

*  Basic: [recentposts-sc] (by default 3 latest posts)
*  For sidebar also use [recentposts-sc] in text widgets (refer screenshots as well for further help)

* Advanced Parameters:

* **numberofposts (Number of posts)**
Limit/Specify the number of posts you want to display
Default: 3
Example: [recentposts-sc numberofposts="6"]


* **post_type (Post Type)** 
Specify which post type you want to use. For example posts or pages
Default type: post
Example: [recentposts-sc post_type="page"]


* **get_cat_name (Category Name)**
If you want to display category name in list of posts
Default: False
Example: [recentposts-sc get_cat_name="true"]


* **excerptlength (Custom Excerpt Length)**
Define custom excerpt length
Example: [recentposts-sc excerptlength="30"]


* **enable_excerpt (Show/hide Excerpt display)** 
Sometimes you may not want to display excerpt and only like to keep title and image. To turn off/disable excerpts use enable_excerpt="false" (default is true)
Example: [recentposts-sc enable_excerpt="false"]

* **image_size (Display default/custom image size instead of featured image)** 
Select image size like thumbnail, medium etc (by default featured image is displayed)
use image_size (default is false)
Example: [recentposts-sc image_size="thumbnail"] or [recentposts-sc image_size="medium"]
You can also use any custom image size if present in your website.


* **category (Posts from specific Category/categories)** 
Filter posts from single category or multiple categories
Example single category: [recentposts-sc category="lesson"]
Example multiple categories: [recentposts-sc category="lesson,lesson2,lesson3"]


* **author (Posts from specific author)** 
Filter posts from specific author
Example: [recentposts-sc author="admin"]


* **label (Custom label for "Read More")**
Apply your own custom read more label
Example: [recentposts-sc excerpt_more="true" label="Keep Reading..."]


* **after and before (Filter Posts between specific dates)** 
Example : [recentposts-sc after="January 5th, 2015"]
This will display only posts which is published after Januray 5th, 2015


Example : [recentposts-sc before="October 6th, 2015"]
This will display only posts which is published before Januray 5th, 2015

Example : [recentposts-sc after="January 5th, 2015" before="October 6th, 2015"]
This will display only posts which is published between Januray 5th, 2015 and October 6th, 2015


* **include_author (Display author name and link)** 
Example: [recentposts-sc include_author="true"]


* **orderby (Order posts by name, title, date etc)**
Example: [recentposts-sc orderby="name"]
Instead of recent posts you can display random posts
Example: [recentposts-sc orderby="rand"]


* **order (Order posts in ascending or descending order)**
Example: [recentposts-sc order="DSC"]


* **post_ids (List only specific posts by their IDs)**
Example: [recentposts-sc post_ids="181,189,194"]


* **offset (Offset/skip posts)** 
Example: [recentposts-sc offset="1"]


* **tag (Filter posts containing specific tags only)**
Example: [recentposts-sc tag="lesson1,lesson2,lesson"]


* **meta_key(Filter posts on meta_key)**
Example: [recentposts-sc meta_key="size"]


* **meta_value(Filter posts by meta values)**
Example: [recentposts-sc meta_value="small, medium"]

* **show_image(default is true. To hide images use false)**
Example: [show_image="false"]


* *  Combination of several parameters: * * 
[recentposts-sc numberofposts="7" post_type="post" get_cat_name="true" category="lesson" author="admin" excerpt_more="true" label="Read More..." after="January 5th, 2015" before="October 6th, 2015"  include_author="true" orderby="name" order="DSC"  excerptlength=30 post_ids="181,189,194" offset="0" tag="lesson1,lesson2,lesson" meta_key="size" meta_value="small, medium"]


== Screenshots ==

1. This displays list of posts on a page
2. This displays list of posts in sidebar/widgets
3. Basic shortcode to display posts
4. Shortcodes with multiple options/filter like category, date, excerpt length etc
5. For displaying in sidebar

== Changelog ==

**Version 1.8**
* Option to show/hide images using show_image. Tested upto wordpress version 4.9.4


**Version 1.7**
* Option to show/hide images using show_image. Tested upto wordpress version 4.9.1


**Version 1.6**

* Fixed some css issues while selecting thumbnail, medium images etc


**Version 1.5**

* Added feature to display default/custom image size instead of featured image (like thumbnail, medium etc)


**Version 1.4**

* Added feature to hide/show excerpt


**Version 1.3**

* Fixed issue with featured image


**Version 1.2**

* Fixed display issue in sidebar 


**Version 1.1**

* This version is first release of the plugin.