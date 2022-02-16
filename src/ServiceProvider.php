<?php

namespace Thoughtco\InstagramInstantTokens;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function bootAddon()
    {
        (new Instagram())->renewToken();
    }
}
