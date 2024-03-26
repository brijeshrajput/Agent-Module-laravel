@extends('agent::layouts.app')

@section('title')
    {{ __('Commission History') }}
@endsection

@section('panel_content')
    <div class="card">
        <form class="" action="" id="sort_commission_history" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ __('Commission History') }}</h5>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm aiz-date-range" id="search" name="date_range"@isset($date_range) value="{{ $date_range }}" @endisset placeholder="{{ __('Daterange') }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-breakpoints="lg">{{ __('Earned for') }}</th>
                        <th>{{ __('Earning') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th data-breakpoints="lg">{{ __('Created At') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commission_history as $key => $history)
                    <tr>
                        <td>{{ ($key+1) }}</td>
                        <td>
                            @if($history->type==0)
                                {{ $history->ag_ref_id }} (Agent Referral ID)
                            @elseif($history->type==1)
                                {{ $history->payment_log_id }} (Client Package Purchase ID)
                            @else
                                <span class="badge badge-inline badge-danger">
                                    {{ __('Order Deleted') }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $history->amount }}</td>
                        <td>
                            @if($history->type==0)
                                {{ __('Referral Earning') }}
                            @elseif($history->type==1)
                                {{ __('Order Earning') }}
                            @else
                                <span class="badge badge-inline badge-danger">
                                    {{ __('Order Deleted') }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $history->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination mt-4">
                {{ $commission_history->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
    function sort_commission_history(el){
        $('#sort_commission_history').submit();
    }
</script>
@endsection
