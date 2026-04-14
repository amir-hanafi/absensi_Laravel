<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PointRule;

class PointRuleSeeder extends Seeder
{
    public function run(): void
    {
        PointRule::truncate(); // reset biar tidak dobel

        PointRule::insert([
            [
                'rule_name' => 'Datang Sangat Awal',
                'condition_operator' => '<',
                'condition_value' => '01:00:00',
                'point_modifier' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rule_name' => 'Datang Tepat Waktu',
                'condition_operator' => 'between',
                'condition_value' => '01:01:00-04:39:00',
                'point_modifier' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rule_name' => 'Terlambat',
                'condition_operator' => '>',
                'condition_value' => '05:40:00',
                'point_modifier' => -3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

// <?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use App\Models\PointRule;

// class PointRuleSeeder extends Seeder
// {
//     public function run(): void
//     {
//         PointRule::truncate(); // reset biar tidak dobel

//         PointRule::insert([
//             [
//                 'rule_name' => 'Datang Sangat Awal',
//                 'condition_operator' => '<',
//                 'condition_value' => '06:30:00',
//                 'point_modifier' => 5,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ],
//             [
//                 'rule_name' => 'Datang Tepat Waktu',
//                 'condition_operator' => 'between',
//                 'condition_value' => '06:30:00-07:00:00',
//                 'point_modifier' => 3,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ],
//             [
//                 'rule_name' => 'Terlambat',
//                 'condition_operator' => '>',
//                 'condition_value' => '07:00:00',
//                 'point_modifier' => -3,
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ],
//         ]);
//     }
// }