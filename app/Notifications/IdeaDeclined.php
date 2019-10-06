<?php

namespace App\Notifications;

use App\Channels\VkChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class IdeaDeclined extends Notification implements ShouldQueue
{
    use Queueable;

    private $idea;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($idea)
    {
        $this->idea = $idea;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', VkChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->greeting('Добрый день!')->subject('Идея проекта нуждается в доработке')
                    ->line("Ваша идея для проекта \"".$this->idea->name."\" нуждается в доработке. Пожалуйста, внесите изменения и сообщите об этом преподавателю.")->action('Подробнее', url("/insider/ideas/".$this->idea->id));
    }

    public function toVk($notifiable)
    {
        return "🤔 Ваша идея для проекта \"".$this->idea->name."\" нуждается в доработке. Пожалуйста, внесите изменения и сообщите об этом преподавателю.\n\n🔗 Подробнее: ".url("/insider/ideas/".$this->idea->id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
