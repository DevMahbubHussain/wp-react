<?php

namespace App\JobFind\Database\Seeder;

use App\JobFind\Abstracts\DBSeeder;


class JobTypeSeeder extends DBSeeder
{
    /**
     * Job type seeder ran key.
     *
     * @var string
     *
     * @since 1.0.0
     */
    const JOB_TYPE_SEEDER_RAN = 'jobfind_job_type_seeder_ran';

    /**
     * Job seeder ran key.
     *
     * @var string
     *
     * @since 1.0.0
     */
    const JOB_SEEDER_RAN = 'jobfind_job_seeder_ran';

    public function run()
    {

        global $wpdb;

        // Check if there is already a seeder runs for this plugin.
        $already_seeded = (bool) get_option(self::JOB_TYPE_SEEDER_RAN, false);
        if ($already_seeded) {
            return;
        }

        // Generate some job_types.
        $job_types = [
            [
                'name'        => 'Full time',
                'slug'        => 'full-time',
                'description' => 'This is a full time job post.',
                'created_at'  => current_datetime()->format('Y-m-d H:i:s'),
                'updated_at'  => current_datetime()->format('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Part time',
                'slug'        => 'part-time',
                'description' => 'This is a part time job post.',
                'created_at'  => current_datetime()->format('Y-m-d H:i:s'),
                'updated_at'  => current_datetime()->format('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Remote',
                'slug'        => 'remote',
                'description' => 'This is a remote job post.',
                'created_at'  => current_datetime()->format('Y-m-d H:i:s'),
                'updated_at'  => current_datetime()->format('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Contractual',
                'slug'        => 'contractual',
                'description' => 'This is a contractual job post.',
                'created_at'  => current_datetime()->format('Y-m-d H:i:s'),
                'updated_at'  => current_datetime()->format('Y-m-d H:i:s'),
            ],
        ];

        // Create each of the job_types.
        foreach ($job_types as $job_type) {
            $wpdb->insert(
                $wpdb->prefix . 'jobfind_job_types',
                $job_type
            );
        }

        // Update that seeder already runs.
        update_option(self::JOB_TYPE_SEEDER_RAN, true);
    }
}
