@extends('layout.index_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">{{ session('message') }}</div>
        </div>
    </div>
</div>
@endsection