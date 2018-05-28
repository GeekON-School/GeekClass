<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Tags')->insert([
            'id' => 1,
            'name' => "INVISIBLE_EVENT_TAG",
        ]);
    }
}
