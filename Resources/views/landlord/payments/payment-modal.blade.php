<form class="form-horizontal" action="{{ route('landlord.admin.agent.payments.request.accept') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
    	<h5 class="modal-title h6">{{__('Pay to Agent')}}</h5>
    	<button type="button" class="close" data-dismiss="modal">
    	</button>
    </div>
    <div class="modal-body">
      <table class="table table-striped table-bordered" >
          <tbody>
                <tr>
                    @if($agent_withdraw_request->agent->wallet->balance >= 0)
                        <td>{{ __('Due to agent') }}</td>
                        <td>{{ amount_with_currency_symbol($agent_withdraw_request->agent->wallet->balance) }}</td>
                    @endif
                </tr>
                <tr>
                    @if($agent_withdraw_request->amount > 0)
                        <td>{{ __('Requested Amount is ') }}</td>
                        <td>{{ amount_with_currency_symbol($agent_withdraw_request->amount) }}</td>
                    @endif
                </tr>
                @if ($agent_withdraw_request->agent->bank_payment_status)
                    <tr>
                        <td>{{ __('Bank Name') }}</td>
                        <td>{{ $agent_withdraw_request->agent->bank_name }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Bank Account Name') }}</td>
                        <td>{{ $agent_withdraw_request->agent->bank_acc_name }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Bank Account Number') }}</td>
                        <td>{{ $agent_withdraw_request->agent->bank_acc_no }}</td>
                    </tr>
                    <tr>
                        <td>{{ __('Bank Routing Number') }}</td>
                        <td>{{ $agent_withdraw_request->agent->bank_routing_no }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <br>
        @if ($agent_withdraw_request->agent->wallet->balance > 0)
            <input type="hidden" name="agent_id" value="{{ $agent_withdraw_request->agent->id }}">
            <input type="hidden" name="payment_withdraw" value="withdraw_request">
            <input type="hidden" name="withdraw_request_id" value="{{ $agent_withdraw_request->id }}">
            <div class="form-group row">
                <label class="col-sm-3 col-from-label" for="amount">{{__('Requested Amount')}}</label>
                <div class="col-sm-9">
                    @if ($agent_withdraw_request->amount < $agent_withdraw_request->agent->wallet->balance)
                        <input type="number" lang="en" min="0" step="0.01" name="amount" id="amount" value="{{ $agent_withdraw_request->amount }}" class="form-control" required>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-from-label" for="payment_method">{{__('Payment Method')}}</label>
                <div class="col-sm-9">
                    <select name="payment_method" id="payment_method" class="form-control demo-select2-placeholder" required>
                        <option value="">{{__('Select Payment Method')}}</option>
                        @if($agent_withdraw_request->agent->cash_payment_status)
                            <option value="cash">{{__('Cash')}}</option>
                        @endif
                        @if($agent_withdraw_request->agent->bank_payment_status)
                            <option value="bank_payment">{{__('Bank Payment')}}</option>
                        @endif
                    </select>
                </div>
            </div>
        @endif

    </div>
    <div class="modal-footer">
      @if ($agent_withdraw_request->agent->wallet->balance > 0)
        <button type="submit" class="btn btn-primary">{{__('Pay')}}</button>
      @endif
      <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('Cancel')}}</button>
    </div>
</form>

<script>
$(document).ready(function(){
    $('#payment_option').on('change', function() {
      if ( this.value == 'bank_payment')
      {
        $("#txn_div").show();
      }
      else
      {
        $("#txn_div").hide();
      }
    });
    $("#txn_div").hide();
});
</script>
