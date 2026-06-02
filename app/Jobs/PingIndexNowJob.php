<?php

namespace App\Jobs;

use App\Services\IndexNowService;
use Illuminate\Contracts\Queue\ShouldQueue;

class PingIndexNowJob implements ShouldQueue
{
    public function __construct(public string $url) {}

    public function handle(IndexNowService $service): void
    {
        $service->submit($this->url);
    }
}
