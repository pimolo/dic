<?php

namespace Pimolo\DIC;

use Psr\Container\NotFoundExceptionInterface;

class EntryNotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
