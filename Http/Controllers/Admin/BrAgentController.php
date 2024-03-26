<?php

namespace Modules\Agent\Http\Controllers\Admin;

use App\Helpers\SanitizeInput;
use App\Mail\BasicMail;
use App\Models\StaticOption;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Agent\Entities\Agent;
use Nette\Utils\Random;

class BrAgentController extends Controller
{
    private const BASE_PATH = 'agent::landlord.';
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view(self::BASE_PATH.'index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function new_agent()
    {
        $all_user = Agent::latest()->get();
        return view(self::BASE_PATH.'index', compact('all_user'));
    }

    public function new_agent_store(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:agents',
            'mobile' => 'nullable|string|max:17',
            'image' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8|same:password',
        ]);

        $agent_id = DB::table('agents')->insertGetId([
            'name' => SanitizeInput::esc_html($request->name),
            'email' => SanitizeInput::esc_html($request->email),
            'mobile' => SanitizeInput::esc_html($request->mobile),
            'image' => $request->image,
            'referral_code' => SanitizeInput::esc_html(Random::generate(6, '0-9A-Z')),
            'password' => Hash::make($request->password),
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
            $message_body = __('New Agent registered : ') . $request['name'] . __(' and password is : ') . $request['password'];
            Mail::to($email)->send(new BasicMail($subject, $message_body));

            //VerifyUserMailSend::sendMail($agent);
        } catch (\Exception $e) {
            //handle error
            //return redirect()->back()->with(['error' => $e->getMessage(), 'type' => 'danger']);
        }
        
        return redirect()->back()->with(['msg' => __('New Agent Added'), 'type' =>'success' ]);
    }

    public function all_agents(){
        $all_user = Agent::latest()->get();
        return view(self::BASE_PATH.'index', compact('all_user'));
    }

    public function agent_edit($id){
        $agent = Agent::findOrFail($id);
        return view(self::BASE_PATH.'edit-user',compact('agent'));
    }

    public function agent_update(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'mobile' =>'nullable|max:17',
            'image' => 'nullable|string',
        ]);

        $data = [
            'name' => SanitizeInput::esc_html($request->name),
            'email' => SanitizeInput::esc_html($request->email),
            'image' => $request->image,
            'mobile' => SanitizeInput::esc_html($request->mobile),
        ];

        $agent = Agent::findOrFail($request->agent_id);
        $agent->update($data);

        return redirect()->back()->with(['msg' => __('Agent Details Updated'), 'type' =>'success' ]);
    }
    public function agent_delete(Request $request, $id){
        Agent::findOrFail($id)->delete();
        return redirect()->back()->with(['msg' => __('Agent Deleted'), 'type' =>'danger' ]);
    }

    public function password_change(Request $request){
        $this->validate($request, [
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = Agent::findOrFail($request->ch_user_id);
        $user->password = Hash::make($request->password);
        if($user->save()){
            return redirect()->back()->with(['msg'=> __('Password Changed Successfully'),'type'=> 'success']);
        }else{
            return redirect()->back()->with(['msg'=> __('Something went wrong'),'type'=> 'danger']);
        }
    }

    public function settings()
    {
        return view(self::BASE_PATH . 'settings');
    }

    public function settings_startup(Request $request){
        $request->validate([
            'setup_settings' => 'required|string',
        ], [
            'setup_settings.required' => 'Please select a option',
        ]);

        //check in table if already exists
        $check_erc = get_static_option('earn_on_client');
        $check_era = get_static_option('earn_on_agent');
        $check_amw = get_static_option('agent_min_withdraw');

        $nonlang_fields = [
            'agent_email_verify_status' => 'on',
            'earn_on_client' => 'on',
            'mode_earn_on_client' => null,
            'amt_earn_on_client' => 5,
            'earn_on_agent' => null,
            'mode_earn_on_agent' => null,
            'amt_earn_on_agent' => 8,
            'agent_min_withdraw' => 10,
        ];

        if($check_erc == null || $check_era == null || $check_amw == null){
            foreach ($nonlang_fields as $field_name => $values) {
                update_static_option($field_name, $values);
            }

            $json_encoded_data = '{"field_type":["text","text","email","textarea","file"],"field_name":["kane","subject","email","message","attachment"],"field_placeholder":["Your Name","Your Subject","Your Email","Your Message","Attahcment"],"field_required":["on","on","on","on"],"mimes_type":{"4":"mimes:jpg,jpeg,png"}}';

            update_static_option('agent_kyc_form', $json_encoded_data);

            return redirect()->back()->with(['msg' => __('Setup Settings Successfully'),'type' =>'success' ]);

        }else{
            return redirect()->back()->with(['msg' => __('Setup Settings Already Updated'),'type' =>'warning' ]);
        }
    }

    public function settings_withdraw(Request $request){
        
        $nonlang_fields = [
            'agent_email_verify_status' => 'string|nullable',
            'earn_on_client' => 'string|nullable',
            'mode_earn_on_client' => 'string|nullable',
            'amt_earn_on_client' => 'numeric|nullable',
            'earn_on_agent' => 'string|nullable',
            'mode_earn_on_agent' => 'string|nullable',
            'amt_earn_on_agent' => 'numeric|nullable',
        ];
        $request->validate($nonlang_fields);

        foreach ($nonlang_fields as $field_name => $rules) {
            update_static_option($field_name, $request->$field_name);
        }

        return redirect()->back()->with(['msg' => __('Basic Settings Updated'),'type' =>'success' ]);
    }

    public function settings_payments(Request $request){
        $request->validate([
            'agent_min_withdraw' => 'required|numeric|min:0',
        ], [
            'agent_min_withdraw.required' => 'The Minimum Withdraw field is required.',
            'agent_min_withdraw.numeric' => 'The Minimum Withdraw field must be numeric.',
            'agent_min_withdraw.min' => 'The Minimum Withdraw field must be at least 0.',
        ]);

        update_static_option('agent_min_withdraw', $request->agent_min_withdraw);

        return redirect()->back()->with(['msg' => __('Payment Settings Updated'),'type' =>'success' ]);
    }

    public function kyc_form(){
        $form_data =  get_static_option('agent_kyc_form');
        return view(self::BASE_PATH.'kyc-form', compact('form_data'));
    }

    public function update_kyc_form(Request $request){
        $this->validate($request,[
            'field_name' => 'required|max:191',
            'field_placeholder' => 'required|max:191',
        ]);

        unset($request['_token'], $request['title'], $request['id']);
        $all_fields_name = [];
        $all_request_except_token = $request->all();
        foreach ($request->field_name as $fname){
            $all_fields_name[] = strtolower(Str::slug($fname));
        }
        $all_request_except_token['field_name'] = $all_fields_name;
        $json_encoded_data = json_encode($all_request_except_token);

        if(update_static_option('agent_kyc_form', $json_encoded_data)){
            return redirect()->back()->with(['msg' => __('KYC Form Updated'),'type' =>'success' ]);
        }else{
            return redirect()->back()->with(['msg' => __('Something went wrong'),'type' =>'danger' ]);
        }

        //return response()->success(ResponseMessage::SettingsSaved());
    }
}
