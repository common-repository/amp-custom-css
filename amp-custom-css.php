<?php
/*
Plugin Name: AMP Custom CSS
Plugin URI: https://wordpress.org/plugins/ampcc/
Description: This plugin will help you to add your own custom CSS in the AMP version. You need to have atleast one AMP plugin on your website to make this custom CSS work.
Version: 1.0
Author: Zaowl
Author URI: https://zaowl.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ampcc
*/

if (!defined('ABSPATH'))exit; //Exit if accessed directly

if(!class_exists('AMPCustomCSS')) 
{
    class AMPCustomCSS 
    {
        /*
         * 
         * Registering settings
         *
         */
        private $edit_ampcc_settings_page_key = 'edit_ampcc_settings_page';
        private $ampcc_options_key = 'ampcc_plugin_options';

        function __construct() {
            $this->define_constants();
            $this->loader_operations();
        }

        function define_constants() {
            global $wpdb;
            define('AMPCC_PLUGIN_DB_VERSION', '1.0');
            define('AMPCC_PLUGIN_PATH', dirname(__FILE__));
            define('AMPCC_PLUGIN_URL', plugins_url('',__FILE__));
        }

        function loader_operations(){
            add_action('plugins_loaded', array( &$this, 'ampcc_execute_plugins_loaded_operations'));
        }

        function ampcc_execute_plugins_loaded_operations()
        {	        
            if( current_user_can('administrator')) {   
            add_action( 'admin_menu', array( &$this, 'add_admin_menus' ) );
            add_filter('plugin_action_links', array( &$this, 'amp_custom_css_settings_link' ), 10, 2 );
            }
        }

        function amp_custom_css_settings_link($links, $file)
        {

            if ($file == plugin_basename(__FILE__) && current_user_can('administrator')){
                    $settings_link = '<a href="admin.php?page=ampcc_plugin_options">Settings</a>';
                    array_unshift($links, $settings_link);
            }
            return $links;
        }

        function add_admin_menus(){	    
            $ampcc_page = add_menu_page('AMP Custom CSS', 'AMP Custom CSS', 'manage_options', $this->ampcc_options_key, array(&$this, 'ampcc_plugin_option_page'),'dashicons-smiley');    
        }
  
        function ampcc_plugin_option_page() {
            if( current_user_can('administrator')) { 
            $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->edit_ampcc_settings_page_key;
            ?>
            <div class="wrap">
                    <?php 
                    if ($tab == $this->edit_ampcc_settings_page_key)
                    {
                        include_once('amp-custom-css-settings.php');
                        amp_custom_css_settings();				
                    }
                    ?>
            </div>
            <?php
        }
    }
    } //end class
}
$GLOBALS['ampcc_plugin'] = new AMPCustomCSS();

add_action('amp_post_template_css', 'amp_custom_css_styling');
function amp_custom_css_styling() {   
    $settings = get_option('ampcc_settings');
    if ($settings) {
     echo $settings['amp_css'];
    }
}