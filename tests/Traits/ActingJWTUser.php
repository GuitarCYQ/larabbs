<?php

namespace Tests\Traits;

use App\Models\User;

trait ActingJWTUser
{
    public function JWTActingAs(User $user)
    {
        //生成token 以备测试使用
        $token = auth('api')->fromUser($user);
        $this->withHeaders(['Authorization' => 'Bearer '.$token]);

        return $this;
    }
}
