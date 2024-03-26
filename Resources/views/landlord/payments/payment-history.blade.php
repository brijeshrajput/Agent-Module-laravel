@extends(route_prefix().'admin.admin-master')
@section('style')
   <x-datatable.css/>
@endsection
@section('title')
    {{__('All Payment History')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-error-msg/>
                        <x-flash-msg/>
                        <h4 class="header-title">{{__('Payment History')}}</h4>
                        
                        <div class="table-wrap table-responsive">
                            <table class="table table-default table-striped table-bordered">
                                <thead class="text-white" style="background-color: #b66dff">
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Agent Name')}}</th>
                                    <th>{{__('Agent Email')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Payment Gateway')}}</th>
                                    <th>{{__('Date')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payment_logs as $data)
                                    <tr>
                                        <td>{{$data->id}}</td>
                                        <td>{{$data->agent->name}}</td>
                                        <td>{{$data->agent->email}}</td>
                                        <td>{{amount_with_currency_symbol($data->amount)}}</td>
                                        <td><strong>{{ucwords(str_replace('_',' ',$data->payment_method))}}</strong>
                                            @if($data->txn_code != null && $data->txn_code != '')
                                                <br>
                                                <strong>{{__('Transaction ID')}}:</strong> {{$data->txn_code}}
                                            @endif
                                        </td>
                                        <td>{{date_format($data->created_at,'d M Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
   <x-datatable.js/>


@endsection

