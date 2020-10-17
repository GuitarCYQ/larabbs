<?php

use App\Models\Topic;

return [
    //页面标题
    'title' =>  '话题',

    //模型单数，用作页面[新建$single]
    'single'    =>  '话题',

    //数据类型，用作数据的CRUD
    'model' =>  Topic::class,

    //字段负责渲染[数据表格]，有无数的[列组成]
    'columns'   =>  [

        //列的标示，这是一个最小化的[列]信息配置的例子,读取的是模型里对应的属性的是，如 $model->id
        'id'    =>[
            'title' =>  'ID',
        ],

        'title'  =>  [
            'title' =>  '话题',
            'sortable'  =>  false,
            'output'    =>  function ($value, $model) {
            return '<div style="max-width: 260px">' . model_link($value, $model) . '</div>';
            },
        ],

        'user'  =>  [
            'title' =>  '作者',
            'sortable'  =>  false,
            'output'    =>  function ($value, $model) {
                $avatar = $model->user->avatar;
                $value = empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" style="height:22px;width:22px"> ' . $model->user->name;
                return model_link($value, $model->user);
            },
        ],

        'category' =>  [
            'title' =>  '分类',
            'sortable'  =>  false,
            'output'    =>  function ($value, $model) {
                return model_admin_link($model->category->name, $model->category);
            },
        ],

        'reply_count'   =>  [
            'title' =>  '评论',
        ],

        'operation' =>  [
            'title' =>  '管理',
            'sortable'  =>  false,
        ],
    ],

    //[模型表单] 设置项
    'edit_fields'   =>  [
        'name'  =>  [
            'title' =>  '标题',
        ],
        'user' =>  [
            'title' =>  '用户',
            'type'  =>  'relationship',
            'name_field'    =>  'name',

            //自动补全，对于大数据量的对于关系，他推荐开启自动补全, 可防止一次性加载对系统造成负担
            'autocomplete'  =>  true,

            //自动补全的搜索字段
            'search_fields' =>  ["CONCAT(id,' ',name)"],

            //自动补全的搜索字段
            'options_sort_field'    =>  'id',
        ],

        'category'  =>  [
            'title' =>  '分类',
            'type'  =>  'relationship',
            'name_field'    =>  'name',
            'search_fields'  =>  ["CONCAT(id, ' ', name)"],
            'options_sort_field'    =>  'id',
        ],

        'reply_count'   =>  [
            'title' =>  '评论',
        ],

        'view_count'    =>  [
            'title' =>  '查看',
        ],
    ],

    //[数据过滤]设置
    'filters'   =>  [
        'id'  =>  [
            'title' =>  '内容ID',
        ],

        'user'  =>  [
            'title' =>  '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],

        'category' => [
            'title'              => '分类',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
    ],

    'rules' =>  [
        'name'  => 'required'
    ],

    'messages'  =>  [
        'name.required' =>  '请填写标题',
    ]



];


