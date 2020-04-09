<?php

use App\models\Option;
use App\models\OptionValue;
use Illuminate\Database\Seeder;

class OptionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $options = array('Color', 'Size', 'Storage');
        $color = array('red', 'blue', 'green');
        $size = array('Small', 'medium', 'large');
        $storage = array('250GB', '32GB', '16GB');
        $options = array(
            'Color' => $color,
            'Size' => $size,
            'Storage' => $storage
        );
        foreach ($options as $key => $option) {
            foreach ($option as $value) {
                // dd($value);
                $option_id = Option::select('id')->where('option_name', $key)->first();
                OptionValue::create([
                    'option_name' => $value,
                    'option_id' => $option_id->id,
                ]);
            }
        }
    }
}
