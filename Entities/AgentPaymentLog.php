<?php

namespace Modules\Agent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentPaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function agent(){
        return $this->belongsTo(Agent::class);
    }
}
