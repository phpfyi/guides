<?php

namespace PhpFyi;

use Psr\Container\ContainerInterface;
use ReflectionClass;

class ClassResolver
{
    public function __construct(
        protected ContainerInterface $container,
        protected string $namespace,
        protected array $args = []
    ) {
    }

    public function getInstance(): object
    {
        // check for container entry
        if ($this->container->has($this->namespace)) {
            $binding = $this->container->get($this->namespace);

            // return if there is a container instance / singleton
            if (is_object($binding)) {
                return $binding;
            }
            // sets the namespace to the bound container namespace
            $this->namespace = $binding;
        }
        // create a reflection class
        $refClass = new ReflectionClass($this->namespace);

        // get the constructor
        $constructor = $refClass->getConstructor();

        // check constructor exists and is accessible 
        if ($constructor && $constructor->isPublic()) {
            // check constructor has parameters and resolve them
            if (count($constructor->getParameters()) > 0) {
                $argumentResolver = new ParametersResolver(
                    $this->container,
                    $constructor->getParameters(),
                    $this->args
                );
                // resolve the constructor arguments
                $this->args = $argumentResolver->getArguments();
            }
            // create the new instance with the constructor arguments
            return $refClass->newInstanceArgs($this->args);
        }
        // no arguments so create the new instance without calling the constructor
        return $refClass->newInstanceWithoutConstructor();
    }
}
