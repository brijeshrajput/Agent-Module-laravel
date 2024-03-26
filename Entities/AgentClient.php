<?php

namespace Modules\Agent\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentClient extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function agent(){
        return $this->belongsTo(Agent::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
