<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccess extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $userDetails;

    public $paymentMethod;

    public $courses;

    public $total;

    public function __construct($courses, $userDetails, $paymentMethod, $total)
    {
        $this->courses = $courses;
        $this->userDetails = $userDetails;
        $this->paymentMethod = $paymentMethod;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name').' Payment Successful')
            ->markdown('mail.payment');
    }
}
