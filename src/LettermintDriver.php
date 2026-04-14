<?php

namespace Riclep\FlarumLettermintMail;

use Flarum\Mail\DriverInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\MessageBag;
use Lettermint\Laravel\Transport\LettermintTransportFactory;
use Lettermint\Lettermint;
use Symfony\Component\Mailer\Transport\TransportInterface;

class LettermintDriver implements DriverInterface
{
    public function availableSettings(): array
    {
        return [
            'lettermint_api_token' => '',
            'lettermint_route' => '',
        ];
    }

    public function validate(SettingsRepositoryInterface $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings->all(), [
            'lettermint_api_token' => 'required',
            'lettermint_route' => 'nullable|string',
        ])->errors();
    }

    public function canSend(): bool
    {
        return true;
    }

    public function buildTransport(SettingsRepositoryInterface $settings): TransportInterface
    {
        $apiKey = $settings->get('lettermint_api_token');
        $route = $settings->get('lettermint_route');

        $lettermint = new Lettermint($apiKey);

        $config = [];
        if ($route) {
            $config['route_id'] = $route;
        }

        return new LettermintTransportFactory($lettermint, $config);
    }

    public function getTitle(): string
    {
        return 'lettermint';
    }
}
