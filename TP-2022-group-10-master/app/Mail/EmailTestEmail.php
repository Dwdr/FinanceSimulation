<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTestEmail extends Mailable
{
  use Queueable, SerializesModels;
  protected $emailData;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($emailData)
  {
    $this->emailData = $emailData;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this
      ->from($this->emailData["email_from"])
      ->to($this->emailData["email_to"])
      ->subject($this->emailData["email_subject"])
      ->view('emails.email_test_email')
      ->text('emails.email_test_email_plaintext')
      ->with([
        'email_contents' => $this->emailData["email_contents"]
      ]);
  }
}
