<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmailContract
{

    use MustVerifyEmailTrait;
    //使用MustVerifyEmailTrait 可以有
    //1.检查用户Email是否已经认证
    //2.见用户标示为已认证
    //3.发送Email认证的消息通知，触发邮件的发送
    //4.获取发送邮件地址 提供这个接口允许你自定义邮件字段

    //HasRoles 获取到扩展包提供的所有权限和角色的操作方法
    use HasRoles;

    //发送通知
    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        //通过要通知的人时当前用户，就不必要通知了！
        if ($this->id == Auth::id()){
            return;
        }

        //职业数据库类型通知才需要提醒，直接发送Email 或者其他的都Pass
        if (method_exists($instance,'toDatabase')){
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);

    }

    //清除未读消息标示
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //用户与话题时一对多关系 一个用户拥有多个主题
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    //一个用户可以拥有多条评论
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}