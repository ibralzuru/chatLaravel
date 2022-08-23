<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert(
            [
                'name' => 'Tekken 3',
                'category' => 'fight'
            ]
        );
        DB::table('games')->insert(
            [
                'name' => 'Tenchu',
                'category' => 'adventure'

            ]
        );
        DB::table('games')->insert(
            [
                'name' => 'Nba live',
                'category' => 'sport'

            ]
        );
        DB::table('games')->insert(
            [
                'name' => 'Fifa 2022',
                'category' => 'sport'
            ]
        );
    }
}
