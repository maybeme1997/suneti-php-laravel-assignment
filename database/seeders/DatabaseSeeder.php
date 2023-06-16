<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Writer;
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
        $publishers = Publisher::factory()->count(5)->create();

        $writers = Writer::factory()->count(5)->create();

        for ($i = 0; $i < 20; $i++) {
            Book::factory()
                ->for($publishers->random())
                ->for($writers->random())
                ->create();
        }
    }
}
