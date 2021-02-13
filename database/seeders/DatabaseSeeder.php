<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Version;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Note::factory(1)->create();
        Version::factory(1)->create();
    }
}
