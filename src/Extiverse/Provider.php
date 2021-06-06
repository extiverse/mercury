<?php

namespace Extiverse\Mercury\Extiverse;

use Extiverse\Api\Extiverse;
use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Settings\SettingsRepositoryInterface;

class Provider extends AbstractServiceProvider
{
    public function boot(SettingsRepositoryInterface $settings)
    {
        if ($token = $settings->get('extiverse-mercury.token')) {
            Extiverse::instance()->setToken($token);
        }
    }
}
