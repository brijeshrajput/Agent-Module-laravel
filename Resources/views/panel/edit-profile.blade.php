@extends('agent::layouts.app')

@section('title')
    {{ __('Edit Profile') }}
@endsection

@php
    $user = $user_details;
    $message = Session::get('msg');
@endphp

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ __('Manage Profile') }}</h1>
        </div>
      </div>
    </div>

    <x-error-msg/>
    <x-flash-msg/>

    <form action="{{ route('landlord.agent.profile.update') }}" method="POST" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="POST">
        @csrf
        <!-- Basic Info-->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ __('Basic Info')}}</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="name">{{ __('Your Name') }}</label>
                    <div class="col-md-10">
                        <input type="text" name="name" value="{{ $user->name }}" id="name" class="form-control" placeholder="{{ __('Your Name') }}" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="phone">{{ __('Your Phone') }}</label>
                    <div class="col-md-10">
                        <input type="text" name="phone" value="{{ $user->mobile }}" id="phone" class="form-control" placeholder="{{ __('Your Phone')}}">
                        @error('phone')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{ __('Photo') }}</label>
                    <div class="col-md-10">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ __('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ __('Choose File') }}</div>
                            <input type="hidden" name="photo" value="{{ $user->avatar_original }}" class="selected-files">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div> --}}
                
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{__('Update Profile')}}</button>
                </div>

            </div>
        </div>
    </form>

    <form action="{{ route('landlord.agent.password.change') }}" method="POST">
            @csrf
        <!-- Change Password-->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ __('Change Password')}}</h5>
            </div>
            <div class="card-body">
                
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="password">{{ __('Your Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" name="new_password" id="password" class="form-control" placeholder="{{ __('New Password') }}">
                        @error('new_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="confirm_password">{{ __('Confirm Password') }}</label>
                    <div class="col-md-10">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="{{ __('Confirm Password') }}" >
                        @error('confirm_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{__('Update Password')}}</button>
                </div>

            </div>
        </div>
    </form>

    <form action="{{ route('landlord.agent.payment.settings') }}" method="POST">
            @csrf
        <!-- Payment System -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ __('Payment Setting')}}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <label class="col-md-3 col-form-label">{{ __('Cash Payment') }}</label>
                    <div class="col-md-9">
                        <label class="aiz-switch aiz-switch-success mb-3">
                            <input name="cash_payment_status" type="checkbox" @if ($user->cash_payment_status) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label">{{ __('Bank Payment') }}</label>
                    <div class="col-md-9">
                        <label class="aiz-switch aiz-switch-success mb-3">
                            <input name="bank_payment_status" type="checkbox" @if ($user->bank_payment_status) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_name">{{ __('Bank Name') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_name" value="{{ $user->bank_name }}" id="bank_name" class="form-control mb-3" placeholder="{{ __('Bank Name')}}">
                        @error('phone')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_acc_name">{{ __('Bank Account Name') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_acc_name" value="{{ $user->bank_acc_name }}" id="bank_acc_name" class="form-control mb-3" placeholder="{{ __('Bank Account Name')}}">
                        @error('bank_acc_name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_acc_no">{{ __('Bank Account Number') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_acc_no" value="{{ $user->bank_acc_no }}" id="bank_acc_no" class="form-control mb-3" placeholder="{{ __('Bank Account Number')}}">
                        @error('bank_acc_no')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_branch">{{ __('Bank Branch') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_branch" value="{{ $user->bank_branch }}" id="bank_branch" class="form-control mb-3" placeholder="{{ __('Bank Branch')}}">
                        @error('bank_branch')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-3 col-form-label" for="bank_routing_no">{{ __('Bank Routing Number') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="bank_routing_no" value="{{ $user->bank_routing_no }}" id="bank_routing_no" lang="en" class="form-control mb-3" placeholder="{{ __('Bank Routing Number')}}">
                        @error('bank_routing_no')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mb-0 text-right">
            <button type="submit" class="btn btn-primary">{{__('Update Payments')}}</button>
        </div>
    </form>

    <br>
@endsection
