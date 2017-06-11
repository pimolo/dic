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

        return isset($this->container[$id]);
    }

    /**
     * Assigns a valid entry identifier to an instance.
     *
     * @param callable $factory A closure that returns an instance.
     * @param string|null $id Entry identifier, defaults to the FQCN.
     */
    public function set(callable $factory, $id = null)
    {
        $instance = $factory($this);

        $entry = $id ?? get_class($instance);

        $this->validateEntryIdentifier($entry);

        $this->container[$entry] = $instance;
    }

    /**
     * 1. Validates that the entry is PSR-11 compliant.
     * 2. It's anyway needed to ensure the container only deals with an unique type for entries (strings).
     *    Otherwise, since instances are contained in an array there could are collisions
     *    because of non strict types.
     *
     * Please note it is "protected" only for testing purposes, and it's not a good thing to override it.
     *
     * @param mixed $id Entry identifier
     * @throws InvalidEntryIdentifierException When the entry is not PSR-11 compliant.
     */
    protected function validateEntryIdentifier($id)
    {
        if (!is_string($id) || (strlen($id) < 1)) {
            throw new InvalidEntryIdentifierException;
        }
    }
}
