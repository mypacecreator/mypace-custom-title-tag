<?php
/**
 * Plugin Name: mypace Custom Title Tag
 * Plugin URI: https://github.com/mypacecreator/mypace-custom-title-tag
 * Description: This plugin allows you to edit title tag at every singular post(posts, pages, custom post types). This is a very simple plugin.
 * Version: 1.2.2
 * Author: Kei Nomura (mypacecreator)
 * Author URI: http://mypacecreator.net/
 * Text Domain: mypace-custom-title-tag
 * Domain Path: /languages
 *
 * @package Mypace_Custom_Title_Tag
 */

if ( ! class_exists( 'Mypace_Custom_Title_Tag' ) ) {
	/**
	 * Class Mypace_Custom_Title_Tag
	 */
	class Mypace_Custom_Title_Tag {

		/**
		 * Mypace_Custom_Title_Tag constructor.
		 *
		 * Register actions and filters.
		 */
		public function __construct() {
			global $wp_version;
			if ( version_compare( $wp_version, '4.4', '>=' ) ) {
				add_filter( 'pre_get_document_title',        array( $this, 'custom_title' ) );
			} else { // if ( $wp_version < '4.3.x' ).
				add_filter( 'wp_title',                      array( $this, 'custom_title' ) );
			}
			add_action( 'admin_menu',                      array( $this, 'add_meta_box' ) );
			add_action( 'save_post',                       array( $this, 'save_titledata' ) );
			add_action( 'admin_print_styles-post.php',     array( $this, 'title_meta_box_styles' ) );
			add_action( 'admin_print_styles-post-new.php', array( $this, 'title_meta_box_styles' ) );
			load_plugin_textdomain( 'mypace-custom-title-tag' );
		}

		/**
		 * Make a meta box
		 */
		public function add_meta_box() {
			$post_types = wp_list_filter(
				get_post_types( array( 'public' => true ) ),
				array( 'attachment' ),
				'NOT'
			);
			foreach ( $post_types as $post_type ) {
				add_meta_box(
					'mypace-title-tag',
					esc_html__( 'Title Tag', 'mypace-custom-title-tag' ),
					array( $this, 'title_meta_box' ),
					$post_type,
					'advanced'
				);
			}
		}

		/**
		 * Custom title metabox for input form
		 */
		public function title_meta_box() {
			wp_nonce_field( plugin_basename( __FILE__ ), 'mypace_noncename' );
			$field_name = 'mypace_title_tag';
			$field_value = get_post_meta( get_the_ID(), $field_name, true );

			printf(
				'<label for="%s">%s</label><br />',
				esc_attr( $field_name ),
				esc_html__( 'Enter title-tag text.', 'mypace-custom-title-tag' )
			);
			printf(
				'<input type="text" name="%s" value="%s" size="60" id="%s" />',
				esc_attr( $field_name ),
				esc_attr( $field_value ),
				esc_attr( $field_name )
			);
		}

		/**
		 * Custom title metabox style.
		 */
		public function title_meta_box_styles() {
		?>
		<style type="text/css" charset="utf-8">
			#mypace_title_tag {
				width: 98%;
			}
		</style>
		<?php
		}

		/**
		 * Save Setting.
		 *
		 * @param int $post_id postID on save.
		 *
		 * @return string|void
		 */
		public function save_titledata( $post_id ) {

			// permission check and save data
			// Check if our nonce is set.
			if ( ! isset( $_POST['mypace_noncename'] ) ) {
				return;
			}
			// Verify that the nonce is valid.
			if ( ! wp_verify_nonce( $_POST['mypace_noncename'], plugin_basename( __FILE__ ) ) ) {
				return;
			}
			// If this is an autosave, our form has not been submitted, so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			// Check the user's permissions.
			if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return;
				}
			}

			$mydata = isset( $_POST['mypace_title_tag'] ) ? $_POST['mypace_title_tag'] : '';
			if ( ! empty( $mydata ) ) {
				update_post_meta( $post_id, 'mypace_title_tag', $mydata );
			} else {
				delete_post_meta( $post_id, 'mypace_title_tag' );
			}
			return $mydata;
		}

		/**
		 * Title filter.
		 *
		 * @param string $title title for title tag.
		 *
		 * @return string
		 */
		public function custom_title( $title ) {
			if ( is_singular() ) {
				$post_id = get_the_ID();
				$my_title = get_post_meta( $post_id, 'mypace_title_tag', true );
				if ( $my_title ) {
					return esc_html( $my_title );
				}
			}
			return $title;
		}

	}

	new Mypace_Custom_Title_Tag();

}
