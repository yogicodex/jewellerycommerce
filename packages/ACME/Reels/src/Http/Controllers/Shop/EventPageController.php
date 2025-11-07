<?php

namespace ACME\Reels\Http\Controllers\Shop; // <-- IMPORTANT NAMESPACE

use Illuminate\Routing\Controller;
use ACME\Reels\Models\EventBanner;

class EventPageController extends Controller
{
    public function index()
    {
        $banners = EventBanner::where('status', 1)->orderBy('id', 'desc')->get();
        return view('shop::events.index', compact('banners'));
    }
}