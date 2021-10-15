<?php

// Block direct access to file
defined('ABSPATH') or die('Not Authorized!');

class Clear_Pantheon_et_Cache
{

    public function __construct()
    {

        // Plugin uninstall hook
        register_uninstall_hook(WPS_FILE, array('Clear_Pantheon_et_Cache', 'plugin_uninstall'));

        // Plugin activation/deactivation hooks
        register_activation_hook(WPS_FILE, array($this, 'plugin_activate'));
        register_deactivation_hook(WPS_FILE, array($this, 'plugin_deactivate'));

        // Plugin Actions
        add_action('plugins_loaded', array($this, 'plugin_init'));
        add_action('wp_enqueue_scripts', array($this, 'plugin_enqueue_scripts'));
        add_action('mda_delete_scripts', array($this, 'mda_delete_all'));
        add_action('mda_delete_cache_scripts', array($this, 'mda_delete_et_cache'));
        add_action('mda_print_cache_scripts', array($this, 'mda_print_et_cache'));
        add_action('admin_enqueue_scripts', array($this, 'plugin_enqueue_admin_scripts'));
        add_action('admin_menu', array($this, 'plugin_admin_menu_function'));
        add_action('admin_post_mda_delete_et_cache', array($this, 'mda_delete_et_cache'));
    }

    /**
	 * The slug for the plugin, used in various places like the settings page.
	 */
	const SLUG = 'mda-clear-et-cache';

    public static function plugin_uninstall()
    {
    }

    /**
     * Plugin activation function
     * called when the plugin is activated
     * @method plugin_activate
     */
    public function plugin_activate()
    {
    }

    /**
     * Plugin deactivate function
     * is called during plugin deactivation
     * @method plugin_deactivate
     */
    public function plugin_deactivate()
    {
    }

    /**
     * Plugin init function
     * init the polugin textDomain
     * @method plugin_init
     */
    function plugin_init()
    {
        // before all load plugin text domain
        load_plugin_textDomain(WPS_TEXT_DOMAIN, false, dirname(WPS_DIRECTORY_BASENAME) . '/languages');
    }

    function plugin_admin_menu_function()
    {

        //create main top-level menu with empty content
        add_menu_page(__('Clear Pantheon et-cache', WPS_TEXT_DOMAIN), __('Clear et-cache', WPS_TEXT_DOMAIN), 'administrator', 'mda-clear-et-cache', null, 'dashicons-trash', 4);

        // create top level submenu page which point to main menu page
        add_submenu_page('mda-clear-et-cache', __('General', WPS_TEXT_DOMAIN), __('General', WPS_TEXT_DOMAIN), 'manage_options', 'mda-clear-et-cache', array($this, 'plugin_settings_page'));

        // add the support page
        add_submenu_page('mda-clear-et-cache', __('Plugin Support Page', WPS_TEXT_DOMAIN), __('Support', WPS_TEXT_DOMAIN), 'manage_options', 'wps-support', array($this, 'plugin_support_page'));

        //call register settings function
        add_action('admin_init', array($this, 'plugin_register_settings'));
    }

    /**
     * Register the main Plugin Settings
     * @method plugin_register_settings
     */
    function plugin_register_settings()
    {
        register_setting('wps-settings-group', 'example_option');
        register_setting('wps-settings-group', 'another_example_option');
    }

    /**
     * Enqueue the main Plugin admin scripts and styles
     * @method plugin_enqueue_scripts
     */
    function plugin_enqueue_admin_scripts()
    {
        wp_register_style('wps-admin-style', WPS_DIRECTORY_URL . '/assets/dist/css/admin-style.css', array(), null);
        wp_register_script('wps-admin-script', WPS_DIRECTORY_URL . '/assets/dist/js/admin-script.min.js', array(), null, true);
        wp_enqueue_script('jquery');
        wp_enqueue_style('wps-admin-style');
        wp_enqueue_script('wps-admin-script');
    }

    /**
     * Enqueue the main Plugin user scripts and styles
     * @method plugin_enqueue_scripts
     */
    function plugin_enqueue_scripts()
    {
        wp_register_style('wps-user-style', WPS_DIRECTORY_URL . '/assets/dist/css/user-style.css', array(), null);
        wp_register_script('wps-user-script', WPS_DIRECTORY_URL . '/assets/dist/js/user-script.min.js', array(), null, true);
        wp_enqueue_script('jquery');
        wp_enqueue_style('wps-user-style');
        wp_enqueue_script('wps-user-script');
    }

    /**
     * Delete all files and directories
     * @method mda_delete_all
     */
    function mda_delete_all($dir) {
        foreach(glob($dir . '/*') as $file) {
            if(is_dir($file)) {
                $this->mda_delete_all($file);
                rmdir($file);
            } else {
                if($file) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Delete all files and directories
     * @method mda_delete_et_cache
     */
    public function mda_delete_et_cache()
    {
        $upload_dir   = wp_upload_dir();
        // Define et-cache location
        $path = $upload_dir['basedir'] . '/et-cache';
        // Uncomment next line if developing locally
        // $path = get_home_path() . 'wp-content/et-cache';
        // Delete all files and directories in et-cache
        if ($path) {
            $this->mda_delete_all($path);
            echo "Cleared et-cache.";
            wp_redirect( admin_url( 'admin.php?page=mda-clear-et-cache&et-cache-cleared=true' ) );
        } else {
            echo "Directory et-cache is not available";
        }
    }

    /**
     * Delete all files and directories
     * @method mda_print_et_cache
     */
    function mda_print_et_cache()
    {
        $upload_dir   = wp_upload_dir();
        // Define et-cache location
        $path = $upload_dir['basedir'] . '/et-cache';
        // Uncomment next line if developing locally
        // $path = get_home_path() . 'wp-content/et-cache';
        $i=0;
        foreach(glob($path . '/*') as $file) {
            print_r($file);
            echo '<br>';
            $i++;
            if($i==20){
                echo '<strong>Showing the first 20 ... to many to list</strong>';
                break;
            }
        }
    }

    

    /**
     * Plugin main settings page
     * @method plugin_settings_page
     */
    function plugin_settings_page()
    { ?>

        <div class="wrap">
            <?php if ( ! empty( $_GET['et-cache-cleared'] ) && 'true' == $_GET['et-cache-cleared'] ) : ?>
				<div class="updated below-h2">
					<p><?php esc_html_e( 'Site et-cache flushed.', 'mda-clear-et-cache' ); ?></p>
				</div>
			<?php endif ?>
        </div>
        
        <div class="wrap card">

            <h1><?php _e('Clear Pantheon et-cache', WPS_TEXT_DOMAIN); ?></h1>

            <p><?php _e('<strong>Welcome to Clear Pantheon et-cache plugin</strong> &ndash; the fastest way to clear the et-cache folder typically located at Pantheon~/files/uploads/et-cache.', WPS_TEXT_DOMAIN); ?></p>
            
            <form action="<?php echo esc_attr('admin-post.php'); ?>" method="POST">
                <input type="hidden" name="action" value="mda_delete_et_cache" />
                <!-- <h3><?php _e( 'Clear et-cache directory', 'mda-clear-et-cache'); ?></h3> -->
                <p><?php _e( 'Use often if you are experiencing issues saving posts or other admin functionality.', 'mda-clear-et-cache' ); ?></p>
                <?php submit_button( __( 'Clear et-cache', 'mda-clear-et-cache' ), 'primary' ); ?>
            </form>

        </div>
        
        <div class="wrap">
            <h1><?php _e('Directories and files inside of et-cache shown below', WPS_TEXT_DOMAIN); ?></h1>
            <p><?php _e($this->mda_print_et_cache(), 'mda-clear-et-cache'); ?></p>
        </div>

    <?php }

    /**
     * Plugin support page
     * in this page there are listed some useful debug information
     * and a quick link to write a mail to the plugin author
     * @method plugin_support_page
     */
    function plugin_support_page()
    {

        global $wpdb, $wp_version;
        $plugin = get_plugin_data(WPS_FILE, true, true);
        $wptheme = wp_get_theme();
        $current_user = wp_get_current_user();

        // set the user full name for the support request
        $user_fullname = ($current_user->user_firstname || $current_user->user_lastname) ?
            ($current_user->user_lastname . ' ' . $current_user->user_firstname) : $current_user->display_name;    ?>

        <div class="wrap card">

            <!-- support page title -->
            <h1><?php _e('Clear Pantheon et-cache plugin Support', WPS_TEXT_DOMAIN); ?></h1>

            <!-- support page description -->
            <p><?php _e('Please report this information when requesting support via mail.', WPS_TEXT_DOMAIN); ?></p>

            <div class="support-debug">

                <div class="plugin">

                    <ul>
                        <li class="support-plugin-version"><strong><?php _e($plugin['Name']); ?></strong> version: <?php _e($plugin['Version']); ?></li>
                        <li class="support-credits"><?php _e('Plugin author:', WPS_TEXT_DOMAIN); ?> <a href="<?php echo $plugin['AuthorURI']; ?>"><?php echo $plugin['AuthorName']; ?></a></li>
                    </ul>

                </div>

                <div class="theme">

                    <ul>
                        <li class="support-theme-version"><?php printf(_('Active theme %s version: %s'), $wptheme->Name, $wptheme->Version); ?></li>
                    </ul>

                </div>

                <div class="system">

                    <ul>
                        <li class="support-php-version"><?php _e('PHP version:', WPS_TEXT_DOMAIN); ?> <?php _e(PHP_VERSION); ?></li>
                        <li class="support-mysql-version"><?php _e('MySQL version:', WPS_TEXT_DOMAIN); ?> <?php _e(mysqli_get_server_info($wpdb->dbh)); ?></li>
                        <li class="support-wp-version"><?php _e('WordPress version:', WPS_TEXT_DOMAIN); ?> <?php _e($wp_version); ?></li>
                    </ul>

                </div>

            </div>

            <div class="support-action">
                <button type="button" class="button" name="Send Mail">
                    <a style="text-decoration: none" href="mailto:support@mollyduggan.com?Subject=Plugin%20Support%20for%20Clear%20Pantheon%20et-cache">Mail Me</a>
                </button>
            </div>

        </div>

<?php }
}

new Clear_Pantheon_et_Cache;
