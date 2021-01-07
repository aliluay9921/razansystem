<?php

namespace App\Console\Commands;

use App\Models\Flightplan;
use Illuminate\Console\Command;

class expier_flightplan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flightplanexpire:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'flightline_expaier';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $get = Flightplan::where('active', 1)->get();
        foreach ($get as $flight) {
            $flight->update(['active' => 0]);
        }
    }
}
