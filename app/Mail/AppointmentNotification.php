<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $student;
    public $counselor;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->student = $appointment->student;
        $this->counselor = $appointment->counselor;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('📬 Appointment Confirmation - LCSHS SCMS')
                    ->view('emails_appointment_notification')
                    ->with([
                        'appointment' => $this->appointment,
                        'student' => $this->student,
                        'counselor' => $this->counselor,
                    ]);
    }
}
