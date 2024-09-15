<?php

namespace App\JobFind\Jobs;

/**
 * JobStatus class.
 *
 * @since 1.0.0
 */

class JobStatus
{
    /**
     * Draft status.
     *
     * @since 1.0.0
     */

    const DRAFT = 'draft';

    /**
     * Published status.
     *
     * @since 1.0.0
     */

    const PUBLISHED = 'published';


    /**
     * Trashed status.
     *
     * @since 1.0.0
     */

    const TRASHED = 'trashed';

    /**
     * Get job status.
     *
     * @since 1.0.0
     *
     * @param object $job
     */

    public static function get_status_by_job(Job $job): string
    {
        if (!empty($job->deleted_at)) {
            return self::DRAFT;
        }

        if (!empty($job->is_active)) {
            return self::PUBLISHED;
        }
        return self::TRASHED;
    }
}
