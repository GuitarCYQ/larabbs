<?php

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

return [
    //页面标题
    'title' =>  '权限',

    //模型单数，用作页面[新建$single]
    'single'    =>  '权限',

    //数据类型，用作数据的CRUD
    'model' =>  Permission::class,

    //设置当前页面的访问权限，通过返回布尔值来控制权限。
    //返回True及通过权限验证，False则无权访问并从Menu中隐藏
    'permission'=> function()
    {
        return Auth::user()->can('manage_users');
    },

    //对CRUD动作的单独权限控制，通过返回布尔值来控制权限。
    'action_permissions'    =>  [
        //控制[新建按钮]的显示
        'create'    =>  function ($model) {
            return true;
        },
        //允许更新
        'update'    =>  function($model){
            return true;
        },
        //不允许删除
        'delete'    =>  function ($model) {
            return false;
        },
        //允许查看
        'view'    =>  function($model){
            return true;
        },
    ],

    //字段负责渲染[数据表格]，有无数的[列组成]
    'columns'   =>  [

        //列的标示，这是一个最小化的[列]信息配置的例子,读取的是模型里对应的属性的是，如 $model->id
        'id'    =>[
            'title' =>  'ID',
        ],

        'name'  =>  [
            'title' =>  '标识',
        ],

        'operation' =>  [
            'title' =>  '管理',
            'sortable'  =>  false,
        ],
    ],

    //[模型表单] 设置项
    'edit_fields'   =>  [
        'name'  =>  [
            'title' =>  '标示（请慎重修改）',

            //表单条目标题旁的[提示消息]
            'hint'  =>  '修改权限标识会影响代码的调用，请不要轻易更改.'
        ],
        'roles' =>  [
            'type'  =>  'relationship',
            'title' =>  '角色',
            'name_field'    =>  'name',
        ],
    ],

    //[数据过滤]设置
    'filters'   =>  [
        'name'  =>  [
            'title' =>  '标识',
        ],
    ],



];