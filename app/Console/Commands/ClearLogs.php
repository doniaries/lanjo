<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the Laravel log files so only new errors appear';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logPath = storage_path('logs/laravel.log');

        if (\Illuminate\Support\Facades\File::exists($logPath)) {
            \Illuminate\Support\Facades\File::put($logPath, '');
            $this->info('✓ Log file ' . $logPath . ' has been cleared successfully.');
        } else {
            $this->warn('Log file does not exist yet.');
        }
    }
}
