<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;

class TodosTableSeeder extends Seeder
{
    public function run()
    {
        // 20 sample todos To Be Created
        Todo::factory()->count(20)->create();
    }
}
