<?php

/**
 * Plugin Name:      Job Finder
 * Plugin URI:        https://mahbub.com/plugins/job-finder/
 * Description:       A simple starter kit to work in WordPress plugin development using WordPress Rest API, WP-script.
 * Version:           1.0.0
 * Requires at least:  5.8
 * Requires PHP:      7.4
 * Author:            Mahbub Hussain
 * Author URI:        https://mahbub.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       jobfind
 * Domain Path:       /languages
 *
 * @package jobfind
 */



if (! defined('ABSPATH')) {
    exit;
}

final class JobFind
{

    /**
     * plugin version.
     * 
     * $var string
     */

    const VERSION = '0.1.0';


    /**
     * Plugin slug.
     * 
     * $var string
     */

    const SLUG = 'jobfind';

    /**
     * Holds various class instances.
     *
     * @var array
     *
     * @since 0.1.0
     */
    private $container = [];

    /**
     * Constructor for the JobFind Class.
     * @since 1.0.0
     */

    public function __construct()
    {
        require_once __DIR__ . '/vendor/autoload.php';
        $this->define_constants();
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);
        add_action('wp_loaded', [$this, 'flush_rewrite_rules']);
        $this->init_plugin();
    }

    /**
     * Initializes the JobFind() class.
     *
     * Checks for an existing JobFind() instance
     * and if it doesn't find one, creates it.
     *
     * @since 0.1.0
     *
     * @return JobFind|bool
     */
    public static function init()
    {
        static $instance = false;

        if (! $instance) {
            $instance = new JobFind();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @since 0.1.0
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get($prop)
    {
        if (array_key_exists($prop, $this->container)) {
            return $this->container[$prop];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @since 0.1.0
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset($prop)
    {
        return isset($this->{$prop}) || isset($this->container[$prop]);
    }

    /**
     * Define the constants.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function define_constants()
    {
        define('JOB_FIND_VERSION', self::VERSION);
        define('JOB_FIND_SLUG', self::SLUG);
        define('JOB_FIND_FILE', __FILE__);
        define('JOB_FIND_DIR', __DIR__);
        define('JOB_FIND_PATH', dirname(JOB_FIND_FILE));
        define('JOB_FIND_INCLUDES', JOB_FIND_PATH . '/includes');
        define('JOB_FIND_TEMPLATE_PATH', JOB_FIND_PATH . '/templates');
        define('JOB_FIND_URL', plugins_url('', JOB_FIND_FILE));
        define('JOB_FIND_BUILD', JOB_FIND_URL . '/build');
        define('JOB_FIND_ASSETS', JOB_FIND_URL . '/assets');
    }

    /**
     * Load the plugin after all plugins are loaded.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function init_plugin()
    {
        $this->includes();
        $this->init_hooks();

        /**
         * Fires after the plugin is loaded.
         *
         * @since 0.1.0
         */
        do_action('job_find_loaded');
    }

    /**
     * Activating the plugin.
     *
     * @since 0.2.0
     *
     * @return void
     */
    public function activate()
    {
        //
    }

    /**
     * Flush rewrite rules after plugin is activated.
     *
     * Nothing being added here yet.
     *
     * @since 0.1.0
     */
    public function flush_rewrite_rules()
    {
        // fix rewrite rules
    }

    /**
     * Placeholder for deactivation function.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function deactivate()
    {
        //
    }

    /**
     * Include the required files.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function includes()
    {
        // Admin

        if ($this->is_request('admin')) {
            $this->container['admin_menu'] = new \App\JobFind\Admin\Menu();
        }

        // Common classes

    }

    /**
     * Initialize the hooks.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function init_hooks()
    {
        // Localize our plugin
        add_action('init', [$this, 'localization_setup']);

        // Add the plugin page links
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links']);
    }

    /**
     * Initialize plugin for localization.
     *
     * @uses load_plugin_textdomain()
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function localization_setup()
    {
        load_plugin_textdomain('jobfind', false, dirname(plugin_basename(__FILE__)) . '/languages/');

        // Load the React-pages translations.
        if (is_admin()) {
            // Load wp-script translation for job-place-app
            wp_set_script_translations('job-find-app', 'jobfind', plugin_dir_path(__FILE__) . 'languages/');
        }
    }

    /**
     * What type of request is this.
     *
     * @since 0.1.0
     *
     * @param string $type admin, ajax, cron or frontend
     *
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();

            case 'ajax':
                return defined('DOING_AJAX');

            case 'rest':
                return defined('REST_REQUEST');

            case 'cron':
                return defined('DOING_CRON');

            case 'frontend':
                return (! is_admin() || defined('DOING_AJAX')) && ! defined('DOING_CRON');
        }
    }

    /**
     * Plugin action links
     *
     * @param array $links
     *
     * @since 0.1.0
     *
     * @return array
     */
    public function plugin_action_links($links)
    {
        $links[] = '<a href="' . admin_url('admin.php?page=jobfind#/settings') . '">' . __('Settings', 'jobfind') . '</a>';
        return $links;
    }
}

/**
 * Initialize the main plugin.
 *
 * @since 0.1.0
 *
 * @return \JobFind|bool
 */
function job_finder()
{
    return JobFind::init();
}

/*
 * Kick-off the plugin.
 *
 * @since 0.1.0
 */
job_finder();
