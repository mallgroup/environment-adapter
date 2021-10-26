![](https://heatbadger.now.sh/github/readme/mallgroup/environment-adapter/)

# Mallgroup/Environment-adapter
Adapter for Nette so you can use *.env config files.

[![Coverage Status](https://img.shields.io/coveralls/github/mallgroup/environment-adapter/master)](https://coveralls.io/github/mallgroup/environment-adapter?branch=master)
[![Build Status](https://img.shields.io/github/workflow/status/mallgroup/environment-adapter/Tests/master)](https://github.com/mallgroup/environment-adapter/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/mallgroup/environment-adapter.svg)](https://packagist.org/packages/mallgroup/environment-adapter)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/quality/g/mallgroup/environment-adapter/master)](https://scrutinizer-ci.com/g/mallgroup/environment-adapter/?branch=master)
[![Latest stable](https://img.shields.io/packagist/v/mallgroup/environment-adapter.svg)](https://packagist.org/packages/mallgroup/environment-adapter)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/mallgroup/environment-adapter/blob/master/license.md)

Installation
------------

The best way to install Mallgroup/Environment-adapter is using [Composer](http://getcomposer.org/):

```sh
$ composer require mallgroup/environment-adapter
```

## Development

This package is currently maintaining by these authors.

<a href="https://github.com/bckp"><img width="80" height="80" src="https://avatars.githubusercontent.com/u/179652?v=4&s=80"></a>
<a href="https://github.com/mallgroup"><img width="80" height="80" src="https://avatars.githubusercontent.com/u/23184995?v=4&s=80"></a>

## How to use

For use this adapter, you need to use Mallgroup/Configurator instead of Nette one. It will autoregister ENV extension support. After that, you can simply link `some-name.env` file and nette will inject env variables into %env%.
The expected syntax is
name_of_env_variable: ::{string|int|float|bool}(default: {string}, hidden: {true|false})
name_of_array_variable: ::array(separator: {string}, hidden: {true|false}, cast: {int|float|bool|string})

first entry is name of ENV variable, this will add `%env.name_of_env_variable%` to the parameters and get value using `getenv('NAME_OF_ENV_VARIABLE');` 
next is `::` that will tell adapter, we are working with entity, this is just shortcut to force nette get arguments using internal mechanism.
after that, we have `cast` part, this tells adapter, what type of variable he should cast to, usefull as env know only strings, with this, you can have INTs, FLOATs, BOOLs and even ARRAY of INT, FLOAT, STRING, BOOL.

attributes inside
```text
default: that is fallback, if no value is found using getenv.
hidden: if variable must remain secret, or we can burn it into generated container file (if we have password, we do not want to have it stored in PHP file, but kept it in ENV only)
cast: only for Array, cast values to specific type
separator: only for Array, used for explode
```

if you keep order of arguments same as Environment class expect, you can omit their names.

### Example file
```text
service_user: ::string(secret_user)
service_password: ::string(secret_password, true)
service_port: ::int(1234)
service_nonstring: ::nonstring(1234)
service_active: ::bool(\'false\')
service_array: ::array(cast: int)
```
with .env
```text
SERVICE_USER=someuser
SERVICE_PASSWORD=supersecret
SERVICE_ARRAY=1|2|3|4
```

will be translated to if none ENV 

```php
[
	'service_user' => 'someuser',
	'service_password' => Mallgroup\Environment::string('SERVICE_PASSWORD', 'secret_password'),
	'service_port' => 1234,
	'service_nonstring' => '1234',
	'service_active' => false # notice string false is translated to the boolean correctly
	'service_array' => [1,2,3,4],
]
```