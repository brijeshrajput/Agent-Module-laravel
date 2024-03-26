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
        <div class="br-discp">
            <p class="text-center">{{__('Your payment has been cancelled.')}}</p>
            <button class="btn btn-sm btn-primary br-btn">
                <a href="{{route('landlord.agent.dashboard')}}" class="">{{__('Back To Home')}}</a>
            </button>
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