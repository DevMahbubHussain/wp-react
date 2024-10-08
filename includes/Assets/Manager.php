<?php

namespace App\JobFind\Assets;

/**
 * Asset class.
 * Responsible for managing all of the assets (CSS, JS, Images).
 */

class Manager
{
    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('init', [$this, 'register_all_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    /**
     * Register all scripts and styles.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_all_scripts()
    {
        $this->register_styles($this->get_styles());
        $this->register_scripts($this->get_scripts());
    }

    /**
     * Get all styles.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_styles(): array
    {
        return [
            'job-find-css' => [
                'src'     => JOB_FIND_BUILD . '/index.css',
                'version' => JOB_FIND_VERSION,
                'deps'    => [],
            ],
            'job-find-main-css' => [
                'src'     => JOB_FIND_ASSETS . '/css/job-find-main.css',
                'version' => JOB_FIND_VERSION,
                'deps'    => [],
            ],
        ];
    }

    /**
     * Get all scripts.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_scripts(): array
    {
        $dependency = require_once JOB_FIND_DIR . '/build/index.asset.php';

        return [
            'job-find-app' => [
                'src'       => JOB_FIND_BUILD . '/index.js',
                'version'   => $dependency['version'],
                'deps'      => $dependency['dependencies'],
                'in_footer' => true,
            ],
            'job-find' => [
                'src'       => JOB_FIND_ASSETS . '/js/job-find.js',
                'version'   => $dependency['version'],
                'deps'      => $dependency['dependencies'],
                'in_footer' => true,
            ],
        ];
    }

    /**
     * Register styles.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_styles(array $styles)
    {
        foreach ($styles as $handle => $style) {
            wp_register_style($handle, $style['src'], $style['deps'], $style['version']);
        }
    }

    /**
     * Register scripts.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function register_scripts(array $scripts)
    {
        foreach ($scripts as $handle => $script) {
            wp_register_script($handle, $script['src'], $script['deps'], $script['version'], $script['in_footer']);
        }
    }

    /**
     * Enqueue admin styles and scripts.
     *
     * @since 1.0.0 Loads the JS and CSS only on the Job FIND admin page.
     *
     * @return void
     */
    public function enqueue_admin_assets()
    {
        // Check if we are on the admin page and page=jobplace.
        if (! is_admin() || ! isset($_GET['page']) || sanitize_text_field(wp_unslash($_GET['page'])) !== 'jobfind') {
            return;
        }

        wp_enqueue_style('job-find-main-css'); //dev css
        wp_enqueue_style('job-find-css'); // build css
        wp_enqueue_script('job-find-app'); // build js
        wp_enqueue_script('job-find'); //dev js
    }
}
