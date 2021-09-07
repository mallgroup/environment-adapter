<?php
declare(strict_types=1);

namespace Mallgroup\Bootstrap;

use Composer\Autoload\ClassLoader;
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

	protected function getDefaultParameters(): array
	{
		$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		$last = end($trace);
		$debugMode = static::detectDebugMode();
		$loaderRc = class_exists(ClassLoader::class)
			? new \ReflectionClass(ClassLoader::class)
			: null;
		return [
			'appDir' => isset($trace[2]['file']) ? dirname($trace[2]['file']) : null,
			'wwwDir' => isset($last['file']) ? dirname($last['file']) : null,
			'vendorDir' => $loaderRc ? dirname($loaderRc->getFileName(), 2) : null,
			'debugMode' => $debugMode,
			'productionMode' => !$debugMode,
			'consoleMode' => PHP_SAPI === 'cli',
		];
	}
}
