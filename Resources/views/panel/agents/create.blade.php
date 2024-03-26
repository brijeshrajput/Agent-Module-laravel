@extends('agent::layouts.app')

@section('title')
    {{ __('New Agent') }}
@endsection

@php
    $referral_code = auth('agent')->user()->referral_code;
    if($referral_code == null){
        $referral_code = -1;
    }
@endphp

@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ __('Add New Agent') }}</h1>
        </div>
    </div>
</div>

<x-error-msg/>
<x-flash-msg/>

<form class="" action="{{route('landlord.agent.new.store')}}" method="POST" enctype="multipart/form-data" id="choice_form">
    <div class="row gutters-5">
        <div class="col-lg-8">
            @csrf
            <input type="hidden" name="sponsor_code" value="{{ $referral_code }}">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{__('Agent Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{__('Name*')}}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name"
                                placeholder="{{ __('Enter Agent Name') }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{__('Email*')}}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="email"
                                placeholder="{{ __('Enter Email') }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{__('Phone*')}}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="mobile"
                                placeholder="{{ __('Enter Phone') }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group row" id="gender">
                        <label class="col-md-3 col-from-label">{{__('Gender*')}}</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="gender" id="gender"
                                data-live-search="true" required>
                                <option value="Male" selected>{{ __('Male') }}</option>
                                <option value="Female">{{ __('Female') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{__('Password*')}}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="password"
                                placeholder="{{ __('It will be sent on mail (Auto Generated)') }}" readonly>
                        </div>
                    </div>
                    
                </div>
            </div>
            

        </div>
        <div class="col-8">
            <div class="mar-all text-right mb-2">
                <button type="submit" name="button" value="publish"
                    class="btn btn-primary">{{ __('Create') }}</button>
            </div>
        </div>
    </div>

</form>

@endsection
