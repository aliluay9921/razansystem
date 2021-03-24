<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class deletePnr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PNR:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'pnrExpire';

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
        $order = Order::whereNotNull('PNR')->get();
        $order->delete();
    }
}