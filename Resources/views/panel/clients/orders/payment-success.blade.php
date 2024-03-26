@extends('agent::layouts.app')

@section('title')
    {{ __('Payment Success') }}
@endsection

@section('panel_content')
<div class="br-container">
    <div class="br-heading">
        <h2 class="br-h-heading">Payment Success</h2>
    </div>
    <div class="br-main">
        @if(empty($domain))
            <div class="alert alert-danger text-bold text-center mt-2">
                <i class="las la-info-circle"></i>
                {{__('Your website is not ready yet, you will get notified by email when it is ready.')}}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-6">
                <div class="single-billing-items">
                    <h2 class="billing-title">{{__('Order Details')}}</h2>
                    <ul class="billing-details mt-4">
                        <li><strong>{{__('Order ID:')}}</strong> #{{$payment_details->id}}</li>
                        <li class="text-capitalize"><strong>{{__('Payment Package:')}}</strong> {{$payment_details->package_name}}</li>
                        <li class="text-capitalize"><strong>{{__('Payment Package Type:')}}</strong> {{ \App\Enums\PricePlanTypEnums::getText(optional($payment_details->package)->type) }}</li>
                        <li class="text-capitalize"><strong>{{__('Payment Gateway:')}}</strong>
                            @php
                                $gateway = str_replace('_', ' ',$payment_details->package_gateway);
                            @endphp
                            {{$gateway}}
                        </li>
                        <li class="text-capitalize"><strong>{{__('Payment Status:')}}</strong> {{$payment_details->payment_status}}</li>
                        <li><strong>{{__('Transaction ID:')}}</strong> {{$payment_details->transaction_id}}</li>
        
                        @if(!empty($domain))
                            <li><strong>{{__('Shop URL:')}}</strong> <a href="{{tenant_url_with_protocol($domain->domain)}}" target="_blank">{{$domain->domain}}</a></li>
                        @endif
                    </ul>
                </div>
                <div class="single-billing-items mt-4">
                    <h2 class="billing-title">{{__('Billing Details')}}</h2>
                    <ul class="billing-details mt-4">
                        <li><strong>{{__('Name')}}</strong> {{$payment_details->name}}</li>
                        <li><strong>{{__('Email')}}</strong> {{$payment_details->email}}</li>
                    </ul>
                </div>
                <div class="btn-wrapper mt-5">
                    <button class="btn btn-sm btn-primary br-btn">
                    <a href="{{route('landlord.agent.dashboard')}}" class="">{{__('Back To Home')}}</a>
                    </button>
                    <button class="btn btn-sm btn-secondary br-btn">
                    @if(!empty($domain))
                        <a href="{{tenant_url_with_protocol($domain->domain)}}" class="" target="_blank">{{__('Open Shop')}} <i class="store-icon las la-store-alt"></i></a>
                    @endif
                    </button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="single-price-plan-item">
                    <div class="price-header">
                        <h3 class="title">{{ $payment_details->package_name}}</h3>
                        <div class="price-wrap mt-4"><span class="price">{{amount_with_currency_symbol($payment_details->package_price)}}</span>{{ $payment_details->type ?? '' }}</div>
                        <h5 class="title text-info mt-2">{{__('Start Date :')}}{{$payment_details->start_date ?? ''}}</h5>
                        <h5 class="title text-danger mt-2">{{__('Expire Date :')}}{{$payment_details->expire_date?->format('d-m-Y H:m:s') ?? 'Life Time'}}</h5>
                    </div>
                    <div class="price-body mt-4">
                        <ul class="features">
                            @if(!empty(optional($payment_details->package)->page_permission_feature))
                                <li class="check"> {{ sprintf(__('Page Create %d'),optional($payment_details->package)->page_permission_feature )}}</li>
                            @endif
        
                            @if(!empty(optional($payment_details->package)->blog_permission_feature))
                                <li class="check"> {{ sprintf(__('Blog Create %d'),optional($payment_details->package)->blog_permission_feature )}}</li>
                            @endif
        
                            @if(!empty(optional($payment_details->package)->service_permission_feature))
                                <li class="check"> {{ sprintf(__('Service Create %d'),optional($payment_details->package)->service_permission_feature )}}</li>
                            @endif
        
                            @foreach(optional($payment_details->package)->plan_features as $key=> $item)
                                <li class="check"> {{str_replace('_', ' ',ucfirst($item->feature_name)) ?? ''}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="price-footer pb-0">
        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.br-container{
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.br-heading{
    text-align: center;
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 20px;
}
.br-main{
    padding: 5vh;
    font-size: 20px;
    font-weight: 500;
}
.br-h-heading{
    color: green;
}
</style>


<style>
.billing-title {
    font-size: 28px;
    line-height: 1.3;
    color: #333;
}

.billing-details{
    list-style: none;
}

.billing-details li:not(:first-child) {
    margin-top: 10px;
}

.billing-details li {
    font-size: 16px;
    line-height: 24px;
    font-weight: 400;
    color: #333;
}

.billing-details li strong {
    color: #0000007a;
    font-weight: 500;
}

.billing-stat-expire .title {
    font-size: 18px;
    font-weight: 400;
    line-height: 1.3;
}

.billing-stat-expire .title:not(:last-child) {
    margin-bottom: 10px;
}

.br-btn a {
    color: #fff;
}
.br-btn a:hover {
    color: #fff;
}

.br-btn:hover {
    color: #7a7a7a;
    border: 1px solid #000000;
}

.single-price-plan-item {
    background: #fff;
    box-shadow: 0 0 20px #f2f2f2;
    padding: 20px;
    position: sticky;
    top: 0;
    z-index: 9;
}

.single-price-plan-item.price-plan-two {
    position: unset;
    padding: 30px;
}

.price-wrap .price {
    font-size: 36px;
    font-weight: 600;
    line-height: 1.2;
    color: #333;
    margin: -7px 0 0;
}

.price-body .features {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.features {
    margin: 0;
    padding: 0;
    list-style: none;
}
.price-body .features li {
    position: relative;
    padding-left: 30px;
    font-size: 16px;
    line-height: 1.4;
    font-weight: 400;
    color: #333;
    transition: all .3s;
}
.price-body .features li:hover {
    color: #df2c18;
}
.price-body .features li::before {
    content: "\f00c";
    font-family: "line awesome free";
    position: absolute;
    left: 0;
    top: 0px;
    font-weight: 900;
    color: #333;
    font-size: 18px;
}
</style>

@endsection