@extends('layout.index_layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ trans('user.Home') }}</a></li>
                    <li class="active">{{ $user->name }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="media">
                            <div class="media-left">
                                <a href="{{ url('ad/user/' . $user->user_id) }}">
                                    @if(!empty($user->avatar))
                                        <img src="{{ asset('uf/udata/100_' . $user->avatar) }}" alt="{{ $user->name }}">
                                    @else
                                        <img src="{{ 'https://www.gravatar.com/avatar/' . md5(trim($user->email)) . '?s=100&d=identicon' }}" alt="{{ $user->name }}">
                                    @endif
                                </a>
                            </div>
                            <div class="media-body">
                                <h1 class="media-heading">{{ $user->name }}</h1>
                                <small><span class="text-muted">{{ trans('user.Registered') }}: {{ $user->created_at }}</span></small>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    @if(isset($user_ad_list) && !$user_ad_list->isEmpty())
                        @foreach ($user_ad_list as $k => $v)
                            @include('common.ad_list')
                        @endforeach
                    @endif
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection