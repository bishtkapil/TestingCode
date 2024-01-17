<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRecordNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $newRecord;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($newRecord)
    {
        //
        $this->newRecord = $newRecord;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->view('emails.new_record_notification')
        ->subject('New Record Inserted');
    }


}
