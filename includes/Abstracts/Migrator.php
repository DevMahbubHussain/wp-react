<?php

namespace App\JobFind\Abstracts;

abstract class Migrator
{
    /**
     * Migrate the database table.
     *
     * @since 1.0.0
     *
     * @return void
     * 
     */

    abstract public static function migrate();
}
