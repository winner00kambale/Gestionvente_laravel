<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caissers;

class CaisserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Caissers::create([
            'montant' => '10000'
        ]);
    }
}
