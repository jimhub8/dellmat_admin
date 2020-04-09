<?php

use App\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 7) as $index) {
            Seller::create([
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
            ]);
        }
    }
}
