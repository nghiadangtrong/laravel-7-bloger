<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['PHP', 'Javascrip', 'Nodejs', 'HTML', 'CSS'];

        foreach($tags as $tag) {
            DB::table('tags')->insert(['name' => $tag]);
        }
    }
}
