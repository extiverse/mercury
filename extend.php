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
        ->css(__DIR__ . '/resources/less/admin.less')
        ->content(Api\Content\AdminPayload::class),

    (new Flarum\Routes('api'))
        ->get('/extiverse/mercury/extension-updates', 'extiverse.mercury.extension-updates', Api\Controller\ExtensionsUpdatesController::class),

    new Flarum\Locales(__DIR__ . '/resources/locale'),
    (new Flarum\View)
        ->namespace('extiverse-mercury', __DIR__ . '/views'),
];
