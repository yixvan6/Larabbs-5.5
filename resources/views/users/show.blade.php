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
                        <h4><strong>最后活跃</strong></h4>
                        <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
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
                    <li class="{{ active_class( ! if_query('tab', 'reply')) }}"><a href="{{ route('users.show', $user->id) }}">Ta 的话题</a></li>
                    <li class="{{ active_class(if_query('tab', 'reply')) }}"><a href="{{ route('users.show', [$user->id, 'tab' => 'reply']) }}">Ta 的回复</a></li>
                </ul>
                @if (if_query('tab', 'reply'))
                    @include('users._replies', ['replies' => $user->replies()->with('topic')->latest()->paginate(5)])
                @else
                    @include('users._topics', ['topics' => $user->topics()->latest()->paginate(5)])
                @endif
            </div>
        </div>

    </div>
</div>
@stop