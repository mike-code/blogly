<?php

use Illuminate\Database\Seeder;

class EntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i = 1; $i <= 32; $i++)
        {
            \App\Models\BlogEntry::create([
                'author_id' => rand(0,9),
                'author_name' => $faker->firstName,
                'title' => 'Hello World ' . $i,
                'content' => $faker->text(500),
                'is_published' => rand(0,1) ? true : false,
                'created_at' => $faker->dateTime()
            ]);
        }
    }
}
