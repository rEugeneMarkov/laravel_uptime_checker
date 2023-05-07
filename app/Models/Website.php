<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Website extends Model
{
    use HasFactory;

    protected $table = 'websites';
    protected $guarded = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkErrors()
    {
        return $this->hasMany(CheckError::class);
    }

    public function checkData()
    {
        return $this->hasMany(CheckWebsiteData::class);
    }
}
