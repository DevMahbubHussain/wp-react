<?php

namespace App\JobFind\Setup;

use JobFind;

class Installer
{

    /**
     * Job find installed option key.
     *
     * @var string
     *
     * @since 1.0.0
     */
    const JOB_FIND_INSTALLED = 'jobfind_installed';

    /**
     * Job find version option key.
     *
     * @var string
     *
     * @since 1.0.0
     */
    const JOB_FIND_VERSION = 'jobfind_version';


    public function run(): void
    {
        $this->add_version();

        // Register and create tables.
        $this->register_table_names();
        $this->create_tables();

        // Run the database seeders.
        $seeder = new \App\JobFind\Database\Seeder\Manager();
        $seeder->run();
    }

    /**
     * Register table names.
     *
     * @since 1.0.0
     *
     * @return void
     */

    private function register_table_names()
    {
        global $wpdb;

        $wpdb->jobfind_job_types = $wpdb->prefix . 'jobfind_job_types';
        $wpdb->jobfind_jobs = $wpdb->prefix . 'jobfind_jobs';
    }

    /**
     * Add time and version on DB.
     *
     * @since 1.0.0
     *
     * @return void
     */
    private function add_version()
    {
        $installed = get_option(self::JOB_FIND_INSTALLED);

        if (!$installed) {
            update_option(self::JOB_FIND_INSTALLED, time());
        }

        update_option(self::JOB_FIND_VERSION, JobFind::VERSION);
    }

    /**
     * Create necessary database tables.
     *
     * @since JOB_FIND
     *
     * @return void
     */

    private function create_tables()
    {
        if (! function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        // Run the database table migrations.
        \App\JobFind\Database\Migrations\JobTypeMigration::migrate();
        \App\JobFind\Database\Migrations\JobsMigration::migrate();
    }
}
