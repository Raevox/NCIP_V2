<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ApplicantRegistration; // Add this import

class AccountApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\ApplicantRegistration  $applicant
     * @return void
     */
    public function __construct(ApplicantRegistration $applicant)
    {
        $this->applicant = $applicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('NCIP Account Approval Notification')
                    ->view('emails.account_approved');
    }
}