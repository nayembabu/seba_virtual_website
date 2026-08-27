<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearSessions extends Command
{
    // Command signature and description
    protected $signature = 'clear:sessions';
    protected $description = 'Clear expired sessions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Run the session prune command
        $this->call('session:prune');

        // Optionally, log a message to confirm it worked
        $this->info('Expired sessions cleared successfully');
    }
}
