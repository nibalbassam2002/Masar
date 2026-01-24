<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Project;

class ProjectInvitationMail extends Mailable
{
    use Queueable;

    public $project;
    public $url;

    
    public function __construct(Project $project, $url)
    {
        $this->project = $project;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Invitation to join project: ' . $this->project->name)
                    ->view('emails.project-invitation');
    }
}