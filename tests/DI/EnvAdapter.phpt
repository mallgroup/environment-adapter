<?php

/**
 * Test: Nette\DI\Config\Adapters\NeonAdapter
 */

declare(strict_types=1);

use Mallgroup\DI\Config\Adapters\EnvironmentAdapter;
use Nette\DI\Definitions\Statement;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$adapter = new EnvironmentAdapter;
$data = $adapter->load(Tester\FileMock::create('
service_user: ::env(secret_user)
service_password: ::env(secret_password, true )
', 'env'));

Assert::equal(
    [
        'service_user' => 'secret_user',
        'service_password' => new Statement('\Mallgroup\Environment::string', ['service_password', 'secret_password']),
    ],
    $data,
);