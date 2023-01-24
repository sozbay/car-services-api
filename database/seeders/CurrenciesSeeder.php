<?php

namespace Database\Seeders;

use App\Models\Currencies;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Currencies::query()->insert([
            [
                'name' => 'American Dollar',
                'code' => 'USD',
                'symbol' => '$'
            ],
            [
                'name' => 'EURO',
                'code' => 'EUR',
                'symbol' => '€'
            ],
            [
                'name' => 'Turkish Lira',
                'code' => 'TRY',
                'symbol' => '₺'
            ]
        ]);
    }
}
