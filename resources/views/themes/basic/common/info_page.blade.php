@extends('layout.index_layout')

@if(isset($title))
    @section('title', join(' / ', $title))
@endif

@section('search_filter')
    <div style="margin-bottom: 20px;"></div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('message'))
                @if(is_array(session('message')))
                    @foreach(session('message') as $k => $v)
                        <div class="alert alert-info">{!! $v !!}</div>
                    @endforeach
                @else
                    <div class="alert alert-info">{!! session('message') !!}</div>
                @endif
            @else
                <div class="alert alert-info">{!! trans('info.Ups something is wrong') !!}</div>
            @endif
        </div>
    </div>
</div>
@endsection