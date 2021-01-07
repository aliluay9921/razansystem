<?php

namespace App\Console\Commands;

use Carbon\Carbon;

use App\Models\discount_flight;
use Illuminate\Console\Command;

class discountflight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:expier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'discount expier if expire < fromDate ';

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
        $get = discount_flight::where('expair', '>', Carbon::now())->get();
        foreach ($get as $flight) {
            $flight->update(['active' => 0]);
        }
    }
}
