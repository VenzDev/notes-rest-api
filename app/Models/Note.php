<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Note extends Model
{
    use HasFactory;

    public $timestamps = ["created_at"];

    protected $fillable = ['latest_version_id'];


    public function allVersions()
    {
        return $this->hasMany('App\Models\Version');
    }
}
