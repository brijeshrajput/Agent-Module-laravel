<?php

namespace Modules\Agent\Http\Controllers\Frontend;

use App\Helpers\ResponseMessage;
use App\Helpers\SanitizeInput;
use App\Models\PaymentGateway;
use App\Models\PaymentLogs;
use App\Models\PricePlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Agent\Entities\Agent;
use Modules\Agent\Entities\AgentClient;
use Modules\Agent\Entities\AgentCommission;
use Modules\Agent\Entities\AgentNotification;
use Modules\Agent\Entities\AgentPaymentLog;
use Modules\Agent\Entities\AgentWallet;
use Modules\Agent\Entities\AgentWithdrawRequest;
use Modules\Agent\Helper\FormData;
use Nette\Utils\Random;

class BrAgentDashboardController extends Controller
{
    private const BASE_PATH = 'agent::panel.';

    public function __construct()
    {
        //$this->middleware('auth:agent');
    }
    
    public function dashboard()
    {
        // $data['last_7_days_sales'] = AgentCommission::where('created_at', '>=', Carbon::now()->subDays(7))
        //                         ->where('agent_id', '=', Auth::guard('agent')->user()->id)
        //                         ->select(DB::raw("sum(amount) as total, DATE_FORMAT(created_at, '%d %b') as date"))
        //                         ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
        //                         ->get()->pluck('total', 'date');
        $agent = Agent::find(Auth::guard('agent')->user()->id);
        $last_7_days_sales[] = null;
        
        return view(self::BASE_PATH.'dashboard', compact('last_7_days_sales', 'agent'));
    }

    public function kyc_verify(Request $request){
        $agent = Agent::find(Auth::guard('agent')->user()->id);
        
        $form_data = get_static_option('agent_kyc_form');
        $form_data_ = json_decode($form_data, true);

        $verification_form = FormData::objFormData($form_data_);

        //dd($verification_form);
        
        return view(self::BASE_PATH.'verify_form', compact('agent', 'verification_form'));
    }

    public function kyc_verify_store(Request $request){
        //dd($request->all());
        $agent_id = Auth::guard('agent')->user()->id;
        $agent = Agent::find($agent_id);
        //todo: store form

        return redirect()->back()->with(['msg' => __('Agent Verification Form Submitted'), 'type' => 'success']);
    }

    public function user_profile_update(Request $request)
    {
        //todo: unused fun
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'nullable|string|max:191',
            'state' => 'nullable|string|max:191',
            'city' => 'nullable|string|max:191',
            'zipcode' => 'nullable|string|max:191',
            'country' => 'nullable|string|max:191',
            'address' => 'nullable|string',
            'image' => 'nullable|string',
        ], [
            'name.' => __('name is required'),
            'email.required' => __('email is required'),
            'email.email' => __('provide valid email'),
        ]);
        User::find(Auth::guard('agent')->user()->id)->update([
                'name' => SanitizeInput::esc_html($request->name),
                'email' => SanitizeInput::esc_html($request->email),
                'mobile' => SanitizeInput::esc_html($request->mobile),
                'company' => SanitizeInput::esc_html($request->company),
                'address' => SanitizeInput::esc_html($request->address),
                'state' => SanitizeInput::esc_html($request->state),
                'city' => SanitizeInput::esc_html($request->city),
                'country' => SanitizeInput::esc_html($request->country),
                'image' => $request->image
            ]
        );

        return redirect()->back()->with(['msg' => __('Profile Update Success'), 'type' => 'success']);
    }

    public function agent_password_change(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|confirmed'
        ],
            [
                'new_password.required' => __('Password is required'),
                'confirm_password.required' => __('Confirm Password is required'),
                'confirm_password.confirmed' => __('password must have be confirmed')
            ]
        );

        $user = Agent::findOrFail(Auth::guard('agent')->user()->id);

        if ($request->new_password == $user->confirm_password) {

            $user->password = Hash::make($request->password);
            $user->save();
            Auth::guard('agent')->logout();

            return redirect()->route('landlord.agent.login')->with(['msg' => __('Password Changed Successfully'), 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again or Check Your Old Password'), 'type' => 'danger']);
    }

    public function agent_payment_settings(Request $request){

        $this->validate($request, [
            'cash_payment_status' => 'nullable|string|max:5',
            'bank_payment_status' => 'nullable|string|max:5',
            'bank_acc_name' => 'nullable|string|max:191',
            'bank_acc_no' => 'nullable|string|max:191',
            'bank_name' => 'nullable|string|max:191',
            'bank_branch' => 'nullable|string|max:191',
            'bank_routing_no' => 'nullable|string|max:191',
        ], [
            'cash_payment_status.required' => __('Cash Payment Status is required'),
            'bank_payment_status.required' => __('Bank Payment Status is required'),
            'bank_acc_name.required' => __('Bank Account Name is required'),
            'bank_acc_no.required' => __('Bank Account Number is required'),
            'bank_name.required' => __('Bank Name is required'),
            'bank_branch.required' => __('Bank Branch is required'),
            'bank_routing_no.required' => __('Bank Routing Number is required'),
        ]);

        $agent_id = Auth::guard('agent')->user()->id;

        $agent = Agent::findOrFail($agent_id);
        $agent->cash_payment_status = $request->cash_payment_status;
        $agent->bank_payment_status = $request->bank_payment_status;
        $agent->bank_acc_name = $request->bank_acc_name;
        $agent->bank_acc_no = $request->bank_acc_no;
        $agent->bank_name = $request->bank_name;
        $agent->bank_branch = $request->bank_branch;
        $agent->bank_routing_no = $request->bank_routing_no;

        if($agent->save()){
            return redirect()->back()->with(['msg' => __('Payment Settings Updated Successfully'), 'type' => 'success']);
        }else{
            return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again'), 'type' => 'danger']);
        }
    }

    public function logged_agent_details()
    {
        $old_details = '';
        if (empty($old_details)) {
            $old_details = Agent::findOrFail(Auth::guard('agent')->user()->id);
        }
        return $old_details;
    }

    public function edit_profile()
    {
        return view(self::BASE_PATH . 'edit-profile')->with(['user_details' => $this->logged_agent_details()]);
    }

    public function agent_profile_update(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'phone' => 'nullable|string|max:15',
        ], [
            'name.' => __('name is required'),
            'email.email' => __('provide valid email'),
        ]);
        Agent::find(Auth::guard('agent')->user()->id)->update([
                'name' => SanitizeInput::esc_html($request->name),
                'mobile' => SanitizeInput::esc_html($request->phone),
            ]
        );

        return redirect()->back()->with(['msg' => __('Profile Update Success'), 'type' => 'success']);
    }


    // public function support_tickets()
    // {
    //     $all_tickets = SupportTicket::where('user_id', $this->logged_user_details()->id)->paginate(10);
    //     return view(self::BASE_PATH . 'support-tickets')->with(['all_tickets' => $all_tickets]);
    // }

    // public function support_ticket_priority_change(Request $request)
    // {
    //     $this->validate($request, [
    //         'priority' => 'required|string|max:191'
    //     ]);
    //     SupportTicket::findOrFail($request->id)->update([
    //         'priority' => $request->priority,
    //     ]);
    //     return 'ok';
    // }

    // public function support_ticket_status_change(Request $request)
    // {
    //     $this->validate($request, [
    //         'status' => 'required|string|max:191'
    //     ]);
    //     SupportTicket::findOrFail($request->id)->update([
    //         'status' => $request->status,
    //     ]);
    //     return 'ok';
    // }

    // public function support_ticket_view(Request $request, $id)
    // {
    //     $ticket_details = SupportTicket::findOrFail($id);
    //     $all_messages = SupportTicketMessage::where(['support_ticket_id' => $id])->get();
    //     $q = $request->q ?? '';
    //     return view(self::BASE_PATH . 'view-ticket')->with(['ticket_details' => $ticket_details, 'all_messages' => $all_messages, 'q' => $q]);
    // }

    // public function support_ticket_message(Request $request)
    // {
    //     $this->validate($request, [
    //         'ticket_id' => 'required',
    //         'user_type' => 'required|string|max:191',
    //         'message' => 'required',
    //         'send_notify_mail' => 'nullable|string',
    //         'file' => 'nullable|mimes:zip',
    //     ]);

    //     $ticket_info = SupportTicketMessage::create([
    //         'support_ticket_id' => $request->ticket_id,
    //         'user_id' => Auth::guard('web')->id(),
    //         'type' => $request->user_type,
    //         'message' => str_replace('script', '', $request->message),
    //         'notify' => $request->send_notify_mail ? 'on' : 'off',
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $uploaded_file = $request->file;
    //         $file_extension = $uploaded_file->getClientOriginalExtension();
    //         $file_name = pathinfo($uploaded_file->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $file_extension;
    //         $uploaded_file->move('assets/uploads/ticket', $file_name);
    //         $ticket_info->attachment = $file_name;
    //         $ticket_info->save();
    //     }

    //     //send mail to user
    //     event(new SupportMessage($ticket_info));

    //     return redirect()->back()->with(['msg' => __('Mail Send Success'), 'type' => 'success']);
    // }

    private function store_commission($id, $mode = 0){
        $agent = Agent::findOrFail(Auth::guard('agent')->user()->id);

        //$percentOrFixed = get_static_option('mode_earn_on_agent');
        $total_commission = get_static_option('amt_earn_on_agent');

        $percentOrFixed2 = get_static_option('mode_earn_on_client');
        $total_commission2 = get_static_option('amt_earn_on_client');

        // if percentage
        if($percentOrFixed2 && $mode == 1 && $total_commission2 > 0){
            $payment_details = PaymentLogs::findOrFail($id);
            $amt = $payment_details->package_price;
            $total_commission2 = ($amt * $total_commission2) / 100;
        }

        $agent_commission = new AgentCommission();
        $agent_commission->agent_id = $agent->id;
        if($mode == 0){
            $agent_commission->ag_ref_id = $id;
            $agent_commission->type = 0;
            $agent_commission->amount = $total_commission;
        }else{
            $agent_commission->payment_log_id = $id;
            $agent_commission->type = 1;
            $agent_commission->amount = $total_commission2;
        }
        
        if ($agent_commission->save()){
            $wallet = AgentWallet::where('agent_id', $agent->id)->first();
            if($wallet){
                $wallet->amount = $wallet->amount + $agent_commission->amount;
                $wallet->save();
            }
        }
    }
    
    public function my_referrals(Request $request){

        $ref = null;
        $search = null;
        $refee = null;
        $agents = Agent::where('id', '!=', '-1')->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $agents = $agents->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
        }
        if($request->has('ref')){
            $ref = $request->ref;
            $refee = Agent::where('referral_code', $ref)->first();
            $agents = $agents->where('sponsor_id', $ref);
        }
        $agents = $agents->paginate(10);
        return view(self::BASE_PATH.'agents/index', compact('agents', 'search', 'refee'));
    }

    public function new_agent(){
        return view(self::BASE_PATH.'agents/create');
    }

    public function new_agent_store(Request $request){
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|unique:agents|email|max:191',
            'mobile' => 'required|unique:agents|min:10|max:15',
            'gender' => 'required',
            'sponsor_id' => 'nullable|min:6|max:6',
        ]);

        $pass = Random::generate(8, '0-9A-Z');

        $agent_id = DB::table('agents')->insertGetId([
            'name' => $request['name'],
            'email' => $request['email'],
            'mobile' => $request['mobile'],
            'sponsor_id' => $request['sponsor_code'],
            'referral_code' => Random::generate(6, '0-9A-Z'),
            'password' => Hash::make($pass),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $agent = Agent::findOrFail($agent_id);
        $agent->wallet()->create([
            'balance' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $email = get_static_option('site_global_email');
        try {
            $subject = __('New Agent registration');
            $message_body = __('New Agent registered : ') . $request['name'] . __(' and password is : ') . $pass;
            //Mail::to($email)->send(new BasicMail($subject, $message_body));

            //VerifyUserMailSend::sendMail($agent);
        } catch (\Exception $e) {
            //handle error
            return response()->success(ResponseMessage::delete('Error: '.$e->getMessage()));
        }

        if(get_static_option('earn_on_agent')){
            $this->store_commission($agent_id);
        }
        
        return response()->success(ResponseMessage::success('Agent created successfully'));
    }

    public function agent_wallet(){
        $agent = Auth::guard('agent')->user();
        $wallet = $agent->wallet;
        $agent_withdraw_requests = AgentWithdrawRequest::where('agent_id', $agent->id)->orderBy('created_at', 'desc')->paginate(10);
        return view(self::BASE_PATH.'wallet', compact('agent_withdraw_requests', 'wallet'));
    }

    public function agent_withdraw_modal(){
        return view(self::BASE_PATH.'withdraw_message_modal');
    }

    public function commission_history(Request $request){
        $date_range = null;
        $agent = Auth::guard('agent')->user();
        $commission_history = AgentCommission::where('agent_id', $agent->id)->orderBy('created_at', 'desc')->paginate(10);
        return view(self::BASE_PATH.'commission-history', compact('commission_history', 'date_range'));
    }

    public function withdrawal_history(){
        $payments = AgentPaymentLog::where('agent_id', Auth::guard('agent')->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view(self::BASE_PATH.'payment_history', compact('payments'));
    }

    public function agent_withdraw_store(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:191',
        ]);

        $agent = Auth::guard('agent')->user();
        $agent_withdraw_request = new AgentWithdrawRequest();
        $agent_withdraw_request->agent_id = $agent->id;
        $agent_withdraw_request->amount = $request->amount;
        $agent_withdraw_request->message = $request->message;
        $agent_withdraw_request->status = 0;
        $agent_withdraw_request->viewed = 0;

        if($agent_withdraw_request->save()){
            return response()->success(ResponseMessage::success('Withdraw request sent successfully'));
        }else{
            return response()->success(ResponseMessage::delete('Error: Withdraw request sent failed'));
        }

    }

    public function return_client_form(Request $request)
    {
        if($request->has('page_id') && $request->page_id != null){
            $page_id = $request->page_id;
            if($page_id == '1'){
                return view(self::BASE_PATH.'clients/forms/register');
            }elseif($page_id == '2' && $request->has('client_id') && $request->client_id != null){
                $client_id = $request->client_id;
                $plans = PricePlan::with('plan_features')->where('status', 1)->orderBy('id', 'asc')->get()->groupBy('type');
                $plan_types = PricePlan::where('status', 1)->orderBy('type', 'asc')->select('type')->distinct()->pluck('type');
                return view(self::BASE_PATH.'clients/forms/plans', compact('plans', 'plan_types', 'client_id'));
            }elseif($page_id == '3' && $request->has('client_id') && $request->has('plan_id')){
                if($request->has('plan_id') && $request->plan_id != null && $request->plan_id > 0){
                    $client_id = $request->client_id;
                    $plan_id = $request->plan_id;
                    $order_details = PricePlan::findOrFail($plan_id);
                    return view(self::BASE_PATH.'clients/forms/themes', compact('order_details', 'client_id', 'plan_id'));
                }else{
                    return view(self::BASE_PATH.'clients/forms/error-404');
                }
            }elseif($page_id == '4' && $request->has('client_id') && $request->has('plan_id') && $request->has('theme_slug')){
                if($request->has('theme_slug') && $request->theme_slug != null){
                    $client_id = $request->client_id;
                    $plan_id = $request->plan_id;
                    $theme_slug = $request->theme_slug;
                    return view(self::BASE_PATH.'clients/forms/shopinfo', compact('client_id', 'plan_id', 'theme_slug'));
                }else{
                    return view(self::BASE_PATH.'clients/forms/error-404');
                }
            }elseif($page_id == '5' && $request->has('client_id') && $request->has('plan_id') && $request->has('theme_slug')){
                if($request->has('subdomain') && $request->subdomain != null){
                    $client_id = $request->client_id;
                    $plan_id = $request->plan_id;
                    $theme_slug = $request->theme_slug;
                    $subdomain = $request->subdomain;
                    $order_details = PricePlan::findOrFail($plan_id);
                    $payment_gateways = PaymentGateway::where('name', 'manual_payment')->first();
                    return view(self::BASE_PATH.'clients/forms/payments', compact('client_id', 'plan_id', 'theme_slug', 'subdomain', 'payment_gateways', 'order_details'));
                }else{
                    return view(self::BASE_PATH.'clients/forms/error-404');
                }
                
            }else{
                return view(self::BASE_PATH.'clients/forms/error-404');
            }

        }else{
            // return 404
            return view(self::BASE_PATH.'clients/forms/error-404');
        }
        
    }

    public function add_new_client(){
        return view(self::BASE_PATH.'clients/create');
    }

    protected function create_client(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'mobile' => ['required', 'string', 'max:13', 'min:10', 'unique:users'],
        ]);

        $pass = Random::generate(8, '0-9A-Z');

        $user_id = DB::table('users')->insertGetId([
            'name' => $request['name'],
            'email' => $request['email'],
            'mobile' => $request['mobile'],
            'username' => $request['email'],
            'password' => Hash::make($pass),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user = User::findOrFail($user_id);

        //Auth::guard('web')->login($user);

        // add client to agent_client table
        $agent_client_id = DB::table('agent_clients')->insertGetId([
            'agent_id' => Auth::guard('agent')->user()->id,
            'user_id' => $user_id,
            'progress' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $email = get_static_option('site_global_email');
        try {
            $subject = __('New user registration');
            $message_body = __('New user registered : ') . $request['name'] . __(' and password is : ') . $pass;
            //Mail::to($email)->send(new BasicMail($subject, $message_body));

            //VerifyUserMailSend::sendMail($user);
        } catch (\Exception $e) {
            //handle error
        }

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'client_id' => $user_id,
            'msg' => __('Registration Success Redirecting')
        ]);
    }

    public function view_client(Request $request){
        $search = null;
        $agent_id = Auth::guard('agent')->user()->id;
        //$clients_incomplete = AgentClient::where('agent_id', $agent_id)->where('progress', 0)->orderBy('id', 'desc');
        $clients = User::whereIn('id', function($query) use ($agent_id){
            $query->select('user_id')->from('agent_clients')->where('agent_id', $agent_id);
        })->orderBy('id', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $clients = $clients->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
        }
        $clients = $clients->paginate(10);
        return view(self::BASE_PATH.'clients/index', compact('clients', 'search'));
    }

    public function agent_notifications(){
        $agent_id = Auth::guard('agent')->user()->id;
        $notifications = AgentNotification::where('agent_id', $agent_id)->orderBy('id', 'desc')->paginate(10);
        return view(self::BASE_PATH.'notifications/index', compact('notifications'));
    }


    public function order_payment_success($id)
    {
        $extract_id = substr($id, 6);
        $extract_id = substr($extract_id, 0, -6);

        $payment_details = PaymentLogs::findOrFail($extract_id);

        $domain = \DB::table('domains')->where('tenant_id',$payment_details->tenant_id)->first();

        // update progress status in agent_client table
        $agent_client = AgentClient::where('user_id', $payment_details->user_id)->first();
        $agent_client->progress = 1;
        $agent_client->save();

        // insert commission to agent_commission table
        if(get_static_option('earn_on_client')){
            $this->store_commission($extract_id, 1);
        }

        if (empty($extract_id)) {
            abort(404);
        }

        return view(self::BASE_PATH.'clients/orders/payment-success', compact('payment_details', 'domain'));
    }

    public function order_payment_cancel($id)
    {
        $order_details = PaymentLogs::find($id);
        return view(self::BASE_PATH.'clients/orders/payment-cancel')->with(['order_details' => $order_details]);
    }

    public function order_payment_cancel_static()
    {
        return view(self::BASE_PATH.'clients/orders/payment-cancel-static');
    }

    public function order_confirm($id)
    {

        return view(self::BASE_PATH.'error-404');
    }
    
}
