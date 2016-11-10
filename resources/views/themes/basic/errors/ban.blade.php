@extends('layout.index_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if ($message)
            <div class="alert alert-danger">
                <h4><i class="icon fa fa-warning"></i> {{ trans('ban.You are banned.') }}</h4>
                {!! $message !!}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection