<?php

use Flarum\Extend;
use Riclep\FlarumLettermintMail\LettermintDriver;

return [
    (new Extend\Mail())
        ->driver('lettermint', LettermintDriver::class),

    new Extend\Locales(__DIR__ . '/locale'),
];
