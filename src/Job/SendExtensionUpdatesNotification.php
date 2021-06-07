<?php

namespace Extiverse\Mercury\Job;

use Extiverse\Mercury\Notification\ExtensionUpdatesBlueprint;
use Flarum\Group\Group;
use Flarum\Notification\NotificationMailer;
use Flarum\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SendExtensionUpdatesNotification implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    protected Collection $updates;

    public function __construct(Collection $updates)
    {
        $this->updates = $updates;
    }

    public function handle(NotificationMailer $mailer)
    {
        User::query()
            ->whereHas('groups', function ($query) {
                $query->where('group_id', Group::ADMINISTRATOR_ID);
            })
            ->each(function(User $recipient) use ($mailer) {
                $mailer->send(new ExtensionUpdatesBlueprint($this->updates), $recipient);
            });
    }
}
