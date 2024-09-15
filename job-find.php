<?php

/**
 * Plugin Name:      Job Finder
 * Plugin URI:       https://mahbub.com/plugins/job-finder/
 * Description:      A simple starter kit to work in WordPress plugin development using WordPress Rest API, WP-script.
 * Version:          1.0.0
 * Requires at least:5.8
 * Requires PHP:     7.4
 * Author:           Mahbub Hussain
 * Author URI:       https://mahbub.com/
 * License:          GPL v2 or later
 * License URI:      https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:      jobfind
 * Domain Path:      /languages
 * 
 * @package jobfind
 */

if (!defined('ABSPATH')) {
	exit;
}

final class JobFind
{
	/**
	 * Plugin version
	 */
	const VERSION = '1.0.0';

	/**
	 * Plugin slug
	 */
	const SLUG = 'jobfind';

	/**
	 * Singleton instance
	 *
	 * @var JobFind|null
	 */
	private static $instance = null;

	/**
	 * Holds various class instances
	 *
	 * @var array
	 */
	private $container = [];

	/**
	 * Constructor: Initialize the plugin
	 */
	private function __construct()
	{
		require_once __DIR__ . '/vendor/autoload.php';

		// Define constants
		$this->define_constants();

		// Initialize hooks
		$this->init_hooks();

		// Include required files
		$this->includes();
	}

	/**
	 * Singleton instance
	 *
	 * @return JobFind
	 */
	public static function init()
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define plugin constants
	 */
	private function define_constants()
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
	 * Initialize hooks and localization
	 */
	private function init_hooks()
	{
		// Activation and deactivation hooks
		register_activation_hook(__FILE__, [$this, 'activate']);
		register_deactivation_hook(__FILE__, [$this, 'deactivate']);

		// Initialize localization
		add_action('init', [$this, 'localization_setup']);

		// Plugin action links
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'plugin_action_links']);
	}

	/**
	 * Include required files
	 */
	private function includes()
	{
		if ($this->is_request('admin')) {
			$this->container['admin_menu'] = new \App\JobFind\Admin\Menu();
		}

		// Common class inclusions can go here
		$this->container['assets'] = new \App\JobFind\Assets\Manager();
	}

	/**
	 * Set up localization
	 */
	public function localization_setup()
	{
		load_plugin_textdomain('jobfind', false, dirname(plugin_basename(__FILE__)) . '/languages/');

		if (is_admin()) {
			wp_set_script_translations('job-find-app', 'jobfind', JOB_FIND_DIR . '/languages/');
		}
	}

	/**
	 * Plugin activation hook: Flush rewrite rules
	 */
	public function activate()
	{
		$this->install();
	}

	/**
	 * Plugin deactivation hook: Flush rewrite rules
	 */
	public function deactivate()
	{
		$this->flush_rewrite_rules();
	}

	/**
	 * Flush rewrite rules
	 */
	private function flush_rewrite_rules()
	{
		flush_rewrite_rules();
	}

	/**
	 * Run the installer to create necessary migrations.
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */

	private function install()
	{
		$installer = new \App\JobFind\Setup\Installer();
		$installer->run();
		// var_dump(get_class_methods($installer));
	}

	/**
	 * Determine the request type (admin, ajax, cron, frontend)
	 *
	 * @param string $type
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
				return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
		}
	}

	/**
	 * Add settings link to the plugin action links
	 *
	 * @param array $links
	 * @return array
	 */
	public function plugin_action_links($links)
	{
		$settings_link = '<a href="' . admin_url('admin.php?page=jobfind#/settings') . '">' . __('Settings', 'jobfind') . '</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * Magic getter for accessing container elements
	 *
	 * @param string $prop
	 * @return mixed
	 */
	public function __get($prop)
	{
		if (isset($this->container[$prop])) {
			return $this->container[$prop];
		}
		return $this->{$prop};
	}

	/**
	 * Magic isset for checking container elements
	 *
	 * @param string $prop
	 * @return bool
	 */
	public function __isset($prop)
	{
		return isset($this->container[$prop]) || isset($this->{$prop});
	}
}

/**
 * Initialize the plugin
 *
 * @return JobFind
 */
function job_finder()
{
	return JobFind::init();
}

// Kick off the plugin
job_finder();
