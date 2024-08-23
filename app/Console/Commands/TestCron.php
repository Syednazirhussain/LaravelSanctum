<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a test cron job to get the users from jsonplaceholder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("Cron Job running at ". now());
        $response = Http::get(config('app.cron_url'));
        
        $users = $response->json();

        if (!empty($users)) {
            foreach ($users as $user) {
                info("Name: ". $user['name']. ", Email: ". $user['email']);
            }
        }
    }
}
