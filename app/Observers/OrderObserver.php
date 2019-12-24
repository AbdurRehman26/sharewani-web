<?php

namespace App\Observers;

use App\Data\Models\Order;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the contact us "created" event.
     *
     * @param order $order
     * @return void
     */
    public function created(Order $order)
    {
    	\Log::info('Created');
    	\Log::info(json_encode($order));
    }

 	/**
     * Handle the contact us "created" event.
     *
     * @param order $order
     * @return void
     */
    public function saved(Order $order)
    {
    	\Log::info('stroing');
    	\Log::info(json_encode($order));
    }
   
   	/**
     * Handle the contact us "updated" event.
     *
     * @param order $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the contact us "deleted" event.
     *
     * @param order $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    	\Log::info('Deleting');
    	\Log::info(json_encode($order));
    }

    /**
     * Handle the contact us "restored" event.
     *
     * @param order $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the contact us "force deleted" event.
     *
     * @param order $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
