<?php

namespace Extiverse\Mercury\Console\Command;

use Extiverse\Api\Flarum\UpdatesChecker;
use Flarum\Extension\ExtensionManager;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\Container;

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


    }
}
