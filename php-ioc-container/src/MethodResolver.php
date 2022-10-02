<?php

namespace PhpFyi;

use Psr\Container\ContainerInterface;
use ReflectionMethod;

class MethodResolver
{
    public function __construct(
        protected ContainerInterface $container,
        protected object $instance,
        protected string $method,
        protected array $args = []
    ) {
    }

    public function getValue()
    {
        // inspect the class method
        $method = new ReflectionMethod(
            $this->instance,
            $this->method
        );
        // find and resolve the method arguments
        $argumentResolver = new ParametersResolver(
            $this->container,
            $method->getParameters(),
            $this->args
        );
        // call the method with the resolved arguments
        return $method->invokeArgs(
            $this->instance,
            $argumentResolver->getArguments()
        );
    }
}
