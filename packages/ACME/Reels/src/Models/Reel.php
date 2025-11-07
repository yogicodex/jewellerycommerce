<?php

namespace ACME\Reels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ACME\Reels\Contracts\Reel as ReelContract;
use Illuminate\Support\Facades\Artisan;

class Reel extends Model implements ReelContract
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'video_path',
        'sort_order',
        'status',
        'placement_key', // This is the line we added
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // Add your attribute casts here
    ];

    /**
     * Booted method to attach model events
     */
    protected static function booted()
    {
        // When a reel is created or updated
        static::saved(function ($reel) {
            static::clearReelCache();
        });

        // When a reel is deleted
        static::deleted(function ($reel) {
            static::clearReelCache();
        });
    }

    /**
     * Clear config, cache, and view automatically
     */
    protected static function clearReelCache()
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
    }
}