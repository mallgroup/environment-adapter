<?php

namespace Mallgroup\DI\Adapters;
use Mallgroup\Environment;
use Nette\DI\Config\Adapter;
use Nette\DI\InvalidConfigurationException;
use Nette\Neon\Entity;
use Nette\Neon\Neon;
use Nette\Utils\FileSystem;
use function strtoupper;

class EnvironmentAdapter implements Adapter {
	/**
	 * Reads configuration from PHP file.
	 */
	public function load(string $file): array
	{
		return $this->process(Neon::decode(FileSystem::read($file)));
	}

	protected function process(array $data): array {
		$envs = getenv();

		foreach ($data as $name => $entity) {
			if (!$entity instanceof Entity) {
				throw new InvalidConfigurationException("Invalid argument type ({$name}). Expected Entity, got " . gettype($entity));
			}

			$default = $entity->attributes[0] ?? '';
			$cast = substr($entity->value, 2);
			$name = strtoupper($name);

			$envs[$name] = (new Environment($name, $default))->get($cast);

			// Link for idiots
			$envs[strtolower($name)] = &$envs[$name];
		}
		return ['parameters' => ['env' => $envs]];
	}


	/**
	 * Generates configuration in PHP format.
	 */
	public function dump(array $data): string
	{
		return "# generated by Nette\n\n" . Neon::encode($data, Neon::BLOCK);
	}
}