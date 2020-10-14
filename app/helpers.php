<?php

//获取路由名称 例如www.larabbs.com/users/1 得到的就是users-show
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

//判断路由 添加active
function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category',$category_id)));
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/',' ', strip_tags($value)));
    return \Illuminate\Support\Str::limit($excerpt,$length);
}