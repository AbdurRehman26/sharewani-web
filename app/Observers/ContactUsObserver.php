<?php

namespace App\Observers;

use App\Data\Models\ContactUs;
use Illuminate\Support\Facades\Mail;

class ContactUsObserver
{
    /**
     * Handle the contact us "created" event.
     *
     * @param ContactUs $contactUs
     * @return void
     */
    public function created(ContactUs $contactUs)
    {
        Mail::to([
            'email' => 'sydabdrehman@gmail.com',
            'name' => 'sydabdrehman@gmail.com',
        ])->send(new \App\Mail\ContactUs($contactUs));
        //
    }

    /**
     * Handle the contact us "updated" event.
     *
     * @param ContactUs $contactUs
     * @return void
     */
    public function updated(ContactUs $contactUs)
    {
        //
    }

    /**
     * Handle the contact us "deleted" event.
     *
     * @param ContactUs $contactUs
     * @return void
     */
    public function deleted(ContactUs $contactUs)
    {
        //
    }

    /**
     * Handle the contact us "restored" event.
     *
     * @param ContactUs $contactUs
     * @return void
     */
    public function restored(ContactUs $contactUs)
    {
        //
    }

    /**
     * Handle the contact us "force deleted" event.
     *
     * @param ContactUs $contactUs
     * @return void
     */
    public function forceDeleted(ContactUs $contactUs)
    {
        //
    }
}
