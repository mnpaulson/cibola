<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomersTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(ValueTableSeeder::class);
    }
}
