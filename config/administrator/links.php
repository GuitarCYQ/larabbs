<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Link;

return [
    //页面标题
    'title' =>  '资源推荐',

    //模型单数，用作页面[新建$single]
    'single'    =>  '资源推荐',

    //数据类型，用作数据的CRUD
    'model' =>  Link::class,

    //对CRUD动作的单独权限控制，通过返回布尔值来控制权限。
    'permission'    =>  function()
    {

            //只允许站长资源管理推荐链接
            return Auth::user()->hasRole('Founder');
    },

    //字段负责渲染[数据表格]，有无数的[列组成]
    'columns'   =>  [

        //列的标示，这是一个最小化的[列]信息配置的例子,读取的是模型里对应的属性的是，如 $model->id
        'id'    =>[
            'title' =>  'ID',
        ],

        'title'  =>  [
            'title' =>  '名称',
            'sortable'  =>  false,
        ],

        'link'  =>  [
            'title' =>  '链接',
            'sortable'  =>  false,
        ],

        'operation' =>  [
            'title' =>  '管理',
            'sortable'  =>  false,
        ],
    ],

    //[模型表单] 设置项
    'edit_fields'   =>  [
        'title'  =>  [
            'title' =>  '名称',
        ],
        'link' =>  [
            'title' =>  '链接',
        ],
    ],

    //[数据过滤]设置
    'filters'   =>  [
        'id'  =>  [
            'title' =>  '标签ID',
        ],

        'name'  =>  [
            'title' =>  '名称',
        ],

    ],




];


