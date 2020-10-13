<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class User extends Authenticatable implements MustVerifyEmailContract
{

    use Notifiable, MustVerifyEmailTrait;
    //使用MustVerifyEmailTrait 可以有
    //1.检查用户Email是否已经认证
    //2.见用户标示为已认证
    //3.发送Email认证的消息通知，触发邮件的发送
    //4.获取发送邮件地址 提供这个接口允许你自定义邮件字段

    protected $fillable = [
        'name', 'email', 'password','introduction','avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}