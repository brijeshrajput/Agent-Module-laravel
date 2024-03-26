<?php

namespace Modules\Agent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Agent extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
//    use LogsActivity;

    protected $guard = 'agent';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'referral_code',
        'email_verified',
        'email_verify_token',
        'mobile',
        'image',
        'is_active',
        'verification_status',
        'verification_info',
        'cash_payment_status',
        'bank_payment_status',
        'bank_name',
        'bank_acc_name',
        'bank_acc_no',
        'bank_branch',
        'bank_routing_no',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verified' => 'integer',
    ];

    public function clients(){
        return $this->hasMany(AgentClient::class);
    }

    public function commissions(){
        return $this->hasMany(AgentCommission::class);
    }

    public function paymentLogs(){
        return $this->hasMany(AgentPaymentLog::class);
    }

    public function wallet(){
        return $this->hasOne(AgentWallet::class);
    }

    public function withdrawRequests(){
        return $this->hasMany(AgentWithdrawRequest::class);
    }

    public function notifications(){
        return $this->hasMany(AgentNotification::class);
    }
}
