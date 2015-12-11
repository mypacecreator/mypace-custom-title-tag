<?php
/*
Plugin Name: mypace Custom Title Tag
Plugin URI: https://github.com/mypacecreator/mypace-custom-title-tag
Description: This plugin allows you to edit title tag at every singular post(posts, pages, custom post types). This is a very simple plugin.
Version: 1.2
Author: Kei Nomura (mypacecreator)
Author URI: http://mypacecreator.net/
Text Domain: mypace-custom-title-tag
Domain Path: /languages
*/

if ( !class_exists( 'Mypace_Custom_Title_Tag' ) ){

	class Mypace_Custom_Title_Tag{

		public function __construct() {
			//Actions and Filters
			$wp_version = get_bloginfo( 'version' );
			if ( $wp_version >= '4.4' ) {
				add_filter( 'pre_get_document_title',        array( $this, 'custom_title' ) );
			} else { // if ( $wp_version < '4.3.x' )
				add_filter( 'wp_title',                      array( $this, 'custom_title' ) );
			}
			add_action( 'admin_menu',                      array( $this, 'add_meta_box' ) );
			add_action( 'save_post',                       array( $this, 'save_titledata' ) );
			add_action( 'admin_print_styles-post.php',     array( $this, 'title_meta_box_styles' ) );
			add_action( 'admin_print_styles-post-new.php', array( $this, 'title_meta_box_styles' ) );
			load_plugin_textdomain( 'mypace-custom-title-tag', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		//make a meta box
		public function add_meta_box(){
			$post_types = wp_list_filter(
					get_post_types(array('public' => true)),
					array('attachment'),
					'NOT'
			);
			foreach ( $post_types as $post_type ){
				add_meta_box(
					'mypace-title-tag',
					esc_html__( 'Title Tag', 'mypace-custom-title-tag' ),
					array( $this, 'title_meta_box' ),
					$post_type,
					'advanced'
				);
			}
		}

		public function title_meta_box(){
			//input form
			wp_nonce_field( plugin_basename(__FILE__), 'mypace_noncename' );
			$field_name = 'mypace_title_tag';
			$field_value = get_post_meta( get_the_ID(), $field_name, true );

			printf(
				'<label for="%s">%s</label><br />',
				esc_attr($field_name),
				esc_html__( "Enter title-tag text.", 'mypace-custom-title-tag' )
			);
			printf(
				'<input type="text" name="%s" value="%s" size="60" id="%s" />',
				esc_attr($field_name),
				esc_attr($field_value),
				esc_attr($field_name)
			);
	}

		public function title_meta_box_styles() {
		?>
		<style type="text/css" charset="utf-8">
			#mypace_title_tag {
				width: 98%;
			}
		</style>
		<?php
		}

		public function save_titledata($post_id){

			//permission check and save data
			if ( !isset($_POST['mypace_noncename']) ){
				return $post_id;
			}
			if ( !wp_verify_nonce( $_POST['mypace_noncename'], plugin_basename(__FILE__) ) ){
				return $post_id;
			}
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
				return $post_id;
			}

			$post_type = isset( $_POST['post_type'] ) ? $_POST['post_type'] : '';
			$post_types = wp_list_filter(
					get_post_types(array('public' => true)),
					array('attachment'),
					'NOT'
			);
			if ( in_array($post_type, $post_types) ){
				if ( !current_user_can( 'edit_' . $post_type, $post_id ) ){
					return $post_id;
				}
			} else {
				return $post_id;
			}

			$mydata = isset($_POST['mypace_title_tag']) ? $_POST['mypace_title_tag'] : '';
			if ( !empty($mydata) ){
				update_post_meta( $post_id, 'mypace_title_tag', $mydata );
			} else {
				delete_post_meta( $post_id, 'mypace_title_tag' );
			}
			return $mydata;
		}

		//output title tag
		public function custom_title( $title ){
			if( is_singular() ){
				$post_id = get_the_ID();
				$my_title = get_post_meta( $post_id, 'mypace_title_tag', true );
				if( $my_title ){
					return esc_html( $my_title );
				}
			}
			return $title;
		}

	}

	new Mypace_Custom_Title_Tag();

}