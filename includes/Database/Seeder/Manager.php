<?php

namespace App\JobFind\Database\Seeder;

class Manager
{
    /**
     * Run the database seeders.
     *
     * @since 1.0.0
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $seeder_classes = [
            \App\JobFind\Database\Seeder\JobTypeSeeder::class,
            \App\JobFind\Database\Seeder\JobsSeeder::class,
        ];

        foreach ($seeder_classes as $seeder_class) {
            $seeder = new $seeder_class();
            $seeder->run();
        }
    }
}
