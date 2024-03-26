<?php

namespace Modules\Agent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentWallet extends Model
{
    use HasFactory;

    protected $fillable = ['balance', 'payment_method', 'payment_details'];
    
    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
