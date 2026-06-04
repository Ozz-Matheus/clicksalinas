<?php

namespace App\Jobs;

use App\Services\IndexNowService;

class PingIndexNowJob
{
    public function __construct(public string $url) {}

    public function handle(IndexNowService $service): void
    {
        $service->submit($this->url);
    }
}
