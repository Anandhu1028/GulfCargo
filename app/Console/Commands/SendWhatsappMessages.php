<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendWhatsappMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        return $this->call('queue:work', [
            '--stop-when-empty' => null,
        ]);
    }
}
