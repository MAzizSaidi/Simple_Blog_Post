<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{
    /**
     * Handle the event.
     */
    public function handleCacheHit(object $event): void
    {
        Log::info("{ $event->key } cache hit");
    }
    public function handleCacheMissed(object $event): void
    {
        Log::info("{ $event->key } cache missed");
    }
    public function subscribe($events): void
    {
        $events->listen(
            CacheHit::class,
            [CacheSubscriber::class, 'handleCacheHit']
        );
        $events->listen(
            CacheMissed::class,
            [CacheSubscriber::class, 'handleCacheMissed']
        );
    }
}
