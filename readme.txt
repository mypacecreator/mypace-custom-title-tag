=== mypace Custom Title Tag ===
Contributors: mypacecreator
Donate link: http://www.amazon.co.jp/registry/wishlist/33HK9YOKDESUO
Tags: SEO, title
Requires at least: 4.1
Tested up to: 4.4.2
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin allows you to edit title tag at every singular post(posts, pages, custom post types).
This is a very simple plugin.

= For Japanese User =
このプラグインを有効化すると、個別記事ページ（投稿、固定ページ、カスタム投稿タイプの記事）のタイトルタグを任意の文字列に書き換えることができます。
高機能なSEOプラグインは必要ないという方向けのシンプルなプラグインです。


== Installation ==

1. Upload `mypace Custom Title Tag` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Notice =

Your theme must use `add_theme_support( 'title-tag' );` in the functions.php file in order to support title tag.
No need to add anything to your theme’s header.php file, just remove the legacy wp_title() call or all hard-coded title tags.

* [Related: Title Tag « WordPress Codex](https://codex.wordpress.org/Title_Tag/) 

= For Japanese User =
このプラグインを使うには、お使いのテーマのfunctions.phpで `add_theme_support( 'title-tag' );` が定義されている必要があります。
タイトルタグの記述をheader.phpに書くことは現在推奨されていません。head内のwp_title()関数や、ハードコーディングされたタイトルタグは削除してください。


== Frequently Asked Questions ==

= This plugin output nothing. =

Your theme must use `add_theme_support( 'title-tag' );` in the functions.php file in order to support title tag.

= Title tags duplicated. =

No need to add anything to your theme’s header.php file, just remove the legacy wp_title() call or all hard-coded title tags.

* [Related: Title Tag « WordPress Codex](https://codex.wordpress.org/Title_Tag/) 

== Screenshots ==

1. Enter text into Title tag field.
2. Edited title tag.

== Changelog ==

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