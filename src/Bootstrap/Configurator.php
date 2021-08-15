<?php
declare(strict_types=1);

namespace Mallgroup\Bootstrap;

use Mallgroup\DI\Config\Adapters\EnvironmentAdapter;
use Nette\Bootstrap;
use Nette\DI\Config\Loader;

class Configurator extends Bootstrap\Configurator
{
    private Loader $loader;

    public function createLoader(): Loader
    {
        $this->loader ??= parent::createLoader();
        return $this->loader;
    }

    public function __construct()
    {
        parent::__construct();
        $this->createLoader()->addAdapter('env', EnvironmentAdapter::class);
    }
}
