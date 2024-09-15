<?php

namespace App\JobFind\Database\Seeder;

use App\JobFind\Abstracts\DBSeeder;

class JobsSeeder extends DBSeeder
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
        $already_seeded = (bool) get_option(self::JOB_SEEDER_RAN, false);
        if ($already_seeded) {
            return;
        }

        // Generate some jobs.
        $jobs = [
            [
                'title'       => 'First Job Post',
                'slug'        => 'first-job-post',
                'description' => 'This is a simple job post.',
                'is_active'   => 1,
                'company_id'  => 1,
                'job_type_id' => 1,
                'created_by'  => get_current_user_id(),
                'created_at'  => current_datetime()->format('Y-m-d H:i:s'),
                'updated_at'  => current_datetime()->format('Y-m-d H:i:s'),
            ],
        ];

        // Create each of the jobs.
        foreach ($jobs as $job) {
            $wpdb->insert(
                $wpdb->prefix . 'jobfind_jobs',
                $job
            );
        }

        // Update that seeder already runs.
        update_option(self::JOB_SEEDER_RAN, true);
    }
}
