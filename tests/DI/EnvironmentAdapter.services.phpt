<?php

/**
 * Test: Nette\DI\Config\Adapters\NeonAdapter
 */

declare(strict_types=1);

use Mallgroup\DI\Config\Adapters\EnvironmentAdapter;
use Nette\DI\Definitions\Statement;
use Nette\DI\InvalidConfigurationException;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$adapter = new EnvironmentAdapter;
$data = $adapter->load(
		Tester\FileMock::create(
				'
service_user: ::string(secret_user)
service_password: ::string(secret_password, true)
service_port: ::int(1234)
service_nonstring: ::nonstring(1234)
',
				'env'
		)
);

Assert::equal(
		[
				'parameters' => [
						'env' =>
								[
										'service_user' => 'secret_user',
										'service_password' => new Statement(
												'Mallgroup\Environment::string',
												[
														'name' => 'SERVICE_PASSWORD',
														'cast' => 'string',
														'default' => 'secret_password'
												]
										),
										'service_port' => 1234,
										'service_nonstring' => '1234'
								]
				]
		],
		$data,
);

Assert::exception(function () use ($adapter) {
	$adapter->load(
			Tester\FileMock::create(
					'
service_user: test
',
					'env'
			)
	);
}, InvalidConfigurationException::class);