<?php
declare(strict_types=1);

namespace Mallgroup\Bootstrap;

use Mallgroup\DI\Config\Adapters\EnvironmentAdapter;
use Nette\Bootstrap;
use Nette\DI\Config\Loader;

class Configurator extends Bootstrap\Configurator
{
    protected function createLoader(): Loader
    {
        $loader = parent::createLoader();
        $loader->addAdapter('env', EnvironmentAdapter::class);
        return $loader;
    }
}
