<?php
/**
 * Class Title_Test
 *
 * @package Mypace_Custom_Title_Tag
 */

/**
 * Sample test case.
 */
class Title_Test extends WP_UnitTestCase {

	/**
	 * Test for wp_get_document_title
	 *
	 * @test
	 */
	public function test_title() {

		new Mypace_Custom_Title_Tag();
		$post_id = $this->factory->post->create( array(
			'post_title' => 'Hello',
		) );

		update_post_meta( $post_id, 'mypace_title_tag', 'Mypace Title' );
		$this->go_to( get_permalink( $post_id ) );

		$this->assertEquals( 'MyPace Tittle', wp_get_document_title() );
	}

}
