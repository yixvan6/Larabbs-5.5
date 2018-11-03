@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

    <div class="col-md-3 hidden-sm user-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <img class="thumbnail img-responsive" src="{{ $user->avatar }}" height="300px">
                    </div>
                    <div class="media-body">
                        <hr>
                        <h4><strong>个人简介</strong></h4>
                        <p>{{ $user->intro }}</p>
                        <hr>
                        <h4><strong>注册于</strong></h4>
                        <p title="{{ $user->created_at }}">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <span>
                    <h1 class="panel-title pull-left" style="font-size:30px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                </span>
            </div>
        </div>
        <hr>

        {{-- 用户发布的内容 --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Ta 的话题</a></li>
                    <li><a href="#">Ta 的回复</a></li>
                </ul>
                @include('users._topics', ['topics' => $user->topics()->latest()->paginate(5)])
            </div>
        </div>

    </div>
</div>
@stop