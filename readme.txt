=== Remove Admin Bar from Previews ===
Contributors: morganestes
Donate link: http://morganestes.com/donate
Tags: admin bar, editor, preview, posts
Requires at least: 3.8
Tested up to: 3.9.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Remove the admin bar from the preview of posts and pages, with optional reminder notification bar.

== Description ==

If you find yourself previewing a post, clicking the "edit" link at the top, previewing *that* post, and eventually realizing you have 3 or 4 tabs open with different versions of the same post? Then you've felt the pain of editing in WordPress.

But now there's hope! Simply remove the entire admin bar from your post previews and remove the temptation to edit a preview! Still need a reminder that you're on a preview and you need to go back and save your changes? No problem, we've thrown that feature in **for free**! Don't like it? No worries, simply check a box and preview your posts in all their life-like glory!

= Features =

* Remove the admin bar from post and page previews.
* Optionally add a reminder notification at the top of a previewed post.

== Installation ==

1. Download the `ZIP` file from the plugins repository.
1. Install using the Plugin Installer in your site's admin pages.
1. Update options under `Settings→Writing` admin page.

== Frequently Asked Questions ==

= How do I change the notice bar? =

If you have a stylesheet named `abp-preview-notice.css` in your theme directory, the plugin will automatically use that stylesheet for the notice bar.

You can also change the HTML of the notice bar by including it in your theme inside a file named `abp-notice-bar-template.php`.

Each of these files need to be in your theme root directory to work.

= I checked the "show notice bar" option but it's not there. =

You must also check the option to hide the admin bar. The notice bar will only show if it's enabled and the admin bar is turned off.

== Screenshots ==

1. Plugin options in the Writing options page.
2. Preview with the notice bar reminder.

== Changelog ==

= 0.2.0 =
* Added ability to override the notice bar HTML and CSS inside a theme.

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 0.2.0 =
This release adds the ability to customize the notice bar from within a theme.

== Roadmap ==

These features are planned for future releases:

* Customizable notification bar (styles and text).
* Multisite-enabled.
* Translation-capable.
