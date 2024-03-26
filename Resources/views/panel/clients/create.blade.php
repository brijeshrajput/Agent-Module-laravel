@extends('agent::layouts.app')

@section('title')
    {{ __('New Client') }}
@endsection

@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ __('Add New Client') }}</h1>
        </div>
    </div>
</div>

<div class="aiz-titlebar mt-2 mb-4">
    <ul class="step-wizard-list">
        <li class="step-wizard-item" id="step-1">
            <span class="progress-count">1</span>
            <span class="progress-label">Registration</span>
        </li>
        <li class="step-wizard-item" id="step-2">
            <span class="progress-count">2</span>
            <span class="progress-label">Plan</span>
        </li>
        <li class="step-wizard-item" id="step-3">
            <span class="progress-count">3</span>
            <span class="progress-label">Theme</span>
        </li>
        <li class="step-wizard-item" id="step-4">
            <span class="progress-count">4</span>
            <span class="progress-label">Sub domain</span>
        </li>
        <li class="step-wizard-item" id="step-5">
            <span class="progress-count">5</span>
            <span class="progress-label">Payment</span>
        </li>
    </ul>
</div>

<x-error-msg/>
<x-flash-msg/>

<div class="client-form-container">
    <div class="loader-container"><div class="br-loader"></div><div class="loader-msg"></div></div>
    <div class="c-form-container"></div>
</div>


@endsection

@section('script')
    <script type="text/javascript">

    //show loader function
    function showLoader(msg = ''){
        $('.c-form-container').addClass('d-none');
        $('.loader-container').removeClass('d-none');
        $('.loader-msg').html(msg);
    }

    //hide loader function
    function hideLoader(){
        $('.loader-container').addClass('d-none');
        $('.c-form-container').removeClass('d-none');
    }

    function progress_count(page_id){
        $('#step-'+(page_id-1)).removeClass('current-item');
        $('#step-'+page_id).addClass('current-item');
    }

    //ajax call for getting the form
    function callform(page_id, client_id=-1, plan_id=-1, theme_slug=-1, subdomain=null){
        if(page_id==null || page_id==''){
            page_id = 1;
        }
        page_id = parseInt(page_id);
        client_id = parseInt(client_id);
        plan_id = parseInt(plan_id);
        //theme_id = parseInt(theme_id);
        progress_count(page_id);
        $.ajax({
            url: "{{ route('landlord.agent.client.form') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "page_id": page_id,
                "client_id": client_id,
                "plan_id": plan_id,
                "theme_slug": theme_slug,
                "subdomain": subdomain,
            },
            success: function(data){
                progress_count(page_id);
                hideLoader();
                $('.c-form-container').html(data);
            }
        });
    }

    $(document).ready(function(){
        showLoader();
        callform();
    });

    </script>
@endsection
