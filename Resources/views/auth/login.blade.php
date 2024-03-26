@extends('landlord.frontend.frontend-page-master')

@section('title')
    {{__('Agent Login')}}
@endsection

@section('page-title')
    {{__('Agent Login')}}
@endsection

@section('content')
    <!-- sign-in area start -->
    <div class="sign-in-area-wrapper padding-top-100 padding-bottom-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-7 col-xl-6 col-xxl-5">
                    <div class="sign-in register signIn-signUp-wrapper">
                        <h4 class="title signin-contents-title">{{__('Sign In')}}</h4>
                        <div class="form-wrapper custom--form mt-5">
                            <x-error-msg/>
                            <x-flash-msg/>
                            <form action="" method="post" enctype="multipart/form-data" class="account-form" id="login_form_agent_page">
                                <div class="error-wrap"></div>
                                <div class="form-group single-input">
                                    <label for="exampleInputEmail1" class="label-title mb-3">{{__('Email')}}<span class="required">*</span></label>
                                    <input type="text" name="email" class="form-control form--control" id="exampleInputEmail1" placeholder="Type your email">
                                </div>
                                <div class="form-group single-input mt-4">
                                    <label for="exampleInputEmail1" class="label-title mb-3">{{__('Password')}}<span class="required">*</span></label>
                                    <input type="password" name="password" class="form-control form--control" id="exampleInputPassword1" placeholder="Password">
                                </div>

                                <div class="form-group single-input form-check mt-4">
                                    <div class="box-wrap">
                                        <div class="left">
                                            <div class="checkbox-inlines">
                                                <input type="checkbox" name="remember" class="form-check-input check-input" id="exampleCheck1">
                                                <label class="form-check-label checkbox-label" for="exampleCheck1">{{__('Remember me')}}</label>
                                            </div>
                                        </div>
                                        <div class="right forgot-password">
                                            <a href="{{route('landlord.agent.forget.password')}}" class="forgot-btn">{{__('Forgot Password?')}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-wrapper mt-4">
                                    <button type="submit" id="login_btn" class="cmn-btn cmn-btn-bg-1 w-100">{{__('Sign In')}}</button>
                                </div>
                            </form>
                            <p class="info mt-3">{{__("Don'/t have an account")}} <a href="{{route('landlord.agent.user.register')}}" class="active"> <strong>{{__('Sign up')}}</strong> </a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sign-in area end -->
@endsection

@section('scripts')
    {{--    Register Via Axax--}}
    <script>
        (function (){
        "use strict";

        $(document).on('click', '#login_btn', function (e) {
            e.preventDefault();
            var formContainer = $('#login_form_agent_page');
            var el = $(this);
            var email = formContainer.find('input[name="email"]').val();
            var password = formContainer.find('input[name="password"]').val();
            var remember = formContainer.find('input[name="remember"]').val();

            el.text('{{__("Please Wait")}}');

            $.ajax({
                type: 'post',
                url: "{{route('landlord.agent.ajax.login')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    email : email,
                    password : password,
                    remember : remember,
                },
                success: function (data){
                    if(data.status == 'invalid'){
                        el.text('{{__("Login")}}')
                        formContainer.find('.error-wrap').html('<div class="alert alert-danger">'+data.msg+'</div>');
                    }else{
                        formContainer.find('.error-wrap').html('');
                        el.text('{{__("Login Success.. Redirecting ..")}}');
                        location.reload();
                    }
                },
                error: function (data){
                    var response = data.responseJSON.errors
                    formContainer.find('.error-wrap').html('<ul class="alert alert-danger"></ul>');
                    $.each(response,function (value,index){
                        formContainer.find('.error-wrap ul').append('<li>'+value+'</li>');
                    });
                    el.text('{{__("Login")}}');
                }
            });
        });

    })(jQuery)
    </script>
@endsection
