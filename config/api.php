<?php

return [
    /***
     * 接口频率限制
     */
    'rate_limits'   =>  [
        //访问频率限制，次数/分数
        'access'    =>  env('RATE_LIMITS', '6000,1'),
        //登录相关，次数/分数
        'sign'  =>  env('SIGN_RATE_LIMITS', '10,1'),
    ],
];
