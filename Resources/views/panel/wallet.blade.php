@extends('agent::layouts.app')

@section('title')
    {{ __('Wallet') }}
@endsection

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ __('Money Withdraw') }}</h1>
        </div>
      </div>
    </div>
    
    <div class="row gutters-10">
        <div class="col-md-4 mb-3 ml-auto" >
            <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
              <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                  <i class="las la-dollar-sign la-2x text-white"></i>
              </span>
              <div class="px-3 pt-3 pb-3">
                  <div class="h4 fw-700 text-center">{{ amount_with_currency_symbol($wallet->balance) }}</div>
                  <div class="opacity-50 text-center">{{ __('Wallet Balance') }}</div>
              </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mr-auto" >
          <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition" onclick="show_request_modal()">
              <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                  <i class="las la-plus la-3x text-white"></i>
              </span>
              <div class="fs-18 text-primary">{{ __('Send Withdraw Request') }}</div>
          </div>
        </div>
    </div>

    <x-error-msg/>
    <x-flash-msg/>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ __('Withdraw Request history')}}</h5>
        </div>
          <div class="card-body">
              <table class="table aiz-table mb-0">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>{{ __('Date') }}</th>
                          <th>{{ __('Amount')}}</th>
                          <th data-breakpoints="lg">{{ __('Status')}}</th>
                          <th data-breakpoints="lg" width="60%">{{ __('Message')}}</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($agent_withdraw_requests as $key => $agent_withdraw_request)
                          <tr>
                              <td>{{ $key+1 }}</td>
                              <td>{{ date('d-m-Y', strtotime($agent_withdraw_request->created_at)) }}</td>
                              <td>{{ $agent_withdraw_request->amount }}</td>
                              <td>
                                  @if ($agent_withdraw_request->status == 1)
                                      <span class=" badge badge-inline badge-success" >{{ __('Paid')}}</span>
                                  @else
                                      <span class=" badge badge-inline badge-info" >{{ __('Pending')}}</span>
                                  @endif
                              </td>
                              <td>
                                  {{ $agent_withdraw_request->message }}
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
              <div class="aiz-pagination">
                  {{ $agent_withdraw_requests->links() }}
              </div>
          </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="request_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Send A Withdraw Request') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                @if ($wallet->balance > get_static_option('agent_min_withdraw', 10))
                    <form class="" action="{{ route('landlord.agent.withdraw_store') }}" method="post">
                        @csrf
                        <div class="modal-body gry-bg px-3 pt-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Amount')}} <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" lang="en" class="form-control mb-3" name="amount" min="10" max="{{ $wallet->balance }}" placeholder="{{ __('Amount') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ __('Message')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="message" rows="8" class="form-control mb-3"></textarea>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary">{{__('Send')}}</button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="p-5 heading-3">
                            {{ __('You do not have enough balance to send withdraw request') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function show_request_modal(){
            $('#request_modal').modal('show');
        }

        function show_message_modal(id){
            $.post('{{ route('landlord.agent.withdraw_modal') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
                $('#message_modal .modal-content').html(data);
                $('#message_modal').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endsection
