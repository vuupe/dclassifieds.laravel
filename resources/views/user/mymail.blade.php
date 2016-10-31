@extends('layout.index_layout')

@section('title', join(' / ', $title))

@section('search_filter')
    <div style="margin-bottom: 20px;"></div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> {{ trans('mymail.Home') }}</a></li>
                    <li class="active">{{ trans('mymail.My Messages') }}</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills">
                  <li role="presentation"><a href="{{ url('myprofile') }}">{{ trans('mymail.My Profile') }}</a></li>
                  <li role="presentation"><a href="{{ url('myads') }}">{{ trans('mymail.My Classifieds') }}</a></li>
                  <li role="presentation" class="active"><a href="{{ url('mymail') }}">{{ trans('mymail.My Messages') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container margin_bottom_15">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{ trans('mymail.My Messages') }} ({{ $mailList->count() }})</h2>
                    </div>
                </div>
                @if(!$mailList->isEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>{{ trans('mymail.Mail #') }}</th>
                                    <th>{{ trans('mymail.Ad #') }}</th>
                                    <th>{{ trans('mymail.Date') }}</th>
                                    <th>{{ trans('mymail.From') }}</th>
                                    <th>{{ trans('mymail.Text') }}</th>
                                    <th>{{ trans('mymail.Status') }}</th>
                                    <th>{{ trans('mymail.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($mailList as $k => $v)
                                <?$link = route('mailview', ['hash' => $v->mail_hash, 'user_id_from' => $v->user_id_from, 'mail_id' => $v->ad_id]);?>
                                <tr>
                                    <td>{{ $v->mail_id }}</td>
                                    <td>{{ $v->ad_id }}</td>
                                    <td>{{ $v->mail_date }}</td>
                                    <td>{{ $v->name }}</td>
                                    <td><a href="{{ $link }}">{{ str_limit($v->mail_text, 60) }}</a></td>
                                    <td>{{ $v->mail_status == 0 ? trans('mymail.New') : ''}}</td>
                                    <td nowrap>
                                        <a href="{{ $link }}" class="btn btn-primary btn-block btn-sm">{{ trans('mymail.View') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">{{ trans('mymail.You dont have messages.') }}</div>
                @endif
            </div>
        </div>
    </div>
@endsection