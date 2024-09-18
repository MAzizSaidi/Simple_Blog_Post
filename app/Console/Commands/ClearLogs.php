<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the Laravel log files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Specify the path to the log file or folder
        $logPath = storage_path('logs/laravel.log');

        // Check if the log file exists
        if (File::exists($logPath)) {
            // Clear the contents of the log file
            file_put_contents($logPath, '');
            $this->info('Laravel logs have been cleared.');
        } else {
            $this->error('No log file found.');
        }
    }
}
