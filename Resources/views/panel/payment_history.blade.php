@extends('agent::layouts.app')

@section('title')
    {{ __('Withdraw history') }}
@endsection

@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ __('Payment History') }}</h5>
        </div>
        @if (count($payments) > 0)
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Date')}}</th>
                            <th>{{ __('Amount')}}</th>
                            <th>{{ __('Payment Method')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $key => $payment)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>{{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
                                <td>
                                    {{-- single_price($payment->amount) --}}
                                    {{ $payment->amount }}
                                </td>
                                <td>
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }} @if ($payment->txn_code != null) ({{  __('TRX ID') }} : {{ $payment->txn_code }}) @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                	{{ $payments->links() }}
              	</div>
            </div>
        @endif
    </div>

@endsection
