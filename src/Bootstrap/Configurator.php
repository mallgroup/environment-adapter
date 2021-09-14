<?php
declare(strict_types=1);

namespace Mallgroup\Bootstrap;

use Mallgroup\DI\Config\Adapters\EnvironmentAdapter;
use Nette\Bootstrap;
use Nette\DI\Config\Loader;
use function debug_backtrace;

class Configurator extends Bootstrap\Configurator
{
    protected function createLoader(): Loader
    {
        $loader = parent::createLoader();
        $loader->addAdapter('env', EnvironmentAdapter::class);
        return $loader;
    }


	/**
	 * @return array<mixed>
	 */
	protected function getDefaultParameters(): array
	{
		$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

		$parameters = parent::getDefaultParameters();
		$parameters['appDir'] = dirname((string)$trace[2]['file']);

		return $parameters;
	}
}
