<?php

namespace App\Observers;

use App\Models\Maintenance;

class MaintenanceObserver
{
    /**
     * Handle the maintenance "created" event.
     *
     * @param \App\Maintenance $maintenance
     */
    public function created(Maintenance $maintenance)
    {
    }

    /**
     * Handle the maintenance "updated" event.
     *
     * @param \App\Maintenance $maintenance
     */
    public function updated(Maintenance $maintenance)
    {
    }

    /**
     * Handle the maintenance "deleted" event.
     *
     * @param \App\Maintenance $maintenance
     */
    public function deleted(Maintenance $maintenance)
    {
    }

    /**
     * Handle the maintenance "restored" event.
     *
     * @param \App\Maintenance $maintenance
     */
    public function restored(Maintenance $maintenance)
    {
    }

    /**
     * Handle the maintenance "force deleted" event.
     *
     * @param \App\Maintenance $maintenance
     */
    public function forceDeleted(Maintenance $maintenance)
    {
    }
}
