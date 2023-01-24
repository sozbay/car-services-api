<?php

namespace Database\Seeders;

use App\Models\Services;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Services::query()->insert([
            [
                'name' => 'Classic Watery Interior - Exterior Vehicle Cleaning Application',
                'price' => '25',
                'currency_id' => 1,
                'service_type' => 'Cleaning'
            ],
            [
                'name' => 'Nano Technological Waterless Vehicle Cleaning System',
                'price' => '35',
                'currency_id' => 1,
                'service_type' => 'Care'
            ],
            [
                'name' => 'Crystal Ceramic Coating',
                'price' => '100',
                'currency_id' => 1,
                'service_type' => 'Care'
            ],
            [
                'name' => 'Detailed Internal Cleaning and Sterilization',
                'price' => '30',
                'currency_id' => 1,
                'service_type' => 'Cleaning'
            ],
            [
                'name' => 'Engine Cleaning',
                'price' => '15',
                'currency_id' => 1,
                'service_type' => 'Cleaning'
            ],
            [
                'name' => 'Bacteria And Virus Sterilization',
                'price' => '10',
                'currency_id' => 1,
                'service_type' => 'Cleaning'
            ],
            [
                'name' => 'Nano complete application',
                'price' => '35',
                'currency_id' => 1,
                'service_type' => 'Care'
            ],
        ]);
    }
}
