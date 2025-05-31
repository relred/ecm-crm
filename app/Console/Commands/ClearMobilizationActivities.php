<?php

namespace App\Console\Commands;

use App\Models\MobilizationActivity;
use Illuminate\Console\Command;

class ClearMobilizationActivities extends Command
{
    protected $signature = 'mobilization:clear';
    protected $description = 'Clear all mobilization activities';

    public function handle()
    {
        if ($this->confirm('Are you sure you want to clear all mobilization activities? This cannot be undone.')) {
            $count = MobilizationActivity::count();
            MobilizationActivity::truncate();
            $this->info("Successfully cleared {$count} mobilization activities.");
        }
    }
} 