<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: DB Error Customizer - Free
Plugin URI:  https://wordpress.org/plugins/db-error-customizer/
Description: Allow you to customise a beautiful and useful database error page
Version:     2.0
Author:      Centil Technology
Author URI:  http://dec.centil.co
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: db-error-customizer
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

// Inlcude common class
include_once 'source/setting.php';
include_once 'source/builder.php';

/*
 * Notice to show when plugin activated
 */
function dec_plugin_admin_notices() {
    if (!get_option('plugin_activate_notice_shown') && !is_plugin_active(Setting::getRootDir().'db-error-customizer.php')) {
        echo "<div class='update-nag'><p>DB Error Customizer is activated but not enabled. Please goto <a href='".admin_url('options-general.php?page=db-error-customizer')."'>DB Error Customizer setting page</a> to proceed setup.</p></div>";
        update_option('plugin_activate_notice_shown', 'true');
    }
}
add_action('admin_notices', 'dec_plugin_admin_notices');

/*
 * Process to run when deactivating plugin
 */
register_deactivation_hook( __FILE__, 'dec_plugin_deactivation');
function dec_plugin_deactivation( ) {
    // Delete plugin activation admin notice option
    delete_option('plugin_activate_notice_shown');

    // Delete registered settings
    foreach(Setting::getSettings() as $setting => $configs) {
        if ($configs['visibility'] == 'public') {
            delete_option( $setting );
        }
    }

    // Restore db-error.php to default state
    if (file_exists(WP_CONTENT_DIR . "/db-error.php")) {
        if (is_writable(WP_CONTENT_DIR . "/db-error.php")) {
            $fh = fopen(WP_CONTENT_DIR . "/db-error.php", 'w');
            fputs($fh, "<h1>Error establishing a database connection</h1>");
            fclose($fh);
        }
    }
}

/*
 * Process to add plugin menu
 */
function dec_plugin_menu() {
    add_options_page('DB Error Customizer', 'DB Error Customizer', 'administrator', 'db-error-customizer', 'dec_plugin_settings_page', 'dashicons-admin-customizer');
}
add_action('admin_menu', 'dec_plugin_menu');

/*
 * Check if there are write permission for all files
 */
function dec_test_server( $mode ) {
    $msgErrors = array();

    // Different condition for different scenario
    $is_need_preview = false;
    $is_need_save = false;
    $is_need_template = false;

    // Run different tests based on different test request
    if ($mode == "preview") {
        $is_need_preview = true;
        $is_need_template = true;
    } else if ($mode == "save") {
        $is_need_save = true;
        $is_need_template = true;
    } else {
        // Default test mode to cover all (Except template)
        $is_need_preview = true;
        $is_need_save = true;
    }

    // Run test for preview file
    if ($is_need_preview
        && !is_writable(Setting::getRootDir()."preview.html")) {
        $msgErrors[] = "Not able to write to ".Setting::getRootDir()."preview.html. ".
            "Please temporarily enable <a href='https://codex.wordpress.org/Changing_File_Permissions' target='_blank'>777 write permission</a> to this file to proceed.";
    }

    // Run test for db error file
    if ($is_need_save
        && !is_writable(WP_CONTENT_DIR . "/db-error.php")) {
        $msgErrors[] = "Not able to write to ".WP_CONTENT_DIR . "/db-error.php. ".
            "Please create an empty db-error.php file and temporarily enable <a href='https://codex.wordpress.org/Changing_File_Permissions' target='_blank'>777 write permission</a> to this file to proceed.";
    }

    // Run test to read template file either in preview or save mode
    if ($is_need_template) {
        // Sanitize and validate all inputs
        $template_select = sanitize_text_field($_POST['template_select']);
        if (!in_array($template_select, Setting::getTemplates())) {
            $template_select = 'basic';
        }

        if (!is_readable(Setting::getRootDir()."templates/".$template_select.".txt")) {
            $msgErrors[] = "Not able to read from ".Setting::getRootDir()."templates/".$template_select.".txt. ".
                "Please enable <a href='https://codex.wordpress.org/Changing_File_Permissions' target='_blank'>644 read permission</a> to this file to proceed.";
        }
    }

    // Generate result
    $status = "pass";
    $msg = "";
    if (count($msgErrors) > 0) {
        $status = "fail";
        $msg = "<ul>";
        foreach ($msgErrors as $msgError) {
            $msg .= "<li>".$msgError."</li>";
        }
        $msg .= "</ul>";
    } else {
        $msg = "Test pass. You shall proceed to configure and setup customized DB error page.";
    }

    // Return result
    return array(
        "status" => $status,
        "msg" => $msg
    );
}

/*
 * Content for plugin setting menu page
 */
function dec_plugin_settings_page() {
    // Check if user got permission for this page or not
    if( !is_super_admin()
        && !current_user_can('administrator')) {
        die('<div class="wrap"><div class="error"><p>You do not have permission to access this page</p></div></div>');
    }

    wp_enqueue_style( 'wp-color-picker' ); 
    wp_enqueue_script( 'custom-script-handle', plugins_url( 'assets/js/db-error-customizer.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    wp_enqueue_media();

    // Initialise variable
    $result = null;
    $error = "";
    $info = "";
    $warning = "";

    // Sanitize and validate all inputs
    $input_array = array();

    foreach (Setting::getSettings() as $setting => $configs) {
        $input = null;
        if (isset($_POST[$setting])) {
            // Sanitize input
            switch($configs['type']) {
                case 'text':
                    $input = sanitize_text_field($_POST[$setting]);
                    break;
                case 'integer':
                    $input = intval($_POST[$setting]);
                    break;
                case 'url':
                    $input = esc_url_raw($_POST[$setting]);
                    break;
                case 'checkbox':
                    $input = 'checked';
                    break;
                case 'email':
                    $input = sanitize_email($_POST[$setting]);
                    break;
                default:
                    die("INTERNAL ERROR: TYPE => ".$configs['type']);
            }

            // Validate input
            switch($configs['validate']) {
                case 'in_templates':
                    if (!in_array($input, Setting::getTemplates())) {
                        $input = $configs['default'];
                    }
                    break;
                case 'in_email_freqs':
                    if (!in_array($input, Setting::getEmailFreqs())) {
                        $input = $configs['default'];
                    }
                    break;
                case 'preg_match':
                    if (!preg_match($configs['match'], $input)) {
                        if ($configs['type'] == 'url') {
                            $input = plugins_url( $configs['default'],  __FILE__ ); 
                        } else {
                            $input = $configs['default'];
                        }
                    }
                    break;
                case 'is_email':
                    if (!is_email($input)) {
                        $input = get_option($configs['default'], '');
                    }
                    break;
                case 'empty':
                    if (!input) {
                        $input = $configs['default']; 
                    }
                    break;
                default:
                    die("INTERNAL ERROR: VALIDATE => ".$configs['validate']);
            }

            $input_array[$setting] = $input;

            if (isset($_POST['submit_save'])
                && $configs['visibility']=='public') {
                update_option($setting, $input);
            }
        } else if ($_POST && $configs['type'] == 'checkbox') {
            $input_array[$setting] = '';

            if (isset($_POST['submit_save'])
                && $configs['visibility']=='public') {
                update_option($setting, $input);
            }
        }
    }

    // Handle different submit request
    if (isset($_POST['submit_test'])) {
        // Verify nonce
        check_admin_referer( 'submit_test_'.get_current_user_id() );

        // Check if there is write permission all required files
        $result = dec_test_server( "test" );

    } else if (isset($_POST['submit_save'])) {
        // Verify nonce
        check_admin_referer( 'submit_preview_save_'.get_current_user_id() );

        // Run testing for save
        $result = dec_test_server( "save" );
        if ($result['status'] == "pass") {
            // Proceed to write to db-error.php
            $result = Builder::dec_template_generator(false, $input_array);
        }
    } else if (isset($_POST['submit_preview'])) {
        // Verify nonce
        check_admin_referer( 'submit_preview_save_'.get_current_user_id() );

        // Run testing for preview
        $result = dec_test_server( "preview" );
        if ($result['status'] == "pass") {
            // Proceed to preview
            $result = Builder::dec_template_generator(true, $input_array);
        }
    }

    if ($result['status'] == "pass") {
        $info = $result['msg'];
    } else {
        $error = $result['msg'];
    }

    // Load supported template
    $templates = glob(Setting::getRootDir()."templates/*.txt");

    include 'source/admin-menu.php';
}
?>
