<?php

namespace Modules\Agent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentCommission extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function paymentLog(){
        return $this->hasOne(\App\Models\PaymentLog::class, 'payment_log_id', 'id');
    }
    
    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
