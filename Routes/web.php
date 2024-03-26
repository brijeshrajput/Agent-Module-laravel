<?php

use Modules\Agent\Http\Controllers\Frontend\BrPaymentLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*----------------------------------------------------------------------------------------------------------------------------
|                                                      BACKEND ROUTES
|----------------------------------------------------------------------------------------------------------------------------*/

Route::group(['prefix'=>'admin-home'], function() {
    Route::controller(\Modules\Agent\Http\Controllers\Admin\BrAgentController::class)->prefix('agent')->name('landlord.')->middleware(['adminglobalVariable','auth:admin', 'set_lang'])->group(function () {
        Route::get('/', 'index')->name('admin.agent');
        Route::get('/new', 'new_agent')->name('admin.agent.new');
        Route::post('/new','new_agent_store')->name('admin.agent.new.store');
        Route::get('/edit/{id}', 'agent_edit')->name('admin.agent.edit');
        Route::post('/agent-update','agent_update')->name('admin.agent.update');
        Route::post('/agent-password-change','password_change')->name('admin.agent.password.change');
        Route::post('/delete-agent/{id}','agent_delete')->name('admin.agent.delete');

        Route::get('/all','all_agents')->name('admin.agent.view');

        Route::get('/settings', 'settings')->name('admin.agent.settings');

        Route::post('/settings/startup', 'settings_startup')->name('admin.agent.settings.startup');
        Route::post('/settings/basic', 'settings_withdraw')->name('admin.agent.settings.basic');
        Route::post('/settings/payments', 'settings_payments')->name('admin.agent.settings.payments');

        Route::get('/kyc/form', 'kyc_form')->name('admin.agent.kyc.form');
        Route::post('/kyc/form/update', 'update_kyc_form')->name('admin.agent.kyc.form.update');
    });

    Route::controller(Modules\Agent\Http\Controllers\Admin\BrAgentPaymentController::class)->prefix('agent')->name('landlord.')->middleware(['adminglobalVariable','auth:admin', 'set_lang'])->group(function () {
        Route::get('/payments/requests', 'all_payment_requests')->name('admin.agent.payments.requests');
        Route::post('/payments/request/modal', 'payment_request_modal')->name('admin.agent.payments.request.modal');
        Route::post('/payments/request/accept', 'payment_request_accept')->name('admin.agent.payments.request.accept');
        Route::get('/payments/history', 'payment_history')->name('admin.agent.payments.history');

        
    });

});



/*----------------------------------------------------------------------------------------------------------------------------
|                                                      FRONTEND ROUTES (Landlord)
|----------------------------------------------------------------------------------------------------------------------------*/
//if is tenant then change the controller path
if ( is_null(tenant()) || 1) {
    Route::controller(\Modules\Agent\Http\Controllers\Frontend\BrAgentController::class)->prefix('agent')->name('landlord.')->middleware(['landlord_glvar','maintenance_mode', 'set_lang'])->group(function (){
        Route::get('/apply', 'index')->name('agent.apply');
        
        Route::get('/login', 'showAgentLoginForm')->name('agent.login');
        Route::post('agent-login', 'ajax_login')->name('agent.ajax.login');
        Route::get('/register', 'showAgentRegistrationForm')->name('agent.user.register');
        Route::get('/register/{sponsor_code}', 'showAgentRegistrationForm')->name('agent.register');
        Route::post('/register-store', 'agent_user_create')->name('agent.register.store');

        Route::get('/login/forget-password', 'showAgentForgetPasswordForm')->name('agent.forget.password');
        Route::get('/login/reset-password/{agent}/{token}', 'showAgentResetPasswordForm')->name('agent.reset.password');
        Route::post('/login/reset-password', 'AgentResetPassword')->name('agent.reset.password.change');
        Route::post('/login/forget-password', 'sendAgentForgetPasswordMail')->name('agent.forget.password.send');

        Route::get('/verify-email','verify_agent_email')->name('agent.email.verify');
        Route::post('/verify-email','check_verify_agent_email')->name('agent.email.verify.check');
        Route::get('/resend-verify-email','resend_verify_agent_email')->name('agent.email.verify.resend');

        Route::get('/logout','agent_logout')->name('agent.logout');
    });

    Route::controller(\Modules\Agent\Http\Controllers\Frontend\BrAgentDashboardController::class)->prefix('agent')->name('landlord.')->middleware(['landlord_glvar','maintenance_mode', 'set_lang'])->group(function(){
        Route::get('/dashboard', 'dashboard')->name('agent.dashboard');

        Route::get('/kyc/verify', 'kyc_verify')->name('agent.kyc.verify');
        Route::post('/kyc/verify', 'kyc_verify_store')->name('agent.kyc.verify.store');

        Route::get('/my-referrals', 'my_referrals')->name('agent.myreferrals');
        Route::get('/new', 'new_agent')->name('agent.new');
        Route::post('/new', 'new_agent_store')->name('agent.new.store');

        Route::get('/wallet', 'agent_wallet')->name('agent.wallet');
        Route::post('/wallet/withdraw', 'agent_withdraw_modal')->name('agent.withdraw_modal');
        Route::post('/wallet/withdraw/store', 'agent_withdraw_store')->name('agent.withdraw_store');
        Route::get('/commission-history', 'commission_history')->name('agent.commission.history');
        Route::get('/withdrawal-history', 'withdrawal_history')->name('agent.withdrawal.history');

        Route::post('/client', 'return_client_form')->name('agent.client.form');

        Route::get('/client/add', 'add_new_client')->name('agent.client.add');
        Route::post('/client/store', 'create_client')->name('agent.client.store');
        Route::get('/client/view', 'view_client')->name('agent.client.view');
    
        Route::get('/edit-profile', 'edit_profile')->name('agent.edit.profile');
        Route::post('/profile-update', 'agent_profile_update')->name('agent.profile.update');
        Route::post('/password-change', 'agent_password_change')->name('agent.password.change');
        Route::post('/payment-settings', 'agent_payment_settings')->name('agent.payment.settings');

        Route::get('/order-success/{id}','order_payment_success')->name('agent.order.payment.success');
        Route::get('/order-cancel/{id}','order_payment_cancel')->name('agent.order.payment.cancel');
        Route::get('/order-cancel-static','order_payment_cancel_static')->name('agent.order.payment.cancel.static');
        Route::get('/order-confirm/{id}','order_confirm')->name('agent.client.order.confirm');

        Route::get('/notifications','agent_notifications')->name('agent.notifications');

        // Route::get('/agent/support-tickets', 'support_tickets')->name('agent.home.support.tickets');
        // Route::get('support-ticket/view/{id}', 'support_ticket_view')->name('agent.dashboard.support.ticket.view');
        // Route::post('support-ticket/priority-change', 'support_ticket_priority_change')->name('agent.dashboard.support.ticket.priority.change');
        // Route::post('support-ticket/status-change', 'support_ticket_status_change')->name('agent.dashboard.support.ticket.status.change');
        // Route::post('support-ticket/message', 'support_ticket_message')->name('agent.dashboard.support.ticket.message');
    });
}

Route::middleware(['maintenance_mode','landlord_glvar'])->controller(BrPaymentLogController::class)->prefix('agent')->name('landlord.')->group(function () {
    Route::post('/paytm-ipn', 'paytm_ipn')->name('agent.client.paytm.ipn');
    Route::post('/toyyibpay-ipn', 'toyyibpay_ipn')->name('agent.client.toyyibpay.ipn');
    Route::get('/mollie-ipn', 'mollie_ipn')->name('agent.client.mollie.ipn');
    Route::get('/stripe-ipn', 'stripe_ipn')->name('agent.client.stripe.ipn');
    Route::post('/razorpay-ipn', 'razorpay_ipn')->name('agent.client.razorpay.ipn');
    Route::post('/payfast-ipn', 'payfast_ipn')->name('agent.client.payfast.ipn');
    Route::get('/flutterwave/ipn', 'flutterwave_ipn')->name('agent.client.flutterwave.ipn');
    Route::get('/paystack-ipn', 'paystack_ipn')->name('agent.client.paystack.ipn');
    Route::get('/midtrans-ipn', 'midtrans_ipn')->name('agent.client.midtrans.ipn');
    Route::post('/cashfree-ipn', 'cashfree_ipn')->name('agent.client.cashfree.ipn');
    Route::get('/instamojo-ipn', 'instamojo_ipn')->name('agent.client.instamojo.ipn');
    Route::get('/paypal-ipn', 'paypal_ipn')->name('agent.client.paypal.ipn');
    Route::get('/marcadopago-ipn', 'marcadopago_ipn')->name('agent.client.marcadopago.ipn');
    Route::get('/squareup-ipn', 'squareup_ipn')->name('agent.client.squareup.ipn');
    Route::post('/cinetpay-ipn', 'cinetpay_ipn')->name('agent.client.cinetpay.ipn');
    Route::post('/paytabs-ipn', 'paytabs_ipn')->name('agent.client.paytabs.ipn');
    Route::post('/billplz-ipn', 'billplz_ipn')->name('agent.client.billplz.ipn');
    Route::post('/zitopay-ipn', 'zitopay_ipn')->name('agent.client.zitopay.ipn');
    Route::post('/order-confirm','order_payment_form')->name('agent.client.order.payment.form')->middleware('set_lang');
});

Route::prefix('agent')->group(function() {
    Route::get('/home', 'AgentController@index')->name('agent.home');
});

Route::prefix('agent')->group(function() {
    Route::get('/homes', 'AgentController@index')->name('agent.homes');
});
