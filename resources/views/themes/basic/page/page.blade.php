@extends('layout.index_layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ trans('mailview.Home') }}</a></li>
                    <li class="active">{{ $pageData->page_title }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>{{ $pageData->page_title }}</h1>
        {!! $pageData->page_content !!}
    </div>
@endsection