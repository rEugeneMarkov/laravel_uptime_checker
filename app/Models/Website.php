<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Website extends Model
{
    use HasFactory;

    protected $table = 'websites';

    protected $guarded = false;

    protected $casts = [
        'monitoring_status' => 'boolean',
    ];

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

    public function scopeForCheck(Builder $query): void
    {
        $query->whereDoesntHave('checkData')
            ->orWhereHas('checkData', function ($query) {
                $query->select(DB::raw('MAX(checked_at) as last_checked_at'))
                    ->havingRaw('last_checked_at <= NOW() - INTERVAL websites.interval MINUTE');
            });
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('monitoring_status', true);
    }
}
