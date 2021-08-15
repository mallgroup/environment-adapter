<?php
declare(strict_types=1);

namespace Mallgroup\Bootstrap;

use Mallgroup\DI\Config\Adapters\EnvironmentAdapter;
use Nette\Bootstrap;
use Nette\DI\Config\Loader;

class Configurator extends Bootstrap\Configurator
{
    private Loader $loader;

    public function __construct() {
        $this->loader = parent::createLoader() ?: new Loader();
        $this->loader->addAdapter('env', EnvironmentAdapter::class);

        parent::__construct();
    }

    public function createLoader(): Loader
    {
        return $this->loader;
    }
}
