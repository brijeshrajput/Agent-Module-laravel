<?php

namespace Modules\Agent\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Agent\Entities\AgentPaymentLog;
use Modules\Agent\Entities\AgentWithdrawRequest;

class BrAgentPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    private const BASE_PATH = 'agent::landlord.payments.';

    public function all_payment_requests(Request $request){
        if ($request->filter != null && $request->filter != 'all') {
            $all_requests = AgentWithdrawRequest::where('status', $request->filter)->orderByDesc('id')->get();
        } else {
            $all_requests = AgentWithdrawRequest::orderByDesc('id')->get();
        }

        return view(self::BASE_PATH . 'payment-requests')->with(['all_requests' => $all_requests]);
    }

    public function payment_request_modal(Request $request){
        if($request->has('id')){
            $agent_withdraw_request = AgentWithdrawRequest::find($request->id);
            return view(self::BASE_PATH . 'payment-modal')->with(['agent_withdraw_request' => $agent_withdraw_request]);
        }
    }

    public function payment_request_accept(Request $request){
        $this->validate($request, [
            'agent_id' => 'required|numeric',
            'withdraw_request_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        $agent_withdraw_request = AgentWithdrawRequest::find($request->withdraw_request_id);
        $agent_withdraw_request->status = 1;
        $agent_withdraw_request->viewed = 1;

        $wallet = $agent_withdraw_request->agent->wallet;
        $wallet->balance = $wallet->balance - $request->amount;

        if($agent_withdraw_request->save() && $wallet->save()){
            $agent_payment_log = new AgentPaymentLog();
            $agent_payment_log->agent_id = $request->agent_id;
            $agent_payment_log->amount = $request->amount;
            $agent_payment_log->payment_method = $request->payment_method;
            
            if($agent_payment_log->save()){
                return redirect()->back()->with(['msg' => __('Payment Success'), 'type' => 'success']);
            }else{
                return redirect()->back()->with(['msg' => __('Payment Failed'), 'type' => 'danger']);
            }
        }else{
            return redirect()->back()->with(['msg' => __('Payment Failed'), 'type' => 'danger']);
        }
        
    }

    public function payment_history()
    {
        $paymeng_logs = AgentPaymentLog::all();
        return view(self::BASE_PATH . 'payment-history')->with(['payment_logs' => $paymeng_logs]);
    }
}
