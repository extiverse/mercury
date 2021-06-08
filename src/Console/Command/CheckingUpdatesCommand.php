<?php

namespace Extiverse\Mercury\Console\Command;

use Extiverse\Api\Flarum\UpdatesChecker;
use Extiverse\Api\JsonApi\Types\Extension\Extension;
use Extiverse\Mercury\Job\SendExtensionUpdatesNotification;
use Flarum\Extension\ExtensionManager;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Support\Collection;

class CheckingUpdatesCommand extends Command
{
    protected $signature = 'mercury:update-check
    {--notify : Notify the admins users by email when new updates are available}';
    protected $description = 'Check your forum for updates.';

    public function handle(ExtensionManager $manager, SettingsRepositoryInterface $settings)
    {
        if (! $settings->get('extiverse-mercury.token')) {
            $this->error("No token set, update your token settings from the admin area.");

            exit(1);
        }

        $checker = new UpdatesChecker($manager);

        $extensions = $checker->process();

        $extensions->prepend($checker->core());

        $updatesAvailable = $extensions->filter(function (Extension $extension) {
            return $extension['needs-update'];
        });

        $settings->set('extiverse-mercury.updates-required', $updatesAvailable->count());

        if ($updatesAvailable && $this->option('notify')) {
            $this->notify($updatesAvailable);
        }

        $this->table(
            ['extension', 'needs update?'],
            $extensions
                ->map(function (Extension $extension) {
                    return [$extension->name, $extension['needs-update'] ? 'yes' : 'no'];
                })
                ->toArray()
        );
    }

    private function notify(Collection $extensions)
    {
        /** @var Queue $queue */
        $queue = resolve(Queue::class);

        $queue->push(new SendExtensionUpdatesNotification($extensions));
    }
}
