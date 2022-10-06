<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            [
                'point' => 'Awesome',
            ],
            [
                'point' => 'Excellent',
            ],
            [
                'point' => 'Good',
            ],
            [
                'point' => 'Average',
            ],
            [
                'point' => 'Poor',
            ]
        ];
        DB::table('categories')->insert($param);
    }
}
