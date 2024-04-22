<?php

namespace App\Console\Commands;

use App\Models\Orders;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancelOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:orders_cancel';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Cancel an order';

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
        Log::info("Scheduled task 'schedule:orders_cancel' is running.");
    
        $orders = Orders::where("status", "waiting_for_payment")->get();
    
        foreach ($orders as $order) {
            if ($order->payment_due_at && Carbon::now('Asia/Jakarta') >= $order->payment_due_at) {
                $order->update(['status' => 'canceled']);
                Log::info("Order #" . $order->id . " canceled due to payment deadline reached.");
            }
        }
    
        if ($orders->isEmpty()) {
            Log::info("No orders found with status 'waiting_for_payment'.");
        }
    }
    
    
}
