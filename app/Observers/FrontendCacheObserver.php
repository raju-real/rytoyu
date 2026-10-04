<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class FrontendCacheObserver
{
    /**
     * Flush frontend cache on any model manipulation
     */
    protected function flushFrontendCache()
    {
        Cache::tags(['frontend'])->flush();
    }

    public function saved($model)
    {
        $this->flushFrontendCache();
    }

    public function deleted($model)
    {
        $this->flushFrontendCache();
    }

    public function restored($model)
    {
        $this->flushFrontendCache();
    }

    public function forceDeleted($model)
    {
        $this->flushFrontendCache();
    }
}
