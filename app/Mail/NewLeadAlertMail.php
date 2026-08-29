<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Lead;

class NewLeadAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lead;

    public function __construct(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function build()
    {
        return $this->subject('🔥 New Student Inquiry: ' . $this->lead->name)
                    ->html("
                        <h3>New Student Admission Inquiry</h3>
                        <p><strong>Name:</strong> {$this->lead->name}</p>
                        <p><strong>Phone:</strong> <a href='tel:{$this->lead->phone}'>{$this->lead->phone}</a></p>
                        <p><strong>Email:</strong> {$this->lead->email}</p>
                        <p><strong>City:</strong> {$this->lead->city}</p>
                        <p><strong>Target College:</strong> " . ($this->lead->college->name ?? 'General Inquiry') . "</p>
                        <br>
                        <a href='" . route('admin.leads.index') . "' style='background:#F5A623;color:#000;padding:10px 20px;text-decoration:none;border-radius:6px;font-weight:bold;'>Open Leads CRM</a>
                    ");
    }
}