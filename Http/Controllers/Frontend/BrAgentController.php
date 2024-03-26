<?php

namespace Modules\Agent\Http\Controllers\Frontend;

use App\Helpers\EmailHelpers\VerifyUserMailSend;
use App\Mail\AdminResetEmail;
use App\Mail\BasicMail;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Agent\Entities\Agent;
use Modules\Agent\Entities\AgentWallet;
use Nette\Utils\Random;

class BrAgentController extends Controller
{
    private const BASE_PATH = 'agent::auth.';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('agent::index');
    }


    public function showAgentLoginForm()
    {
        if (auth('agent')->check()) {
            return redirect()->route('landlord.agent.dashboard');
        }
        return view(self::BASE_PATH.'login');
    }

    public function showAgentRegistrationForm(Request $request)
    {
        //get referal code from url
        $sponsor_code = $request->sponsor_code;

        if (auth('agent')->check()) {
            return redirect()->route('landlord.agent.dashboard');
        }

        return view(self::BASE_PATH.'register', compact('sponsor_code'));
    }

    
    protected function agent_user_create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:agents'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_condition' => ['required']
        ],
        [
            'terms_condition.required' => 'Please mark on our terms and condition to agree and proceed'
        ]);

        $user_id = DB::table('agents')->insertGetId([
            'name' => $request['name'],
            'email' => $request['email'],
            'mobile' => $request['mobile'],
            'sponsor_id' => $request['sponsor_code'],
            'referral_code' => Random::generate(6),
            'password' => Hash::make($request['password']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user = Agent::findOrFail($user_id);

        $user->wallet()->create([
            'balance' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Auth::guard('agent')->login($user);

        $email = get_static_option('site_global_email');
        try {
            $subject = __('New Agent registration');
            $message_body = __('New Agent registered : ') . $request['name'];
            Mail::to($email)->send(new BasicMail($subject, $message_body));

            VerifyUserMailSend::sendMail($user);
        } catch (\Exception $e) {
            //handle error
        }

        return response()->json([
            'msg' => __('Registration Success Redirecting'),
            'type' => 'success',
            'status' => 'valid'
        ]);
    }


    public function ajax_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|min:6'
        ], [
            'email.required' => __('Email required'),
            'password.required' => __('Password required'),
            'password.min' => __('Password length must be 6 characters')
        ]);
        $type = 'mobile';
        //check is email or username
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $type = 'email';
        }
        if (Auth::guard('agent')->attempt([$type => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return response()->json([
                'msg' => __('Agent Login Success Redirecting'),
                'type' => 'success',
                'status' => 'valid'
            ]);
        }
        return response()->json([
            'msg' => __('Email and password do not match'),
            'type' => 'danger',
            'status' => 'invalid'
        ]);
    }

    public function showAgentForgetPasswordForm()
    {
        if (auth('agent')->check()) {
            return redirect()->route('landlord.agent.dashboard');
        }
        return view(self::BASE_PATH.'forget-password');
    }

    public function showAgentResetPasswordForm($agent, $token)
    {
        return view(self::BASE_PATH.'reset-password')->with([
            'email' => $agent,
            'token' => $token
        ]);
    }

    public function AgentResetPassword(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email|string',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user_info = Agent::where('email', $request->email)->first();
        $token_iinfo = DB::table('password_resets')->where(['email' => $user_info->email, 'token' => $request->token])->first();
        if (!empty($token_iinfo)) {
            $user_info->password = Hash::make($request->password);
            $user_info->save();
            return redirect()->route('landlord.agent.login')->with(['msg' => __('Agent Password Changed Successfully'), 'type' => 'success']);
        }
        return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again or Check Your Old Password'), 'type' => 'danger']);
    }

    public function sendAgentForgetPasswordMail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|string:max:191'
        ]);

        $user_info = Agent::where('email', $request->email)->first();

        if (!empty($user_info)) {
            $token_id = Str::random(30);
            $existing_token = DB::table('password_resets')->where('email', $user_info->email)->delete();
            if (empty($existing_token)) {
                DB::table('password_resets')->insert(['email' => $user_info->email, 'token' => $token_id]);
            }
            $message = __('Here is you password reset link, If you did not request to reset your password just ignore this mail.') . '<br> <a class="btn" href="' . route('landlord.agent.reset.password', ['user' => $user_info->email, 'token' => $token_id]) . '" style="color:white;background:gray">' . __('Click Reset Password') . '</a>';
            $data = [
                'name' => $user_info->name,
                'message' => $message
            ];
            try {
                Mail::to($user_info->email)->send(new AdminResetEmail($data));
            } catch (\Exception $e) {
                return redirect()->back()->with([
                    'msg' => $e->getMessage(),
                    'type' => 'danger'
                ]);
            }

            return redirect()->back()->with([
                'msg' => __('Check Your Mail For Reset Password Link'),
                'type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'msg' => __('Your Username or Email Is Wrong!!!'),
            'type' => 'danger'
        ]);
    }

    public function verify_agent_email()
    {
        if (empty(get_static_option('agent_email_verify_status')) || Auth::guard('agent')->user()) {
            if (Auth::guard('agent')->user()->email_verified == 1)
            {
                return redirect()->route('landlord.agent.dashboard');
            }
        }

        return view(self::BASE_PATH.'email-verify');
    }

    public function check_verify_agent_email(Request $request)
    {
        $this->validate($request, [
            'verify_code' => 'required|string'
        ]);
        $user_info = Agent::where(['id' => Auth::guard('agent')->id(), 'email_verify_token' => $request->verify_code])->first();
        if (is_null($user_info)) {
            return back()->with(['msg' => __('enter a valid verify code'), 'type' => 'danger']);
        }

        $user_info->email_verified = 1;
        $user_info->save();

        return redirect()->route('landlord.agent.dashboard');
    }

    public function resend_verify_agent_email(Request $request)
    {
        VerifyUserMailSend::sendMail(Auth::guard('agent')->user());
        return redirect()->route('landlord.agent.email.verify')->with(['msg' => __('Verify mail send'), 'type' => 'success']);
    }

    public function agent_logout()
    {
        Auth::guard('agent')->logout();
        return redirect()->route('landlord.agent.login');
    }

}
