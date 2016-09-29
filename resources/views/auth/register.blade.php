@extends('layout.index_layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ trans('register.Home') }}</a></li>
                    <li class="active">{{ trans('register.Register') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
                        <h2>{{ trans('register.Register') }}</h2>
                    </div>
                </div>

                @include('common.errors')
                @if (session()->has('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif

                <form class="form-horizontal" method="POST" action="{{url('register')}}">

                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">{{ trans('register.Name') }}</label>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-md-2 control-label">{{ trans('register.E-Mail') }}</label>
                        <div class="col-md-5">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-2 control-label">{{ trans('register.Password') }}</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-md-2 control-label">{{ trans('register.Password Again') }}</label>
                        <div class="col-md-5">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <div class="checkbox">
                            <label>
                                <input type="checkbox" name="policy_agree"> {{ trans('register.I Agree with') }} <a href="">{{ trans('register."Privacy Policy"') }}</a>
                            </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="submit" class="btn btn-primary">{{ trans('register.Register') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
