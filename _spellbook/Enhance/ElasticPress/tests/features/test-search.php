<?php

class EPTestSearchFeature extends EP_Test_Base {

	/**
	 * Setup each test.
	 *
	 * @since 2.1
	 */
	public function setUp() {
		global $wpdb;
		parent::setUp();
		$wpdb->suppress_errors();

		$admin_id = $this->factory->user->create( array( 'role' => 'administrator' ) );

		wp_set_current_user( $admin_id );

		ep_delete_index();
		ep_put_mapping();

		EP_WP_Query_Integration::factory()->setup();
		EP_Sync_Manager::factory()->setup();
		EP_Sync_Manager::factory()->sync_post_queue = array();

		$this->setup_test_post_type();
	}

	/**
	 * Clean up after each test. Reset our mocks
	 *
	 * @since 2.1
	 */
	public function tearDown() {
		parent::tearDown();

		//make sure no one attached to this
		remove_filter( 'ep_sync_terms_allow_hierarchy', array( $this, 'ep_allow_multiple_level_terms_sync' ), 100 );
		$this->fired_actions = array();
	}

	/**
	 * Test that search is on
	 *
	 * @since 2.1
	 * @group search
	 */
	public function testSearchOn() {
		ep_activate_feature( 'search' );
		EP_Features::factory()->setup_features();

		// Need to call this since it's hooked to init
		ep_search_setup();

		$post_ids = array();

		ep_create_and_sync_post();
		ep_create_and_sync_post();
		ep_create_and_sync_post( array( 'post_content' => 'findme' ) );

		ep_refresh_index();

		add_action( 'ep_wp_query_search', array( $this, 'action_wp_query_search' ), 10, 0 );

		$args = array(
			's' => 'findme',
		);

		$query = new WP_Query( $args );

		$this->assertTrue( ! empty( $this->fired_actions['ep_wp_query_search'] ) );
	}

	/**
	 * Test case for when index is deleted, request for Elasticsearch should fall back to WP Query
	 *
	 * @group search
	 */
	public function testSearchIndexDeleted(){
		global $wpdb;

		ep_activate_feature( 'search' );
		EP_Features::factory()->setup_features();

		// Need to call this since it's hooked to init
		ep_search_setup();

		$post_ids = array();

		ep_create_and_sync_post();
		ep_create_and_sync_post();
		ep_create_and_sync_post( array( 'post_content' => 'findme' ) );

		ep_refresh_index();

		add_action( 'ep_wp_query_search', array( $this, 'action_wp_query_search' ), 10, 0 );

		$args = array(
			's' => 'findme',
		);

		$query = new WP_Query( $args );

		$this->assertTrue( "SELECT * FROM {$wpdb->posts} WHERE 1=0" == $query->request );

		ep_delete_index();

		$query = new WP_Query( $args );

		$this->assertTrue( "SELECT * FROM {$wpdb->posts} WHERE 1=0" != $query->request );
	}

	/**
	 * Test if decaying is enabled.
	 *
	 * @since 2.4
	 * @group search
	 */
	public function testDecayingEnabled() {
		ep_activate_feature( 'search' );
		EP_Features::factory()->setup_features();

		// Need to call this since it's hooked to init
		ep_search_setup();

		ep_update_feature( 'search', array(
			'active'           => true,
			'decaying_enabled' => true,
		) );

		ep_create_and_sync_post( array( 'post_content' => 'findme test 1', 'tags_input' => array( 'one', 'two' ) ) );
		ep_refresh_index();

		add_filter( 'ep_formatted_args', array( $this, 'catch_ep_formatted_args' ) );
		$query = new WP_Query( array(
			's' => 'test',
		) );

		$this->assertTrue( isset( $this->fired_actions['ep_formatted_args'] ) );
		$this->assertTrue( isset(
			$this->fired_actions['ep_formatted_args']['query'],
			$this->fired_actions['ep_formatted_args']['query']['function_score'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp']['post_date_gmt'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp']['post_date_gmt']['scale'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp']['post_date_gmt']['decay'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp']['post_date_gmt']['offset']
		) );
	}

	/**
	 * Test if decaying is disabled.
	 *
	 * @since 2.4
	 * @group search
	 */
	public function testDecayingDisabled() {
		ep_activate_feature( 'search' );
		EP_Features::factory()->setup_features();

		// Need to call this since it's hooked to init
		ep_search_setup();

		ep_update_feature( 'search', array(
			'active'           => true,
			'decaying_enabled' => false,
		) );

		ep_create_and_sync_post( array( 'post_content' => 'findme test 1', 'tags_input' => array( 'one', 'two' ) ) );
		ep_refresh_index();

		add_filter( 'ep_formatted_args', array( $this, 'catch_ep_formatted_args' ) );
		$query = new WP_Query( array(
			's' => 'test',
		) );
		$this->assertTrue( isset( $this->fired_actions['ep_formatted_args'] ) );
		$this->assertTrue( ! isset(
			$this->fired_actions['ep_formatted_args']['query']['function_score'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp']['post_date_gmt'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp']['post_date_gmt']['scale'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp']['post_date_gmt']['decay'],
			$this->fired_actions['ep_formatted_args']['query']['function_score']['exp']['post_date_gmt']['offset']
		) );
		$this->assertTrue( isset(
			$this->fired_actions['ep_formatted_args']['query']['bool'],
			$this->fired_actions['ep_formatted_args']['query']['bool']['should']
		) );
	}

	/**
	 * Catch ES query args.
	 *
	 * @group search
	 * @param array $args ES query args.
	 */
	public function catch_ep_formatted_args( $args ) {
		$this->fired_actions['ep_formatted_args'] = $args;
	}
}
