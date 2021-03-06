<?php

namespace App\Listeners;

use App\Events\SearchFormSubmitted;
use App\Mail\SearchSubmittedEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyGuestForSearchSubmission
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SearchFormSubmitted $event)
    {

        Mail::send(new SearchSubmittedEmail($event->formData));
    }
}
