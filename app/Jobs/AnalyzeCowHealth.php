<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class AnalyzeCowHealth implements ShouldQueue
{
    use Queueable, Dispatchable;

    private $cow;

    /**
     * Create a new job instance.
     */
    public function __construct($cow)
    {
        $this->cow = $cow;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
    }
}
