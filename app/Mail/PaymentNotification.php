<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

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

    public function build()
    {
        return $this
            ->subject('New Bookings')
            ->markdown('mail.payment-notification');
    }
}
