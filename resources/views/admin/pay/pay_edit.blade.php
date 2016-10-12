@extends('admin.layout.admin_index_layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('admin_common.Payment Options') }}
            <small>{{ trans('admin_common.Edit Payment Option') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin') }}"><i class="fa fa-dashboard"></i> {{ trans('admin_common.Home') }}</a></li>
            <li><a href="{{ url('admin/adtype') }}">{{ trans('admin_common.Payment Options') }}</a></li>
            <li class="active">{{ trans('admin_common.Edit Payment Option') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">{{ trans('admin_common.Edit Payment Option') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" method="post" name="edit_form" id="edit_form">
                        <div class="box-body">

                            {!! csrf_field() !!}

                            <div class="form-group required {{ $errors->has('pay_name') ? ' has-error' : '' }}">
                                <label for="pay_name" class="control-label">{{ trans('admin_common.Payment Name') }}</label>
                                <input type="text" class="form-control" name="pay_name" id="pay_name" placeholder="{{ trans('admin_common.Payment Name') }}" value="{{ Util::getOldOrModelValue('pay_name', $modelData) }}">
                                @if ($errors->has('pay_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('pay_sum') ? ' has-error' : '' }}">
                                <label for="pay_sum" class="control-label">{{ trans('admin_common.Payment Sum') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pay_sum" id="pay_sum" placeholder="{{ trans('admin_common.Payment Sum') }}" value="{{ Util::getOldOrModelValue('pay_sum', $modelData) }}">
                                    <span class="input-group-addon">{{ config('dc.site_price_sign') }}</span>
                                </div>
                                @if ($errors->has('pay_sum'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_sum') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('pay_promo_period') ? ' has-error' : '' }}">
                                <label for="pay_promo_period" class="control-label">{{ trans('admin_common.Payment Promo Period') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pay_promo_period" id="pay_promo_period" placeholder="{{ trans('admin_common.Payment Promo Period') }}" value="{{ Util::getOldOrModelValue('pay_promo_period', $modelData) }}">
                                    <span class="input-group-addon">{{ trans('admin_common.Days') }}</span>
                                </div>
                                @if ($errors->has('pay_promo_period'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_promo_period') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('pay_info_url') ? ' has-error' : '' }}">
                                <label for="pay_info_url" class="control-label">{{ trans('admin_common.Payment Info Url') }}</label>
                                <input type="text" class="form-control" name="pay_info_url" id="pay_info_url" placeholder="{{ trans('admin_common.Payment Info Url') }}" value="{{ Util::getOldOrModelValue('pay_info_url', $modelData) }}">
                                @if ($errors->has('pay_info_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_info_url') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_sms_prefix') ? ' has-error' : '' }}">
                                <label for="pay_sms_prefix" class="control-label">{{ trans('admin_common.Payment SMS Prefix') }}</label>
                                <input type="text" class="form-control" name="pay_sms_prefix" id="pay_sms_prefix" placeholder="{{ trans('admin_common.Payment SMS Prefix') }}" value="{{ Util::getOldOrModelValue('pay_sms_prefix', $modelData) }}">
                                @if ($errors->has('pay_sms_prefix'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_sms_prefix') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_number') ? ' has-error' : '' }}">
                                <label for="pay_number" class="control-label">{{ trans('admin_common.Payment Phone Number') }}</label>
                                <input type="text" class="form-control" name="pay_number" id="pay_number" placeholder="{{ trans('admin_common.Payment Phone Number') }}" value="{{ Util::getOldOrModelValue('pay_number', $modelData) }}">
                                @if ($errors->has('pay_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_secret') ? ' has-error' : '' }}">
                                <label for="pay_secret" class="control-label">{{ trans('admin_common.Payment Secret') }}</label>
                                <input type="text" class="form-control" name="pay_secret" id="pay_secret" placeholder="{{ trans('admin_common.Payment Secret') }}" value="{{ Util::getOldOrModelValue('pay_secret', $modelData) }}">
                                @if ($errors->has('pay_secret'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_secret') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group required {{ $errors->has('pay_description') ? ' has-error' : '' }}">
                                <label for="ad_description" class="control-label">{{ trans('admin_common.Payment Description') }}</label>
                                <textarea class="form-control" name="pay_description" id="pay_description" rows="{{ config('dc.num_rows_ad_description_textarea') }}">{{ Util::getOldOrModelValue('pay_description', $modelData) }}</textarea>
                                @if ($errors->has('pay_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_ping_url') ? ' has-error' : '' }}">
                                <label for="pay_ping_url" class="control-label">{{ trans('admin_common.Payment Ping Url') }}</label>
                                <input type="text" class="form-control" name="pay_ping_url" id="pay_ping_url" placeholder="{{ trans('admin_common.Payment Ping Url') }}" value="{{ Util::getOldOrModelValue('pay_ping_url', $modelData) }}" readonly>
                                @if ($errors->has('pay_ping_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_ping_url') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_allowed_ip') ? ' has-error' : '' }}">
                                <label for="pay_allowed_ip" class="control-label">{{ trans('admin_common.Payment Allowed IP') }}</label>
                                <input type="text" class="form-control" name="pay_allowed_ip" id="pay_allowed_ip" placeholder="{{ trans('admin_common.Payment Allowed IP') }}" value="{{ Util::getOldOrModelValue('pay_allowed_ip', $modelData) }}">
                                @if ($errors->has('pay_allowed_ip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_allowed_ip') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <hr>

                            <div class="form-group {{ $errors->has('pay_testmode') ? ' has-error' : '' }}">
                                <label for="pay_testmode" class="control-label">{{ trans('admin_common.Payment Test Mode (Sandbox)') }}</label>
                                <input type="text" class="form-control" name="pay_testmode" id="pay_testmode" placeholder="{{ trans('admin_common.Payment Test Mode (Sandbox)') }}" value="{{ !empty(Util::getOldOrModelValue('pay_testmode', $modelData)) ? Util::getOldOrModelValue('pay_testmode', $modelData) : '0' }}">
                                <span class="help-block">
                                    <strong>{{ trans('admin_common.1 = enable, 0 = disable') }}</strong>
                                </span>
                                @if ($errors->has('pay_testmode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_testmode') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_paypal_mail') ? ' has-error' : '' }}">
                                <label for="pay_paypal_mail" class="control-label">{{ trans('admin_common.Payment Mail') }}</label>
                                <input type="text" class="form-control" name="pay_paypal_mail" id="pay_paypal_mail" placeholder="{{ trans('admin_common.Payment Mail') }}" value="{{ Util::getOldOrModelValue('pay_paypal_mail', $modelData) }}">
                                <span class="help-block">
                                    <strong>{{ trans('admin_common.For example Paypal Mail') }}</strong>
                                </span>
                                @if ($errors->has('pay_paypal_mail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_paypal_mail') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_sum_to_charge') ? ' has-error' : '' }}">
                                <label for="pay_sum_to_charge" class="control-label">{{ trans('admin_common.Payment Sum To be Charged') }}</label>
                                <input type="text" class="form-control" name="pay_sum_to_charge" id="pay_sum_to_charge" placeholder="{{ trans('admin_common.Payment Sum To be Charged') }}" value="{{ Util::getOldOrModelValue('pay_sum_to_charge', $modelData) }}">
                                @if ($errors->has('pay_sum_to_charge'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_sum_to_charge') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_currency') ? ' has-error' : '' }}">
                                <label for="pay_currency" class="control-label">{{ trans('admin_common.Payment Currency') }}</label>
                                <input type="text" class="form-control" name="pay_currency" id="pay_currency" placeholder="{{ trans('admin_common.Payment Currency') }}" value="{{ Util::getOldOrModelValue('pay_currency', $modelData) }}">
                                @if ($errors->has('pay_currency'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_currency') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_locale') ? ' has-error' : '' }}">
                                <label for="pay_locale" class="control-label">{{ trans('admin_common.Payment Locale') }}</label>
                                <input type="text" class="form-control" name="pay_locale" id="pay_locale" placeholder="{{ trans('admin_common.Payment Locale') }}" value="{{ Util::getOldOrModelValue('pay_locale', $modelData) }}">
                                <span class="help-block">
                                    <strong>{{ trans('admin_common.For example Paypal Inerface Language') }}</strong>
                                </span>
                                @if ($errors->has('pay_locale'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_locale') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_log') ? ' has-error' : '' }}">
                                <label for="pay_log" class="control-label">{{ trans('admin_common.Payment Log') }}</label>
                                <input type="text" class="form-control" name="pay_log" id="pay_log" placeholder="{{ trans('admin_common.Payment Log') }}" value="{{ !empty(Util::getOldOrModelValue('pay_log', $modelData)) ? Util::getOldOrModelValue('pay_log', $modelData)  : '0' }}">
                                <span class="help-block">
                                    <strong>{{ trans('admin_common.1 = enable, 0 = disable') }}</strong>
                                </span>
                                @if ($errors->has('pay_log'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_log') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('pay_page_name') ? ' has-error' : '' }}">
                                <label for="pay_page_name" class="control-label">{{ trans('admin_common.Payment Page Web Address') }}</label>
                                <input type="text" class="form-control" name="pay_page_name" id="pay_page_name" placeholder="{{ trans('admin_common.Payment Page Web Address') }}" value="{{ Util::getOldOrModelValue('pay_page_name', $modelData) }}" readonly>
                                @if ($errors->has('pay_page_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_page_name') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <hr>

                            <div class="form-group required {{ $errors->has('pay_ord') ? ' has-error' : '' }}">
                                <label for="pay_ord" class="control-label">{{ trans('admin_common.Payment Order') }}</label>
                                <input type="text" class="form-control" name="pay_ord" id="pay_ord" placeholder="{{ trans('admin_common.Payment Order') }}" value="{{ Util::getOldOrModelValue('pay_ord', $modelData) }}">
                                @if ($errors->has('pay_ord'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pay_ord') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="pay_active" id="pay_active" {{ Util::getOldOrModelValue('pay_active', $modelData) > 0 ? 'checked' : '' }}> {{ trans('admin_common.Payment Active') }}
                                </label>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('admin_common.Save') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection