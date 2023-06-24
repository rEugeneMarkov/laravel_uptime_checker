<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckError extends Model
{
    use HasFactory;

    protected $table = 'check_errors';
    protected $guarded = false;

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
