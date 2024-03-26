@extends('agent::layouts.app')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('panel_content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 text-primary">{{ __('Dashboard') }}</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-xxl-3">
        <div class="card shadow-none mb-4 bg-primary py-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="small text-muted mb-0">
                            <span class="fe fe-arrow-down fe-12"></span>
                            <span class="fs-14 text-light">{{ __('Clients') }}</span>
                        </p>
                        <h3 class="mb-0 text-white fs-30">
                            {{ $agent->clients()->count() }}
                        </h3>

                    </div>
                    <div class="col-auto text-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64.001" height="64" viewBox="0 0 64.001 64">
                            <path d="M41.6 44.3c-2.6-1.3-6-3.7-6-5.8 0-1.1.4-1.8.8-2 5-2.8 6.7-12 7-12 1.7 0 2.9-4.3 2.9-7.1 0-2.3-.7-2.2-1.9-2.9v-.3C44.4 6.7 38.5 1 31.1 1c-7.3 0-13.6 6-13.6 13.4v.3c-1.2.7-1.7 1.1-1.7 3.3 0 2.9 1 6.9 2.7 6.9.3 0 2.5 8.8 7.3 11.8.3.2.8.7.8 1.7 0 2.4-3.2 4.5-5.9 5.9C17.4 46 1 47.4 1 63h60c0-15.6-15.3-16.6-19.4-18.7Z" stroke="#FFFFFF" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-xxl-3">
        <div class="card shadow-none mb-4 bg-primary py-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="small text-muted mb-0">
                            <span class="fe fe-arrow-down fe-12"></span>
                            <span class="fs-14 text-light">{{ __('Agent Referrals') }}</span>
                        </p>
                        <h3 class="mb-0 text-white fs-30">
                            {{ \Modules\Agent\Entities\Agent::where('sponsor_id', Auth::guard('agent')->user()->referral_code)->count() }}
                        </h3>

                    </div>
                    <div class="col-auto text-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="61.143" viewBox="0 0 64 61.143">
                            <path id="Path_57" data-name="Path 57"
                                d="M63.286,22.145a2.821,2.821,0,0,0-1.816-.926L43.958,19.455a2.816,2.816,0,0,1-2.294-1.666L34.574,1.68a2.813,2.813,0,0,0-5.148,0l-7.09,16.11a2.813,2.813,0,0,1-2.292,1.666L2.53,21.219a2.813,2.813,0,0,0-1.59,4.9l13.13,11.72a2.818,2.818,0,0,1,.876,2.7l-3.734,17.2a2.812,2.812,0,0,0,4.166,3.026L30.584,51.9a2.8,2.8,0,0,1,2.832,0l15.206,8.864a2.813,2.813,0,0,0,4.166-3.026l-3.734-17.2a2.818,2.818,0,0,1,.876-2.7l13.13-11.72a2.813,2.813,0,0,0,.226-3.972m-1.5,2.546L48.658,36.413a4.717,4.717,0,0,0-1.47,4.524l3.732,17.2a.9.9,0,0,1-1.336.97l-15.2-8.866a4.729,4.729,0,0,0-4.758,0L14.416,59.109a.9.9,0,0,1-1.336-.97l3.732-17.2a4.717,4.717,0,0,0-1.47-4.524L2.212,24.691a.9.9,0,0,1,.51-1.57l17.512-1.766a4.721,4.721,0,0,0,3.85-2.8l7.09-16.11a.9.9,0,0,1,1.652,0l7.09,16.11a4.721,4.721,0,0,0,3.85,2.8l17.512,1.766a.9.9,0,0,1,.51,1.57"
                                transform="translate(0 0)" fill="#FFFFFF" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-xxl-3">
        <div class="card shadow-none mb-4 bg-primary py-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="small text-muted mb-0">
                            <span class="fe fe-arrow-down fe-12"></span>
                            <span class="fs-14 text-light">{{ __('Wallet Balance') }}</span>
                        </p>
                        <h3 class="mb-0 text-white fs-30">
                            {{ amount_with_currency_symbol($agent->wallet->balance) }}
                        </h3>
                    </div>
                    <div class="col-auto text-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="-0.019 3.825 81.957 74.272">
                            <path id="Path_57" data-name="Path 57" d="M76.774 21.786c.035-1.775-.443-5.914-5.838-7.355L16.755 3.585a7.207 7.207 0 0 0-7.2 7.2v9.653l-2.4-.006c-3.956.017-7.173 3.236-7.173 7.197v38.386c0 3.971 3.229 7.2 7.2 7.2h62.435c3.971 0 7.2-3.229 7.2-7.2zm-62.42-11.002a2.402 2.402 0 0 1 2.191-2.391l52.95 10.716c.019.009-.394 1.345-2.316 1.32H14.354zm57.664 55.232a2.401 2.401 0 0 1-2.4 2.4H7.182a2.401 2.401 0 0 1-2.4-2.4V27.629a2.401 2.401 0 0 1 2.4-2.4h60.005c2.356 0 4.83-.802 4.83-2.392v43.178h.001zM14.387 42.038a4.8 4.8 0 1 0 0 9.6 4.8 4.8 0 0 0 0-9.6z" stroke="#FFF" stroke-width="1.875" fill="none"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-xxl-3">
        <div class="card shadow-none mb-4 bg-primary py-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <p class="small text-muted mb-0">
                            <span class="fe fe-arrow-down fe-12"></span>
                            <span class="fs-14 text-light">{{ __('Total Earning') }}</span>
                        </p>
                        <h3 class="mb-0 text-white fs-30">
                            {{ amount_with_currency_symbol($agent->commissions->sum('amount')) }}
                        </h3>

                    </div>
                    <div class="col-auto text-right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64.001" viewBox="0 0 2.56 2.56">
                            <g clip-path="url(#a)"><path d="M1.2 1.36a.24.24 0 0 0-.24-.24m0 0a.24.24 0 1 0 0 .48.24.24 0 1 1 0 .48m0-.96v-.08m0 1.04a.24.24 0 0 1-.24-.24m.24.24v.08m.8.32h.72v-.16M2 2.08h.48v-.16m-.4-.24h.4v-.16m-.4-.24h.4v-.16M1.84.88h.64V.72M.8.48h1.68v-.4H.56v.4M1.84 1.6a.88.88 0 1 0-1.76 0 .88.88 0 0 0 1.76 0Z" stroke="#FFF" stroke-width=".08" fill="none" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="a"><path fill="#FFF" d="M0 0h2.56v2.56H0V0z"/></clipPath></defs>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
        <div class="card shadow-none bg-soft-primary">
            <div class="card-body">
                <div class="card-title text-primary fs-16 fw-600">
                    {{ __('Commission Stat') }}
                </div>
                <canvas id="graph-1" class="w-100" height="150"></canvas>
            </div>
        </div>
        <div class="card shadow-none bg-soft-primary mb-0">

            @php
                $date = date('Y-m-d');
                $days_ago_30 = date('Y-m-d', strtotime('-30 days', strtotime($date)));
                $days_ago_60 = date('Y-m-d', strtotime('-60 days', strtotime($date)));
                
                $orderTotal = \Modules\Agent\Entities\AgentCommission::where('agent_id', Auth::guard('agent')->user()->id)
                    ->where('created_at', '>=', $days_ago_30)
                    ->sum('amount');
            @endphp

            <div class="card-body">
                <div class="card-title text-primary fs-16 fw-600">
                    {{ __('Commission Amount') }}
                </div>
                <p>{{ __('Your Commission Amount (Current month)') }}:</p>
                <h3 class="text-primary fw-600 fs-30">
                    {{ amount_with_currency_symbol($orderTotal) }}
                </h3>
                <p class="mt-4">
                    @php
                        $orderTotal = \Modules\Agent\Entities\AgentCommission::where('agent_id', Auth::guard('agent')->user()->id)
                            ->where('created_at', '>=', $days_ago_60)
                            ->where('created_at', '<=', $days_ago_30)
                            ->sum('amount');
                    @endphp
                    {{ __('Last Month') }}: {{ amount_with_currency_symbol($orderTotal) }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
        <div class="card shadow-none h-450px mb-0 h-100">
            <div class="card-body">
                <div class="card-title text-primary fs-16 fw-600">
                    {{ __('Recent Agent Referrals') }}
                </div>
                <hr>
                <ul class="list-group">
                    @foreach (\Modules\Agent\Entities\Agent::where('sponsor_id', Auth::guard('agent')->user()->referral_code)->get() as $key => $agt)
                            <li class="d-flex justify-content-between align-items-center my-2 text-primary fs-13">
                                {{ $agt->name }}
                                <span class="">
                                    {{ $agt->created_at->diffForHumans() }}
                                </span>
                            </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
        <div class="card h-450px mb-0 h-100">
            <div class="card-body">
                <div class="card-title text-primary fs-16 fw-600">
                    {{ __('Package sales') }}
                </div>
                <hr>
                <ul class="list-group">
                    @foreach (\App\Models\PricePlan::all() as $key => $plan)
                        @php
                            $total_pkg = \App\Models\PaymentLogs::where('id', function($q){
                            $q->select('payment_log_id')
                                ->from('agent_commissions')
                                ->where('agent_id', Auth::guard('agent')->user()->id);
                            })->where('package_id', $plan->id)->get();
                            //dd($total_pkg);
                        @endphp
                        @if (count($total_pkg) > 0)
                            <li class="d-flex justify-content-between align-items-center my-2 text-primary fs-13">
                                {{ $plan->title }}
                                <span class="">
                                    {{ count($total_pkg) }}
                                </span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
        @if (1)
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h6 class="mb-0">{{ __('Active Withdraw Request') }}</h6>
                    </div>
                    <hr>
                    @if (count($agent->withdrawRequests->where('status', 0)) )
                        <div class="d-flex">
                            <div class="col-12">
                                <a class="fw-600 mb-3 text-primary">{{ __('Current Requests') }}:</a>
                                <h6 class="text-primary">
                                    
                                    @foreach($agent->withdrawRequests->where('status', 0) as $key => $request)
                                        <div class="d-flex justify-content-between align-items-center my-2 text-primary fs-13">
                                            {{ amount_with_currency_symbol($request->amount) }}
                                            <span class="">
                                                {{ $request->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    @endforeach
                                    <br><br>
                                    <div class="">
                                        <a href="{{ route('landlord.agent.wallet') }}"
                                            class="btn btn-soft-primary">{{ __('Withdraw Request') }}</a>
                                    </div>
                                </h6>
                            </div>
                        </div>
                    @else
                        <h6 class="fw-600 mb-3 text-primary">{{ __('No request active') }}</h6>
                    @endif

                </div>
            </div>
        @endif
        <div class="card mb-0 @if ($agent->verification_status == 1)) px-4 py-5 @else p-5 h-100 @endif d-flex align-items-center justify-content-center">
            @if ($agent->verification_status != 1)
                <div class="my-n4 py-1 text-center">
                    <img src="{{ global_asset('assets/bvendor/imgs/non_verified.png') }}" alt=""
                        class="w-xxl-130px w-90px d-block">
                    <a href="{{ route('landlord.agent.kyc.verify') }}"
                        class="btn btn-sm btn-primary">{{ __('Verify Now') }}</a>
                </div>
            @else
                <div class="my-2 py-1">
                    <img src="{{ global_asset('assets/bvendor/imgs/verified1.png') }}" alt="" width="">
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-3">
        <a href="{{ route('landlord.agent.wallet') }}"
            class="card mb-4 p-4 text-center bg-soft-primary h-180px">
            <div class="fs-16 fw-600 text-primary">
                {{ __('Money Withdraw') }}
            </div>
            <div class="m-3">
                <svg id="Group_22725" data-name="Group 22725" xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                    viewBox="0 0 48 48">
                    <g data-name="17. Withdraw" fill="#2e294e" stroke-width="1.875" fill="none"><path d="M46.5 0h-45A1.5 1.5 0 0 0 0 1.5v18A1.5 1.5 0 0 0 1.5 21H9v25.5a1.5 1.5 0 0 0 1.5 1.5h27a1.5 1.5 0 0 0 1.5-1.5V21h7.5a1.5 1.5 0 0 0 1.5-1.5v-18A1.5 1.5 0 0 0 46.5 0ZM3 3h42v3H3Zm33 42H12V15h24Zm9-27h-6v-3h1.5a1.5 1.5 0 0 0 0-3h-33a1.5 1.5 0 0 0 0 3H9v3H3V9h42Z"/><path d="M43.5 34.5A1.5 1.5 0 0 0 42 36v6a1.5 1.5 0 0 0 3 0v-6a1.5 1.5 0 0 0-1.5-1.5ZM4.5 24A1.5 1.5 0 0 0 3 25.5v6a1.5 1.5 0 0 0 3 0v-6A1.5 1.5 0 0 0 4.5 24Zm27 0h-.27a4.5 4.5 0 0 0-8.73 1.5 1.5 1.5 0 0 1-3 0v-3a1.5 1.5 0 0 0-3 0V24a1.5 1.5 0 0 0 0 3h.27a4.5 4.5 0 0 0 8.73-1.5 1.5 1.5 0 0 1 3 0v3a1.5 1.5 0 0 0 3 0V27a1.5 1.5 0 0 0 0-3ZM24 34.5a1.5 1.5 0 0 0-1.5 1.5v3a1.5 1.5 0 0 0 3 0v-3a1.5 1.5 0 0 0-1.5-1.5Z"/></g>
                </svg>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card mb-4 p-4 text-center bg-soft-primary">
            <div class="fs-16 fw-600 text-primary">
                {{ __('Agent Settings') }}
            </div>
            <div class=" m-3">
                <svg id="Group_31" data-name="Group 31" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                    viewBox="0 0 0.68 0.68">
                    <path d="M.34.239c-.055 0-.1.045-.1.1s.045.1.1.1.1-.045.1-.1-.045-.1-.1-.1zm0 .16C.307.399.28.372.28.339s.027-.06.06-.06.06.027.06.06-.027.06-.06.06zM.678.378.68.339.678.3.574.269A.239.239 0 0 0 .555.223L.606.128A.346.346 0 0 0 .551.073L.456.124A.243.243 0 0 0 .41.105L.379.001.34-.001.301.001.27.105a.235.235 0 0 0-.046.019L.129.073a.341.341 0 0 0-.055.055l.051.095a.242.242 0 0 0-.019.046L.002.3 0 .339a.51.51 0 0 0 .002.039l.104.031a.234.234 0 0 0 .019.046L.074.55C.09.57.109.589.129.605L.224.554c.014.008.03.014.046.019l.031.104.039.002.039-.002L.41.573A.234.234 0 0 0 .456.554l.095.051A.358.358 0 0 0 .606.55L.555.455A.234.234 0 0 0 .574.409L.678.378zM.542.377.536.398A.18.18 0 0 1 .52.436L.51.455l.01.019.038.071a.294.294 0 0 1-.012.012L.456.509l-.019.01a.204.204 0 0 1-.038.016L.378.541.372.562.349.639a.307.307 0 0 1-.017 0L.309.562.303.541.282.535A.2.2 0 0 1 .244.519L.225.509l-.09.048A.321.321 0 0 1 .123.545l.048-.09-.01-.019A.204.204 0 0 1 .145.398L.139.377.041.348a.204.204 0 0 1 0-.017L.139.302.145.281A.18.18 0 0 1 .161.243l.01-.019L.122.133A.352.352 0 0 1 .134.121l.09.048.019-.01A.254.254 0 0 1 .281.143L.302.137.308.116.331.039h.018l.023.077.006.021.021.006a.18.18 0 0 1 .038.016l.019.01.09-.048.012.012L.52.204.51.223l.01.019A.18.18 0 0 1 .536.28l.006.021.021.006L.64.33v.018L.542.377z" stroke-width=".05" fill="#2E294E"/>
                </svg>
            </div>
            <a href="{{ route('landlord.agent.edit.profile') }}" class="btn btn-primary">
                {{ __('Go to setting') }}
            </a>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card mb-4 p-4 text-center bg-soft-primary">
            <div class="fs-16 fw-600 text-primary">
                {{ __('Payment Settings') }}
            </div>
            <div class=" m-3">
                <svg data-name="Group 30" xmlns="http://www.w3.org/2000/svg" width="31.999" height="32" viewBox="0 0 31.999 32">
                    <path data-name="Path 83" d="M3.254 20.593a.5.5 0 0 1 .314-.464l7.086-2.829a.484.484 0 0 1 .185-.036.5.5 0 0 1 .185.965L3.937 21.06a.5.5 0 0 1-.686-.464" fill="#2E294E"/>
                    <path data-name="Path 84" d="M3.254 23.537a.5.5 0 0 1 .314-.464l4.615-1.844a.493.493 0 0 1 .186-.036.5.5 0 0 1 .186.964L3.941 24a.5.5 0 0 1-.686-.464" fill="#2E294E"/>
                    <path data-name="Path 85" d="M24.225 0a2.017 2.017 0 0 0-.744.143L1.259 9.021A2 2 0 0 0 0 10.878V30a2 2 0 0 0 2.746 1.857l15.795-6.31a.5.5 0 1 0-.372-.929l-15.795 6.31a.985.985 0 0 1-.372.072 1 1 0 0 1-1-1V18.7l24.225-9.679v8.306a.5.5 0 0 0 1 0V2a2 2 0 0 0-2-2m1 5.82L1.001 15.5v-4.62a1 1 0 0 1 .63-.928l22.223-8.881A1 1 0 0 1 25.227 2Z" fill="#2E294E"/>
                    <path data-name="Path 86" d="m30.74 22.181-8.586-3.429a4.007 4.007 0 0 0-7.193-1.8l2.671 1.067a1 1 0 1 1-.744 1.857l-2.671-1.067a4.005 4.005 0 0 0 6.449 3.654l8.588 3.437a2 2 0 1 0 1.487-3.714m.186 2.228a1 1 0 0 1-1.3.557L20.454 21.3a3.006 3.006 0 0 1-5.08-.952l1.149.459a2 2 0 1 0 1.488-3.714l-1.149-.459a3 3 0 0 1 4.336 2.809l9.173 3.665a1 1 0 0 1 .558 1.3" fill="#2E294E"/>
                </svg>
                  
            </div>
            <a href="{{ route('landlord.agent.edit.profile') }}" class="btn btn-primary">
                {{ __('Configure Now') }}
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-9 col-md-9 col-lg-12">
        <div class="card mb-4 p-4 text-center bg-soft-primary">
            <div class="fs-16 fw-600 text-primary">
                {{ __('Referral Link') }}
            </div>
            <hr>
            <div class="m-1">
                <a class="fw-600 mb-3 text-primary" id="ref_link">
                {{ route('landlord.agent.register', $agent->referral_code) }}
                </a>
                <button class="btn btn-outline-success btn-sm m-2" id="copyButton">Copy</button><br><br>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js" integrity="sha512-OD9Gn6cAUQezuljS6411uRFr84pkrCtw23Hl5TYzmGyD0YcunJIPSBDzrV8EeCiFxGWWvtJOfVo5pOgB++Jsag==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#copyButton').click(function() {
                var copyText = document.getElementById("ref_link");
                copy_to_clipBoard(copyText.text);
                this.innerHTML = "Copied";
                //alert("Copied the text: " + copyText.text);
            });

            function copy_to_clipBoard(txt_to_copy){
                navigator.clipboard.writeText(txt_to_copy.trim());
            }

            function graphy(selector, config) {
                if (!$(selector).length) return;

                $(selector).each(function () {
                    var $this = $(this);

                    var aizChart = new Chart($this, config);
                });
            }

            let config = {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($last_7_days_sales as $key => $last_7_days_sale)
                            '{{ $key }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Sales ($)',
                        data: [
                            @foreach ($last_7_days_sales as $key => $last_7_days_sale)
                                '{{ $last_7_days_sale }}',
                            @endforeach
                        ],

                        backgroundColor: ['#2E294E', '#2E294E', '#2E294E', '#2E294E', '#2E294E', '#2E294E',
                            '#2E294E'
                        ],
                        borderColor: ['#2E294E', '#2E294E', '#2E294E', '#2E294E', '#2E294E', '#2E294E',
                            '#2E294E'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                color: '#E0E0E0',
                                zeroLineColor: '#E0E0E0'
                            },
                            ticks: {
                                fontColor: "#AFAFAF",
                                fontFamily: 'Roboto',
                                fontSize: 10,
                                beginAtZero: true
                            },
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                fontColor: "#AFAFAF",
                                fontFamily: 'Roboto',
                                fontSize: 10
                            },
                            barThickness: 7,
                            barPercentage: .5,
                            categoryPercentage: .5,
                        }],
                    },
                    legend: {
                        display: false
                    }
                }
            };

            graphy('#graph-1', config);
        });
    </script>
@endsection