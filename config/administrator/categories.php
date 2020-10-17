<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Category;

return [
    //页面标题
    'title' =>  '分类',

    //模型单数，用作页面[新建$single]
    'single'    =>  '分类',

    //数据类型，用作数据的CRUD
    'model' =>  Category::class,

    //对CRUD动作的单独权限控制，通过返回布尔值来控制权限。
    'action_permissions'    =>  [
        //不允许删除
        'delete'    =>  function ($model) {
            return Auth::user()->hasRole('Founder');
        },
    ],

    //字段负责渲染[数据表格]，有无数的[列组成]
    'columns'   =>  [

        //列的标示，这是一个最小化的[列]信息配置的例子,读取的是模型里对应的属性的是，如 $model->id
        'id'    =>[
            'title' =>  'ID',
        ],

        'name'  =>  [
            'title' =>  '名称',
            'sortable'  =>  false,
        ],

        'description'  =>  [
            'title' =>  '描述',
            'sortable'  =>  false,
        ],

        'operation' =>  [
            'title' =>  '管理',
            'sortable'  =>  false,
        ],
    ],

    //[模型表单] 设置项
    'edit_fields'   =>  [
        'name'  =>  [
            'title' =>  '名称',
        ],
        'description' =>  [
            'title' =>  '描述',
            'type'  =>  'textarea'
        ],
    ],

    //[数据过滤]设置
    'filters'   =>  [
        'id'  =>  [
            'title' =>  '分类ID',
        ],

        'name'  =>  [
            'title' =>  '名称',
        ],

        'description'  =>  [
            'title' =>  '描述',
        ],
    ],

    'rules' =>  [
        'name'  => 'required|min:1|unique:categories'
    ],

    'messages'  =>  [
        'name.unique'   =>  '分类名在数据库里有重复，请选用其他名称.',
        'name.required' =>  '请确保名字至少一个字符以上',
    ]



];


