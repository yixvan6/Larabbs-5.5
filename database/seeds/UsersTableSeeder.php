<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 10)->make();

        $users = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($users);

        // 单独处理 1 号用户
        $user = User::find(1);
        $user->name = 'yixvan6';
        $user->email = '928208626@qq.com';
        $user->avatar = 'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200';
        $user->save();
    }
}
