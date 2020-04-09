<?php

use App\models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Team($faker));
        foreach (range(1, 7) as $index) {
            Brand::create([
                'user_id' => $faker->numberBetween($min = 2, $max = 4),
                'brand' => $faker->team,
            ]);
        }
    }
}
