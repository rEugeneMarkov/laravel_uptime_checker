<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
