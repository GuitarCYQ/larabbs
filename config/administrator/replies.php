<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Reply;

return [
    //页面标题
    'title' =>  '回复',

    //模型单数，用作页面[新建$single]
    'single'    =>  '回复',

    //数据类型，用作数据的CRUD
    'model' =>  Reply::class,

    //字段负责渲染[数据表格]，有无数的[列组成]
    'columns'   =>  [

        //列的标示，这是一个最小化的[列]信息配置的例子,读取的是模型里对应的属性的是，如 $model->id
        'id'    =>[
            'title' =>  'ID',
        ],

        'content'  =>  [
            'title' =>  '内容',
            'sortable'  =>  false,
            'output'    =>  function ($value, $model){
                return '<div style="max-width: 220px">' . $value . '</div>';
            },
        ],

        'user'  =>  [
            'title' =>  '作者',
            'sortable'  =>  false,
            'output'   => function ($value, $model) {
                $avatar = $model->user->avatar;
                $value = empty($avatar) ? 'N/A' : '<img src="'.$avatar.'" style="height:22px;width:22px"> ' . $model->user->name;
                return model_link($value, $model->user);
            },
        ],

        'topic' => [
            'title'    => '话题',
            'sortable' => false,
            'output'   => function ($value, $model) {
                //使用laravel自带的e()函数 将用户输入的内容进行转义处理
                return '<div style="max-width:260px">' . model_admin_link(e ($model->topic->title), $model->topic) . '</div>';
            },
        ],

        'operation' =>  [
            'title' =>  '管理',
            'sortable'  =>  false,
        ],
    ],

    //[模型表单] 设置项
    'edit_fields'   =>  [
        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'topic' => [
            'title'              => '话题',
            'type'               => 'relationship',
            'name_field'         => 'title',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',
        ],
        'content' => [
            'title'    => '回复内容',
            'type'     => 'textarea',
        ],
    ],

    //[数据过滤]设置
    'filters'   =>  [
        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', name)"),
            'options_sort_field' => 'id',
        ],
        'topic' => [
            'title'              => '话题',
            'type'               => 'relationship',
            'name_field'         => 'title',
            'autocomplete'       => true,
            'search_fields'      => array("CONCAT(id, ' ', title)"),
            'options_sort_field' => 'id',
        ],
        'content' => [
            'title'    => '回复内容',
        ],
    ],

    'rules' =>  [
        'name'  => 'required'
    ],

    'messages'  =>  [
        'name.required' =>  '请填写回复内容',
    ]



];


