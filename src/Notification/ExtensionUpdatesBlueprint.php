<?php

namespace Extiverse\Mercury\Notification;

use Flarum\Notification\MailableInterface;
use Illuminate\Support\Collection;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExtensionUpdatesBlueprint implements MailableInterface
{
    public Collection $updates;

    public function __construct(Collection $updates)
    {
        $this->updates = $updates;
    }

    public function getEmailView()
    {
        return 'extiverse-mercury::email.new-extension-updates';
    }

    public function getEmailSubject(TranslatorInterface $translator)
    {
        return $translator->trans('extiverse-mercury.email.new-extension-update.subject', [
            'count' => $this->updates->count()
        ]);
    }
}
