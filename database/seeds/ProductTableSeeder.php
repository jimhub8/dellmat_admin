<?php

use App\models\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
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
        $faker->addProvider(new \Bezhanov\Faker\Provider\Placeholder($faker));
        foreach (range(1, 50) as $index) {
            Product::create([
                'user_id' => $faker->numberBetween($min = 1, $max = 2),
                'vendor_id' => $faker->numberBetween($min = 1, $max = 2),
                'product_name' => $faker->productName,
                // 'description' => $faker->text,
                // 'pos_status' => $faker->word,
                // 'price' => $faker->numberBetween($min = 400, $max = 10000),
                // 'product_barcode' => $faker->ean8,
                // 'quantity' => $faker->numberBetween($min = 1, $max = 20),
                // 'sku' => $faker->isbn10,
                // 'tax_category_id' => $faker->numberBetween($min = 1, $max = 200),
                // 'tax_percent' => $faker->numberBetween($min = 1, $max = 20),
                // 'type' => $faker->word,
                // 'weight' => $faker->numberBetween($min = 1, $max = 20),
                // 'image' => $faker->placeholder(),
            ]);
        }
    }
}
