=== mypace Custom Title Tag ===
Contributors: mypacecreator, Toro_Unit
Donate link: http://www.amazon.co.jp/registry/wishlist/33HK9YOKDESUO
Tags: SEO, title
Requires at least: 4.1
Tested up to: 5.0
Stable tag: 1.2.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin allows you to edit title tag at every singular post(posts, pages, custom post types). This is a very simple plugin.


== Installation ==

1. Upload `mypace Custom Title Tag` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Notice =

You have to use `add_theme_support( 'title-tag' );` in the functions.php file in order to support title tag.
You don’t need to add anything to the theme's header.php file. Delete the legacy wp_title() call and all hard-coded title tags.

* [Related: Title Tag « WordPress Codex](https://codex.wordpress.org/Title_Tag/) 

== Frequently Asked Questions ==

= This plugin output nothing. =

You have to use `add_theme_support( 'title-tag' );` in the functions.php file in order to support title tag.

= Title tags duplicated. =

You don’t need to add anything to the theme's header.php file. Delete the legacy wp_title() call and all hard-coded title tags.

* [Related: Title Tag « WordPress Codex](https://codex.wordpress.org/Title_Tag/) 

== Screenshots ==

1. Enter text into a Title tag field.
2. Edited title tag.

== Changelog ==

= 1.2.3 =
* WordPress 4.8 Compatibility.
* WordPress Coding Standard Fix.

= 1.2.2 =
* GlotPress Compatibility.

= 1.2.1 =
* Fixed a problem with saving data on custom post types.

= 1.2 =
* WordPress 4.4 Compatibility.

= 1.1 =
* Changed width of the input field.

= 1.0 =
* Initial release.

== GitHub ==

https://github.com/mypacecreator/mypace-custom-title-tag