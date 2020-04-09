<?php

use App\models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = array('Color', 'Size', 'Storage');
        foreach ($options as $option) {
            Option::create([
                'option_name' => $option,
            ]);
        }
    }
}
