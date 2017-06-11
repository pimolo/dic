<?php

namespace Pimolo\DIC;

use Psr\Container\ContainerExceptionInterface;

/**
 * Thrown if an entry identifier doesn't match the PSR-11 specs.
 */
class InvalidEntryIdentifierException extends \InvalidArgumentException implements ContainerExceptionInterface
{
}
