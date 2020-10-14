<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //生成数据组合
        $users = factory(\App\Models\User::class)->times(10)->create();

        //单独处理第一个用户的数据
        $user = \App\Models\User::find(1);
        $user->name = 'Guitar';
        $user->email = "1@qq.com";
        $user->password = bcrypt('111111');
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->save();
    }
}
