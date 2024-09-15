<?php

// If uninstall is not called from WordPress, exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

// Remove custom tables.
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jobpfind_job_types");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jobplace_jobs");

// Remove options.
delete_option('jobfind_installed');
delete_option('jobfind_version');
delete_option('jobfind_job_seeder_ran');
delete_option('jobfind_job_type_seeder_ran');
