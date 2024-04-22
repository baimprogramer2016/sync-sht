<?php

namespace App\Console;

use App\Models\Synchronize;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Crypt;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $data_sinkronisasi = Synchronize::where('active', 1)->get();
        if ($data_sinkronisasi->count() > 0) {
            foreach ($data_sinkronisasi as $item_sinkronisasi_kernel) {
                $schedule->call('App\Http\Controllers\SynchronizeController@runSynchronize', ["id_synchronize" => Crypt::encrypt($item_sinkronisasi_kernel->id)])->cron($item_sinkronisasi_kernel->cron);
            }
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
