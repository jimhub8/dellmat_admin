<?php

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
        // $this->call(UserSeeder::class);
        // $this->call(SellerSeeder::class);
        // $this->call(ProductTableSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(OptionSeeder::class);
        // $this->call(OptionValueSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
    }
}
