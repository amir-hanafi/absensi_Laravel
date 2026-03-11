<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentCategory;
use Carbon\Carbon;

class AssessmentCategorySeeder extends Seeder
{
    public function run(): void
    {
        AssessmentCategory::insert([
            [
                'name' => 'Disiplin',
                'description' => 'Datang tepat waktu',
                'type' => 'Student',
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kerjasama',
                'description' => 'Bekerja dengan tim',
                'type' => 'Student',
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Tanggung Jawab',
                'description' => 'Menyelesaikan tugas',
                'type' => 'Student',
                'is_active' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}