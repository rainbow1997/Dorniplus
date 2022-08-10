<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterNotification extends Notification
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('ثبت نام در درنیپلاس')
            ->greeting('درنیپلاس')
            ->line("کاربر گرامی ثبت نام شما با نام کاربری:" .
                $this->user->username .
                " با موفقیت انجام شد.")
            ->line('از ثبت نام شما در درنیپلاس متشکریم')
            ->line('برای احراز هویت کد زیر را پس از ورود به سیستم وارد نمائید.')
            ->line('کد احراز هویت شما:')
            ->line($this->user->emailVerificationCode->token)
            ->action('ورود به صفحه احراز هویت', url('/login'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
