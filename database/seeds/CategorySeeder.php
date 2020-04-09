<?php

use App\models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
        foreach (range(1, 7) as $index) {
            Category::create([
                'user_id' => $faker->numberBetween($min = 2, $max = 4),
                'category' => $faker->department,
            ]);
        }
    }
}
