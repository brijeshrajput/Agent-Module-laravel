@extends('landlord.admin.admin-master')

@section('title')
    {{__('Agent Settings')}}
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                <x-error-msg/>
                <x-flash-msg/>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <div class="left-content">
                                <h4 class="header-title">{{__('Setup Settings')}}</h4>
                            </div>
                        </div>

                        <p class="info">For First time setup, Click on <b>Setup Settings</b> and then click on <b>Database Upgrade</b> </p>

                        <form action="{{route('landlord.admin.agent.settings.startup')}}" method="POST" id="insert_settings_form" enctype="multipart/form-data">
                            @csrf
                            <x-fields.input type="hidden" value="setup_settings" name="setup_settings" />
                            <button class="btn btn-primary mt-4 pr-4 pl-4 insert-settings-submit-btn">{{__('Setup Settings')}}</button>
                        </form>

                        <br>

                        <form action="{{route('landlord.admin.general.database.upgrade.settings')}}" method="POST" id="cache_settings_form" enctype="multipart/form-data">
                            @csrf
                            <button class="btn btn-primary mt-4 pr-4 pl-4 clear-cache-submit-btn" data-value="cache">{{__('Database Upgrade')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <div class="left-content">
                                <h4 class="header-title">{{__('Basic Settings')}}</h4>
                            </div>
                        </div>
                        <form class="forms-sample" method="post" action="{{route('landlord.admin.agent.settings.basic')}}">
                            @csrf

                            <x-fields.switcher value="{{get_static_option('agent_email_verify_status')}}" name="agent_email_verify_status" label="{{__('Agent Email Verification')}}" info="{{__('Keep No to disable the email verification on new agents.')}}"/>
                            <br>
                            <x-fields.switcher value="{{get_static_option('earn_on_client')}}" name="earn_on_client" label="{{__('Earning on new Client Registration')}}" info="{{__('Keep No to disable the earning on new client registration')}}"/>
                            <x-fields.switcher value="{{get_static_option('mode_earn_on_client')}}" name="mode_earn_on_client" label="{{__('Earn fixed/Percent')}}" info="{{__('Keep No to earn fixed OR Keep Yes to earn percent per new client registration.')}}"/>
                            <x-fields.input type="number" value="{{get_static_option('amt_earn_on_client')}}" name="amt_earn_on_client" min="1" label="{{__('Fixed or Percent Amount')}}" info="{{__('Enter a fixed amount OR Percentage without any symbol.')}}"/>
                            <br>
                            <x-fields.switcher value="{{get_static_option('earn_on_agent')}}" name="earn_on_agent" label="{{__('Earning on new Agent Registration')}}" info="{{__('Keep No to disable the earning on new agent registration')}}"/>
                            <x-fields.switcher value="{{get_static_option('mode_earn_on_agent')}}" name="mode_earn_on_agent" label="{{__('Fixed/Percent on new Agent Registration')}}" info="{{__('Keep No to earn fixed OR Keep Yes to earn percent per new agent registration.')}}"/>
                            <x-fields.input type="number" value="{{get_static_option('amt_earn_on_agent')}}" name="amt_earn_on_agent" min="1" label="{{__('Fixed or Percent Amount')}}" info="{{__('Enter a fixed amount OR Percentage without any symbol.')}}"/>

                            <button type="submit" class="btn btn-gradient-primary mt-5 me-2">{{__('Save Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="header-wrap d-flex justify-content-between">
                            <div class="left-content">
                                <h4 class="header-title">{{__('Payment Settings')}}</h4>
                            </div>
                        </div>
                        <form class="forms-sample" method="post" action="{{route('landlord.admin.agent.settings.payments')}}">
                            @csrf

                            <x-fields.input type="number" value="{{get_static_option('agent_min_withdraw')}}" name="agent_min_withdraw" min="0" label="{{__('Minimum withdraw Balance')}}" info="{{__('It is the minimum withdraw balance which can be withdrawn by Agents.')}}"/>

                            <button type="submit" class="btn btn-gradient-primary mt-5 me-2">{{__('Save Changes')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(document).on('click','.swal_status_change',function(e){
                    e.preventDefault();
                    Swal.fire({
                        title: '{{__("Are you sure to change status?")}}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).next().find('.swal_form_submit_btn').trigger('click');
                        }
                    });
                });

                $(document).on('click','.clear-cache-submit-btn',function(e){
                    $(this).html('<i class="fas fa-spinner fa-spin"></i> {{__("Proccesing")}}')
                });
            });
        })(jQuery)
    </script>
@endsection

