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
        //生成数据组合
        $users = factory(\App\Models\User::class)->times(10)->create();

        //单独处理第一个用户的数据
        $user =User::find(1);
        $user->name = 'Guitar';
        $user->email = "1@qq.com";
        $user->password = bcrypt('111111');
        $user->avatar = 'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png';

        $user->save();

        //assignRole()方法在HasRoles中定义，我们已经在User模型中加载了它.
        //初始化用户角色，将1号用户指派为[站长]
        $user->assignRole('Founder');

        //将2号用户指派为[管理员]
        $user = User::find(2);
        $user->assignRole('Maintainer');


    }
}
