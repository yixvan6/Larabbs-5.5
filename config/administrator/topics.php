<?php

use App\Models\Topic;

return [
    'title'   => '话题',
    'single'  => '话题',
    'model'   => Topic::class,

    'columns' => [
        'id',
        'title' => [
            'title'    => '话题',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return '<a href="'.$model->link().'" target="_blank">'.$value.'</a>';
            },
        ],
        'user' => [
            'title'    => '作者',
            'output'   => function ($value, $model) {
                $user = $model->user;
                $img = empty($user->avatar) ? 'N/A' : '<img src="'.$user->avatar.'" style="width:22px">';
                return '<a href="/users/'.$user->id.'" target="_blank">'.$img.$user->name.'</a>';
            },
        ],
        'category' => [
            'title'    => '分类',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return $model->category->name;
            },
        ],
        'reply_count' => [
            'title'    => '评论数',
        ],
        'view_count' => [
            'title' => '查看数',
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
        'title' => [
            'title'    => '标题',
        ],
        'user' => [
            'title'              => '用户',
            'type'               => 'relationship',
            'name_field'         => 'name',

            // 自动补全，对于大数据量的对应关系，推荐开启自动补全，
            // 可防止一次性加载对系统造成负担
            'autocomplete'       => true,

            // 自动补全的搜索字段
            'search_fields'      => ["CONCAT(id, ' ', name)"],

            // 自动补全排序
            'options_sort_field' => 'id',
        ],
        'category' => [
            'title'              => '分类',
            'type'               => 'relationship',
            'name_field'         => 'name',
            'search_fields'      => ["CONCAT(id, ' ', name)"],
            'options_sort_field' => 'id',
        ],
    ],

    'filters' => [
        'id',
        'user' => [
            'title'              => '用户',
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
];