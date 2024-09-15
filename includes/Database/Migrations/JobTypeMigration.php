<?php

namespace App\JobFind\Database\Migrations;

use App\JobFind\Abstracts\Migrator;

class JobTypeMigration extends Migrator
{

    public static function migrate()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema_job_types = "CREATE TABLE IF NOT EXISTS `{$wpdb->jobfind_job_types}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `slug` varchar(255) NOT NULL,
            `description` varchar(255) NOT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `slug` (`slug`)
        ) $charset_collate;";

        // Create the tables.
        dbDelta($schema_job_types);
    }
}
