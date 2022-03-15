<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caisse;

class CaisserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Caisse::create([
            'montant' => '10000'
        ]);
    }
}
