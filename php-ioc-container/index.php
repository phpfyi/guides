<?php

require __DIR__ . '/vendor/autoload.php';

use PhpFyi\Container;

interface ConfigInterface
{
};
class PHPConfig implements ConfigInterface
{
};
class YAMLConfig implements ConfigInterface
{
};

// creates and returns the same singleton container instance
$container = Container::instance();
if (Container::instance() !== $container) {
    throw new Exception();
}

// bind to container using interface namespace
$container->bind(ConfigInterface::class, PHPConfig::class);
if ($container->get(ConfigInterface::class) !== PHPConfig::class) {
    throw new Exception();
}

// override interface binding
$container->bind(ConfigInterface::class, YAMLConfig::class);
if ($container->get(ConfigInterface::class) !== YAMLConfig::class) {
    throw new Exception();
}

// bind to container using class namespace
$container->bind(PHPConfig::class, YAMLConfig::class);
if ($container->get(PHPConfig::class) !== YAMLConfig::class) {
    throw new Exception();
}

// bind a singleton to the container
$config = new PHPConfig();
$container->singleton(PHPConfig::class, $config);
if ($container->get(PHPConfig::class) !== $config) {
    throw new Exception();
}

// Checks the constructor and method injected params
class App1
{
    public ConfigInterface $methodConfig;

    public function __construct(
        public ConfigInterface $config
    ) {
    }

    public function handle(ConfigInterface $config)
    {
        $this->methodConfig = $config;
    }
}

// Checks the constructor params
$container->bind(ConfigInterface::class, PHPConfig::class);

$app1 = $container->resolve(App1::class);
if (get_class($app1->config) !== PHPConfig::class) {
    throw new Exception();
}

// Checks the method params
$container->resolveMethod($app1, 'handle');
if (get_class($app1->methodConfig) !== PHPConfig::class) {
    throw new Exception();
}

// Checks additional passed params
class App2
{
    public function __construct(
        public ConfigInterface $config,
        public string $arg1,
        public string $arg2,
    ) {
    }
}

$app2 = $container->resolve(App2::class, [
    'arg1' => 'value1',
    'arg2' => 'value2'
]);
if ($app2->arg1 !== 'value1') {
    throw new Exception();
}
if ($app2->arg2 !== 'value2') {
    throw new Exception();
}
