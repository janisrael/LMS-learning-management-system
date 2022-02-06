<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Maintenance;

class AutoUpMaintenance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $maintenance;

    /**
     * Create a new job instance.
     */
    public function __construct(Maintenance $maintenance)
    {
        $this->maintenance = $maintenance;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->maintenance->auto_up_on_schedule_end) {
            $this->maintenance->is_active = 0;
            $this->maintenance->save();
        }
    }
}
