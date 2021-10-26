<?php declare(strict_types=1);

namespace Mallgroup;

function setenv(string $name, string|bool $value = false): void
{
	$_ENV["___{$name}___"] = $value;
}

function getenv(string $name): string|false
{
	return $_ENV["___{$name}___"] ?? false;
}
