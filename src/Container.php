<?php

namespace Pimolo\DIC;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private $container;

    public function __construct()
    {
        $this->container = [];
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $this->validateEntryIdentifier($id);

        if (!$this->has($id)) {
            throw new EntryNotFoundException;
        }

        return $this->container[$id];
    }

    /**
     * @inheritdoc
     */
    public function has($id)
    {
        $this->validateEntryIdentifier($id);

        return array_key_exists($id, $this->container);
    }

    /**
     * Assigns a valid identifier to an instance.
     *
     * @param callable $factory A closure that returns an instance.
     * @param string|null $id Entry identifier, defaults to the FQCN.
     */
    public function set(callable $factory, $id = null)
    {
        $instance = $factory($this);

        $identifier = $id ?? get_class($instance);

        $this->validateEntryIdentifier($identifier);

        $this->container[$identifier] = $instance;
    }

    /**
     * Validates that the identifier is PSR-11 compliant.
     * It's anyway needed to ensure the container only deals with an unique type for identifiers.
     * Otherwise, since instances are contained in an array there could are collisions
     * because of non strict types.
     *
     * @param mixed $id Entry identifier
     * @throws InvalidEntryIdentifierException When the identifier is not PSR-11 compliant.
     */
    private function validateEntryIdentifier($id)
    {
        if (!is_string($id) || (strlen($id) < 1)) {
            throw new InvalidEntryIdentifierException;
        }
    }
}
