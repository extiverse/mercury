<?php

namespace Extiverse\Mercury;

use Flarum\Extend as Flarum;

return [
    // Register the Extiverse API client using the token.
    (new Flarum\ServiceProvider)->register(Extiverse\Provider::class),

    (new Flarum\Console)
        ->command(Console\Command\CheckingUpdatesCommand::class),

    (new Flarum\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->content(Api\Content\AdminPayload::class),

    new Flarum\Locales(__DIR__ . '/resource/locale')
];
