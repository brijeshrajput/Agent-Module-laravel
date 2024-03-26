<?php

namespace Modules\Agent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentNotification extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = 'agent_notifications';

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
