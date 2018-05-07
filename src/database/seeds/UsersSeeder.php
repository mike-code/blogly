<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'Mike',
            'email' => 'mike@ring0.cc',
            'password' => bcrypt('lite'),
        ]);

        \DB::table('users')->insert([
            'name' => 'Editor',
            'email' => 'mike+editor@ring0.cc',
            'password' => bcrypt('lite'),
        ]);
    }
}
