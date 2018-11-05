<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        $replys = factory(Reply::class, 500)->make();

        Reply::insert($replys->toArray());
    }

}

