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
     * @param string $id Entry identifier
     * @param callable $factory A closure that returns an instance.
     */
    public function set($id, callable $factory)
    {
        $this->validateEntryIdentifier($id);

        $this->container[$id] = $factory($this);
    }

    /**
     * 1. Validates that the entry is PSR-11 compliant.
     * 2. We anyway need to ensure we only deal with an unique type for entries (strings).
     *    Otherwise, since instances are contained in an array we could have collisions
     *    because of non strict types.
     *
     * @param mixed $id Entry identifier
     * @throws InvalidEntryIdentifierException The entry is not PSR-11 compliant.
     */
    protected function validateEntryIdentifier($id)
    {
        if (!is_string($id) || (strlen($id) < 1)) {
            throw new InvalidEntryIdentifierException;
        }
    }
}
