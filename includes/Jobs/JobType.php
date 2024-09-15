<?php

namespace App\JobFind\Jobs;

use App\JobFind\Abstracts\BaseModel;

/**
 * JobType class.
 *
 * @since 1.0.0
 */

class JobType extends BaseModel
{
    /**
     * Table Name.
     *
     * @var string
     */
    protected $table = "jobfind_job_types";

    /**
     * Job types item to a formatted array.
     *
     * @since 1.0.0
     *
     * @param object $job_type
     *
     * @return array
     */
    public static function to_array(object $job_type): array
    {
        return [
            'id'          => (int) $job_type->id,
            'name'        => $job_type->name,
            'slug'        => $job_type->slug,
            'description' => $job_type->description,
            'created_at'  => $job_type->created_at,
            'updated_at'  => $job_type->updated_at,
        ];
    }
}
