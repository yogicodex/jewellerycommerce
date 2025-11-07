<?php

// packages/ACME/Reels/src/Config/admin-menu.php

return [
    [
        'key' => 'reels',
        'name' => 'Reels',
        'route' => 'admin.reels.index',
        'sort' => 2,
        'icon' => 'icon-play',
    ],

       // ADD THIS NEW SECTION FOR EVENTS
    [
        'key'   => 'events',
        'name'  => 'Events & Exhibitions',
        'route' => 'admin.event_banners.index',
        'sort'  => 3, // Placed after Reels
        'icon'  => 'icon-calendar',
    ]
];