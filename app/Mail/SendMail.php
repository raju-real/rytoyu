<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mail_data;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = $this->view('mail.mail_template');
        $view->subject($this->mail_data['subject'] ?? 'No Subject');
        $view->body = $this->mail_data['body'];
        if (!empty($this->mail_data['files'])) {
            foreach ($this->details['files'] as $file_path) {
                if (file_exists($file_path)) {
                    $this->attach($file_path);
                }
            }
        }
        return $view;
    }
}
