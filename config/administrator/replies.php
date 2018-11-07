<?php

use App\Models\Reply;

return [
    'title'   => '回复',
    'single'  => '回复',
    'model'   => Reply::class,

    'columns' => [
        'id',
        'content' => [
            'title'    => '内容',
            'sortable' => false,
            'output'   => '<div style="max-width:220px">(:value)</div>',
        ],
        'user' => [
            'title'    => '作者',
            'output'   => function ($value, $model) {
                $user = $model->user;
                $img = empty($user->avatar) ? 'N/A' : '<img src="'.$user->avatar.'" style="width:22px">';
                return '<a href="/users/'.$user->id.'" target="_blank">'.$img.$user->name.'</a>';
            },
        ],
        'topic' => [
            'title'    => '话题',
            'sortable' => false,
            'output'   => function ($value, $model) {
                return '<a href="'.$model->topic->link().'" target="_blank">'.e($model->topic->title).'</a>';
            },
        ],
        'operation' => [
            'title'  => '管理',
            'sortable' => false,
        ],
    ],

    'edit_fields' => [
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

    'rules'   => [
        'content' => 'required'
    ],

    'messages' => [
        'content.required' => '请填写回复内容',
    ],
];