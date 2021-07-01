<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(EmployeesTableSeeder::class);
        // $this->call(CheckboxesTableSeeder::class);
        $this->call(WorksTableSeeder::class);
        $this->call(WorkBreaksTableSeeder::class);
    }
}
