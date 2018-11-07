<?php

use App\Models\Category;

return [
    'title'   => '分类',
    'single'  => '分类',
    'model'   => Category::class,

    // 对 CRUD 动作的单独权限控制，其他动作不指定默认为通过
    'action_permissions' => [
        // 删除权限控制
        'delete' => function () {
            // 只有站长才能删除话题分类
            return Auth::user()->hasRole('Founder');
        },
    ],

    'columns' => [
        'id',
        'name' => [
            'title'    => '名称',
            'output' => function ($value, $model) {
                return '<a href="/categories/'.$model->id.'" target="_blank">'.$value.'</a>';
            },
        ],
        'description' => [
            'title'    => '描述',
            'sortable' => false,
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'name' => [
            'title' => '名称',
        ],
        'description' => [
            'title' => '描述',
            'type'  => 'textarea',
        ],
    ],

    'filters' => [
        'id' => [
            'title' => '分类 ID',
        ],
        'name' => [
            'title' => '名称',
        ],
        'description' => [
            'title' => '描述',
        ],
    ],

    'rules' => [
        'name' => 'required|min:2|unique:categories'
    ],
    'messages' => [
        'name.unique' => '分类名已存在，请选用其他名称。',
    ],
];