@extends('layout.index_layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ trans('password.Home') }}</a></li>
                    <li class="active">{{ trans('password.Lost Password') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-offset-2 col-md-10">
                        <h2>{{ trans('password.Lost Password') }}</h2>
                    </div>
                </div>

                @include('common.errors')
                @if (session()->has('status'))
                    <div class="alert alert-info">{{ session('status') }}</div>
                @endif

                <form class="form-horizontal" method="POST" action="{{url('lostpassword')}}">

                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="email" class="col-md-2 control-label">{{ trans('password.E-Mail') }}</label>
                        <div class="col-md-5">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10 margin_bottom_15">
                            <button type="submit" class="btn btn-primary">{{ trans('password.Send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
