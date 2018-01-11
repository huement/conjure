<?php
  error_reporting(E_ALL); 
  ini_set('display_errors', 1);
  ini_set('log_errors', 1);
  ini_set("error_log", "../../../log/WPTest_errors.php"); 

  /**
   * Include Composer Autoloader
   */
  require_once '../vendor/autoload.php';
  
  WP_Mock::setUsePatchwork( true );
  WP_Mock::bootstrap();
  
  /**
   * Now we include any plugin files that we need to be able to run the tests. This
   * should be files that define the functions and classes you're going to test.
   */
  require_once __DIR__ . '/plugin_test.php';
  
  class WPTest extends \WP_Mock\Tools\TestCase {
    
    /**
     * Required setup function
     */
  	public function setUp() {
  		\WP_Mock::setUp();
  	}

    /**
     * Required exit function
     */
  	public function tearDown() {
  		\WP_Mock::tearDown();
  	}
    
    /**
  	 * Assume that my_permalink_function() is meant to do all of the following:
  	 * - Run the given post ID through absint()
  	 * - Call get_permalink() on the $post_id
  	 * - Pass the permalink through the 'special_filter' filter
  	 * - Trigger the 'special_action' WordPress action
  	 */
  	public function test_my_permalink_function() {
  		\WP_Mock::userFunction( 'get_permalink', array(
  			'args' => 42,
  			'times' => 1,
  			'return' => 'http://example.com/foo'
  		) );

  		\WP_Mock::passthruFunction( 'absint', array( 'times' => 1 ) );

  		\WP_Mock::onFilter( 'special_filter' )
  			->with( 'http://example.com/foo' )
  			->reply( 'https://example.com/bar' );

  		\WP_Mock::expectAction( 'special_action', 'https://example.com/bar' );

  		$result = my_permalink_function( 42 );

  		$this->assertEquals( 'https://example.com/bar', $result );
  	}
    
  }
?>
