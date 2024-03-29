<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckWebsiteData extends Model
{
    use HasFactory;

    protected $table = 'check_website_data';

    protected $guarded = false;

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function scopeSubDay(Builder $query): void
    {
        $query->where('checked_at', '>=', Carbon::now()->subDay())
            ->orderBy('checked_at');
    }
}
