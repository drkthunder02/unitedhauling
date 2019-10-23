<?php

use Illuminate\Database\Seeder;

use App\Models\Config\HaulingConfig;

class HaulingConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        printf("Adding hauling configuration.\r\n");

        if(HaulingConfig::where(['load_size' => 'small'])->count() == 0) {
            HaulingConfig::insert([
                'load_size' => 'small',
                'min_load_size' => 0,
                'max_load_size' => 8000,
                'price_per_jump' => 600000.00,
            ]);
        }
        
        if(HaulingConfig::where(['load_size' => 'medium'])->count() == 0) {
            HaulingConfig::insert([
                'load_size' => 'medium',
                'min_load_size' => 8000,
                'max_load_size' => 57500,
                'price_per_jump' => 800000.00,
            ]);
        }

        if(HaulingConfig::where(['load_size' => 'large'])->count == 0) {
            HaulingConfig::insert([
                'load_size' => 'large',
                'min_load_size' => 57500,
                'max_load_size' => 800000,
                'price_per_jump' => 1000000.00,
            ]);
        }

        printf("Finished adding hauling configuration.\r\n");
    }
}
