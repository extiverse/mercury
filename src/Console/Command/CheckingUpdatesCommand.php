<?php

namespace Extiverse\Mercury\Console\Command;

use Extiverse\Api\Flarum\UpdatesChecker;
use Extiverse\Api\JsonApi\Types\Extension\Extension;
use Flarum\Extension\ExtensionManager;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Console\Command;

class CheckingUpdatesCommand extends Command
{
    protected $signature = 'mercury:update-check';
    protected $description = 'Check your forum for updates.';

    public function handle(ExtensionManager $manager, SettingsRepositoryInterface $settings)
    {
        if (! $settings->get('extiverse-mercury.token')) {
            $this->error("No token set, update your token settings from the admin area.");

            exit(1);
        }

        $checker = new UpdatesChecker($manager);

        $extensions = $checker->process();

        $settings->set('extiverse-mercury.updates-required', $extensions->filter(function (Extension $extension) {
            return $extension['needs-update'];
        })->count());

        $this->table(
            ['extension', 'needs update?'],
            $extensions
                ->map(function (Extension $extension) {
                    return [$extension->name, $extension['needs-update'] ? 'yes' : 'no'];
                })
                ->toArray()
        );
    }
}
