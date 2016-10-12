@extends('layout.index_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if ($paypalData['testmode'])
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> {{ trans('payment_paypal.Paypal is in sandbox mode') }}</div>
            @endif

            <form action="{{ $paypalData['action'] }}" method="post">
            <input type="hidden" name="cmd" value="_cart" />
            <input type="hidden" name="upload" value="1" />
            <input type="hidden" name="business" value="{{ $paypalData['business'] }}" />

            <input type="hidden" name="item_name_1" value="{{ trans('payment_paypal.Promo Option') }}" />
            <input type="hidden" name="item_number_1" value="{{ $paypalData['paytype'] }}" />
            <input type="hidden" name="amount_1" value="{{ number_format($paypalData['sum_to_charge'], 2, '.', '') }}" />
            <input type="hidden" name="quantity_1" value="1" />
            <input type="hidden" name="currency_code" value="{{ $paypalData['pay_currency'] }}" />

            <input type="hidden" name="lc" value="{{ $paypalData['pay_locale'] }}" />
            <input type="hidden" name="no_note" value="1" />
            <input type="hidden" name="no_shipping" value="1" />
            <input type="hidden" name="charset" value="utf-8" />
            <input type="hidden" name="return" value="{{ url('paypalsuccess?a=1') }}" />
            <input type="hidden" name="notify_url" value="{{ route('paypalcallback') }}" />
            <input type="hidden" name="cancel_return" value="{{ url('paypalsuccess?a=0') }}" />
            <input type="hidden" name="custom" value="{{ $paypalData['paytype'] }}" />
            <input type="hidden" name="bn" value="DC_3.0_BG" />
            <div class="buttons">
                <div class="pull-right">
                    <input type="submit" value="{{ trans('payment_paypal.Pay via Paypal') }}" class="btn btn-primary" />
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection