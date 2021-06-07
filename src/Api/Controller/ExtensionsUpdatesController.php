<?php

namespace Extiverse\Mercury\Api\Controller;

use Extiverse\Api\Flarum\UpdatesChecker;
use Extiverse\Api\JsonApi\Types\Extension\Extension;
use Flarum\Extension\ExtensionManager;
use Flarum\Http\RequestUtil;
use Flarum\Settings\SettingsRepositoryInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExtensionsUpdatesController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        RequestUtil::getActor($request)->assertAdmin();

        /** @var ExtensionManager $manager */
        $manager = resolve(ExtensionManager::class);

        $checker = new UpdatesChecker($manager);

        $extensions = $checker->process();

        /** @var SettingsRepositoryInterface $settings */
        $settings = resolve(SettingsRepositoryInterface::class);

        $settings->set('extiverse-mercury.updates-required', $extensions->filter(function (Extension $extension) {
            return $extension['needs-update'];
        })->count());

        return new JsonResponse($extensions->toArray());
    }
}
