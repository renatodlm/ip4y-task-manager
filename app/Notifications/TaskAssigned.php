<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * TaskAssigned constructor.
     *
     * @param mixed $task
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Determine which channels the notification should be sent through.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('You have been assigned a new task:')
            ->line('Task: ' . $this->task->title)
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Due date: ' . $this->task->due_date->format('M d, Y'))
            ->line('Thank you for your dedication and hard work. We truly value your contributions!');
    }
}
