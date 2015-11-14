<?php
/*
Plugin Name: mypace Custom Title Tag
Plugin URI: https://github.com/mypacecreator/mypace-custom-title-tag
Description: This plugin allows you to edit title tag at every singular post(posts, pages, custom post types). This is a very sinple plugin.
Version: 1.0
Author: Kei Nomura (mypacecreator)
Author URI: http://mypacecreator.net/
Text Domain: mypace-custom-title-tag
Domain Path: /language
*/

if ( !function_exists( 'mypace_add_meta_box' ) ){
	//make a meta box
	function mypace_add_meta_box(){
		$post_types = wp_list_filter(
				get_post_types(array('public' => true)),
				array('attachment'),
				'NOT'
		);
		foreach ( $post_types as $post_type ){
			add_meta_box(
				'mypace_sectionid',
				__( 'Title Tag', 'mypace-custom-title-tag' ),
				'mypace_title_meta_box',
				$post_type,
				'advanced'
			);
		}
	}
}

if ( !function_exists( 'mypace_title_meta_box' ) ){
	function mypace_title_meta_box(){
		//input form
		wp_nonce_field( plugin_basename(__FILE__), 'mypace_noncename' );
		$field_name = 'mypace_title_tag';
		$field_value = get_post_meta( get_the_ID(), $field_name, true );

		printf(
			'<label for="%s">%s</label><br />',
			esc_attr($field_name),
			__( "Enter title-tag text.", 'mypace-custom-title-tag' )
		);
		printf(
			'<input type="text" name="%s" value="%s" size="40" />',
			esc_attr($field_name),
			esc_attr($field_value)
		);
	}
}

if ( !function_exists( 'mypace_save_titledata' ) ){
	function mypace_save_titledata($post_id){

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
}

if ( !function_exists( 'mypace_custom_title' ) ){
	//output title tag
	function mypace_custom_title( $title ){
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

add_action( 'admin_menu', 'mypace_add_meta_box' );
add_action( 'save_post',  'mypace_save_titledata' );
add_filter( 'wp_title',   'mypace_custom_title' );
