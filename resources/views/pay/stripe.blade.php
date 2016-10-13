@extends('layout.index_layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <form action="{{ url('stripe/' . $stripeData['paytype']) }}" method="POST">
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ $stripeData['publish_key'] }}"
                    data-amount="{{ $stripeData['sum_to_charge'] * 100 }}"
                    data-currency="{{ $stripeData['pay_currency'] }}"
                    data-name="{{ config('dc.site_domain') }}"
                    data-description="{{ trans('payment_stripe.Promo Option') }}"
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-zip-code="true"
                    data-label="{{ trans('payment_stripe.Click Here To Pay with Stripe') }}">
                </script>
            </form>
        </div>
    </div>
</div>
@endsection