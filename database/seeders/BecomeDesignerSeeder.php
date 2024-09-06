<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Becomedesigner;

class BecomeDesignerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Becomedesigner::create([
            'text_en' => 'Test English',
            'text_ar' => 'Test Arabic',
        ]);
    }
}
