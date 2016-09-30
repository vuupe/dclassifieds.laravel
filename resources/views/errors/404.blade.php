@extends('layout.index_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">{{ trans('404.Ups something is missing.') }}</div>
        </div>
    </div>
</div>
@endsection