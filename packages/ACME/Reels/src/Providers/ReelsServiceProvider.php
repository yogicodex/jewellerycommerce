<?php

namespace ACME\Reels\Providers;

// use Illuminate\Support\Facades\Blade;
// use ACME\Reels\View\Components\ReelsSection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class ReelsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin-routes.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/shop-routes.php');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'reels');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'reels');

        Event::listen('bagisto.admin.layout.head', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('reels::admin.layouts.style');
        });

        // This is the only registration line you need.
        // Blade::component('reels::reels-section', ReelsSection::class);
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php',
            'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php',
            'acl'
        );
    }
}