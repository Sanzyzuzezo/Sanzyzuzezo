<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DynamicEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function build() {
        $data = $this->data;

        return $this->subject($data['subject'])
            ->view('mail-template', ['data' => $data]);
    }
}
