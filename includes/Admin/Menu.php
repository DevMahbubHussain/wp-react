<?php

namespace App\JobFind\Admin;

/**
 * Admin Menu class.
 * Responsible for managing admin menus.
 */

class Menu
{
    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'init_menu']);
    }

    /**
     * Init Menu.
     * @since 1.0.0
     * @return void
     */

    public function init_menu(): void
    {

        global $submenu;

        $slug = JOB_FIND_SLUG;
        $menu_position = 50;
        $capability    = 'manage_options';
        $logo_icon     = JOB_FIND_ASSETS . '/images/logo.png';

        add_menu_page(esc_attr__('Job Finder', 'jobfind'), esc_attr__('Job Finder', 'jobfind'), $capability, $slug, [$this, 'plugin_page'], $logo_icon, $menu_position);

        if (current_user_can($capability)) {
            $submenu[$slug][] = [esc_attr__('Home', 'jobfind'), $capability, 'admin.php?page=' . $slug . '#/']; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            $submenu[$slug][] = [esc_attr__('Jobs', 'jobfind'), $capability, 'admin.php?page=' . $slug . '#/jobs']; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            $submenu[$slug][] = [esc_attr__('Settings', 'jobfind'), $capability, 'admin.php?page=' . $slug . '#/settings']; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
        }
    }

    /**
     * Render the plugin page.
     *
     * @since 1.0.0
     *
     * @return void
     */

    public function plugin_page()
    {
        require_once JOB_FIND_TEMPLATE_PATH . '/app.php';
    }
}
