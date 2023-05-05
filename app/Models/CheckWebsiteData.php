<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckWebsiteData extends Model
{
    use HasFactory;

    protected $table = 'check_website_data';
    protected $guarded = false;
    public $timestamps = false;
}
