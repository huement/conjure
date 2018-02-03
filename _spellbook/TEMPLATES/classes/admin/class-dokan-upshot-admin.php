<?php
  /**
   * Dokan_Upshot
   *
   * @package   Dokan_Upshot_Admin
   * @author    Derek Scott <dscott@myriadmobile.com>
   * @license   GPL-2.0+
   * @link      https://bitbucket.org/derekscott_mm/dokan-upshot
   * @copyright 2017 Myriad Mobile [DS]
   */

  /**
   * Dokan_Upshot_Admin class. This class should ideally be used to work with the
   * administrative side of the WordPress site.
   *
   * If you're interested in introducing public-facing
   * functionality, then refer to `class-plugin-name.php`
   *
   * @property string plugin_slug is declared via comments.
   * @package  Dokan_Upshot_Admin
   * @author   Myriad Mobile <dscott@myriadmobile.com>
   */
  class Dokan_Upshot_Admin
  {

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Slug of the plugin screen.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $plugin_screen_hook_suffix = null;

    /**
     * Initialize the plugin by loading admin scripts & styles and adding a
     * settings page and menu.
     *
     * @since     1.0.0
     */
    private function __construct()
    {

      /*
       * @TODO :
       *
       * - Uncomment following lines if the admin class should only be available for super admins
       */
      /* if( ! is_super_admin()) {
          return;
      } */

      /*
       * Call $plugin_slug from public plugin class.
       */
      $plugin            = Dokan_Upshot::get_instance();
      $this->plugin_slug = $plugin->get_plugin_slug();

      $enable_option = get_option( 'dokan_product_subscription', array( 'enable_pricing' => 'off' ) );
      if( !isset( $enable_option['enable_pricing'] ) || $enable_option['enable_pricing'] != 'on' )
      {
        return;
      }

      // Load admin style sheet and JavaScript.
      add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

      // Add the options page and menu item.
      add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

      // Add an action link pointing to the options page.
      $plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_slug . '.php' );
      add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

      /*
       * Define custom functionality.
       *
       * Read more about actions and filters:
       * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
       */
      //add_action( 'plugins_loaded', array( $this, 'schedule_task' ));
      add_action( 'admin_init', array( $this, 'register_mysettings' ) );


    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance()
    {

      /*
       * - Uncomment following lines if the admin class should only be available for super admins
       */
      /* if( ! is_super_admin()) {
          return;
      } */

      // If the single instance hasn't been set, set it now.
      if( null == self::$instance )
      {
        self::$instance = new self;
      }

      return self::$instance;
    }

    /**
     * @brief   Add support for any and all WP_Settings data.
     * @details WP_Settings is quickly in / out data helpful for plugin settings, user configs etc.
     */
    public function register_mysettings()
    {
      // Check Updates Option
      register_setting(
        $this->plugin_slug,
        'dokan-upshot-subjects',
        array( 'type' => 'string', 'description' => 'message subject', 'show_in_rest' => true )
      );

      register_setting(
        $this->plugin_slug,
        'dokan-upshot-sentdays',
        array( 'type' => 'integer', 'description' => 'cron length in days', 'show_in_rest' => true )
      );

      register_setting(
        $this->plugin_slug,
        'dokan-upshot-body',
        array( 'type' => 'string', 'description' => 'message body', 'show_in_rest' => true )
      );

      register_setting(
        $this->plugin_slug,
        'dokan-upshot-template',
        array( 'type' => 'string', 'description' => 'message body', 'show_in_rest' => true )
      );

      register_setting(
        $this->plugin_slug,
        'dokan-upshot-maxid',
        array( 'type' => 'string', 'description' => 'Subscriber has maxed out if they have this product id', 'show_in_rest' => true )
      );
    }

    /**
     * Define constants
     *
     * @return void
     */
    function define_constants()
    {
      $dir   = plugin_dir_path( __FILE__ );
      $parts = explode( $dir, "/dokan-upshot" );
      define( 'DPS_PATH', $parts[0] );
      //define( 'DPS_URL', plugins_url( '', __FILE__ ));
    }

    /**
     * Includes required files
     *
     * @return void
     */
    function file_includes()
    {
      if( is_admin() )
      {
        require_once DPS_PATH . '/includes/admin/admin.php';
      }

      require_once DPS_PATH . '/includes/functions.php';
      require_once DPS_PATH . '/includes/classes/class-dps-manager.php';
      require_once DPS_PATH . '/includes/classes/class-registration-sub.php';
    }

    public function upshot_get_seller_status_count()
    {
      $active_users = new WP_User_Query(
        array( 'role' => 'seller',
          'meta_key' => 'dokan_enable_selling',
          'meta_value' => 'yes'
        )
      );

      $all_users = new WP_User_Query( array( 'role' => 'seller' ) );

      $user_query = new WP_User_Query( array('role' => 'seller', 'meta_key' => 'dokan_enable_selling', 'meta_value' => 'yes' ) );

      $subscriber_count = $user_query->get_total();
      $active_count     = $active_users->get_total();
      $inactive_count   = $all_users->get_total() - $active_count;

      $counts = array(
        'total' => $active_count + $inactive_count,
        'active' => $active_count,
        'inactive' => $inactive_count,
        'subscribers' => $subscriber_count
      );

      return $counts;
    }

    /**
     * Register and enqueue admin-specific style sheet.
     *
     * @since     1.0.0
     *
     * @brief     will return null if no settings page is registered.
     *
     * @param $hook
     */
    public function enqueue_admin_styles( $hook )
    {

      if( $hook != 'toplevel_page_dm_ss' )
      {
        return;
      }

      wp_enqueue_style( $this->plugin_slug . '-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Dokan_Upshot::VERSION );

      wp_enqueue_style( $this->plugin_slug . '-admin-style-dokan', plugins_url( 'assets/css/admin-dokan.css', __FILE__ ), array(),
                        Dokan_Upshot::VERSION );

    }

    /**
     * Register and enqueue admin-specific JavaScript.
     *
     * @since     1.0.0
     *
     * @brief     will return null if no settings page is registered.
     */
    public function enqueue_admin_scripts()
    {

      wp_enqueue_script(
        $this->plugin_slug . '-admin-script-bs',
        plugins_url( 'assets/js/bootstrap.min.js', __FILE__ ),
        array( 'jquery' ), Dokan_Upshot::VERSION, true);

      wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Dokan_Upshot::VERSION, true );
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu()
    {

      /*
       * Add a settings page for this plugin to the Settings menu.
       *
       * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
       *
       *        Administration Menus: http://codex.wordpress.org/Administration_Menus
       *
       * - Change 'manage_options' to the capability you see fit
       *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
       */
      $this->plugin_screen_hook_suffix = add_options_page(
        __( 'Dokan Upshot Settings', $this->plugin_slug ),
        __( 'Dokan Upshot', $this->plugin_slug ),
        'manage_options',
        $this->plugin_slug,
        array( $this, 'display_plugin_admin_page' )
      );

      add_menu_page(
        __( 'Dokan Subscriber Summary', $this->plugin_slug ),
        __( 'Dokan Upshot', $this->plugin_slug ),
        'manage_options',
        'dm_ss',
        array( $this, 'display_plugin_dokan_admin_page' ),
        'dashicons-shield-alt',
        19
      );

      add_action( 'admin_init', array( $this, 'update_extra_post_info' ) );

    }

    public function update_extra_post_info()
    {
      register_setting( 'extra-post-info-settings', 'extra_post_info' );
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page()
    {
      include_once( 'views/admin.php' );
    }

    public function display_plugin_dokan_admin_page()
    {
      global $dts, $the_site_url;
      $dts          = $this->upshot_get_seller_status_count();
      $the_site_url = site_url();

      include_once( 'views/dokan_admin.php' );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     *
     * @param $links
     *
     * @return array
     */
    public function add_action_links( $links )
    {
      $aurl   = admin_url( 'options-general.php?page=' . $this->plugin_slug );
      $slug   = __( 'Settings', $this->plugin_slug );
      $setURL = '<a href="' . $aurl . '">' . $slug . '</a>';

      return array_merge( array( 'settings' => $setURL ), $links );
    }

    /**
     * NOTE:     Filters are points of execution in which WordPress modifies data
     *           before saving it or sending it to the browser.
     *
     *           Filters: http://codex.wordpress.org/Plugin_API#Filters
     *           Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
     *
     * @since    1.0.0
     */
    public function filter_method_name()
    {
      // @TODO: Define your filter hook callback here
    }

    /**
     * @param $msg
     */
    public function dv_log( $msg )
    {
      $dirLog  = dirname( __FILE__ );
      $message = sprintf( "[%s] %s\n", date( 'd.m.Y h:i:s' ), $msg );
      error_log( "[DA_UP]" . $message, 3, $dirLog . '/dv.log' );
    }
  }
