<?php

namespace App\JobFind\Jobs;

use App\JobFind\Abstracts\BaseModel;

class Job extends BaseModel
{
    protected $table = 'jobfind_jobs';

    public static function to_array(object $item): array
    {
        return [];
    }
}
