<?php

namespace ACME\Reels\Models; // <-- IMPORTANT: ACME Namespace

use Illuminate\Database\Eloquent\Model;

class EventBanner extends Model
{
    protected $table = 'event_banners';

    protected $fillable = [
        'title',
        'path',
        'link',
        'status',
    ];
}