@extends('agent::layouts.app')

@section('title')
    {{ __('Payment Cancelled') }}
@endsection

@section('panel_content')
<div class="br-container">
    <div class="br-heading">
        <h2 class="br-h-heading">Payment Cancelled</h2>
    </div>
    <div class="br-main">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="order-cancel-area text-center">
                    <h1 class="title">{{get_static_option('site_order_cancel_page_title')}}</h1>
                    <h3 class="sub-title mt-3">
                        @php
                            $subtitle = get_static_option('site_order_cancel_page_subtitle');
                            $subtitle = str_replace('{pkname}',$order_details->package_name,$subtitle);
                        @endphp
                        {{$subtitle}}
                    </h3>
                    <p class="mt-4">
                        {{get_static_option('site_order_cancel_page_description')}}
                    </p>
                    <button class="btn btn-sm btn-primary br-btn">
                        <a href="{{route('landlord.agent.dashboard')}}" class="cmn-btn cmn-btn-bg-1">{{__('Back To Home')}}</a>
                    </button>
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
        color: red;
    }
    </style>

@endsection