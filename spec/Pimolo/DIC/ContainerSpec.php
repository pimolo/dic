<?php

namespace spec\Pimolo\DIC;

use Pimolo\DIC\Container;
use PhpSpec\ObjectBehavior;
use Pimolo\DIC\EntryNotFoundException;
use Pimolo\DIC\InvalidEntryIdentifierException;
use Prophecy\Argument;
use Psr\Container\ContainerInterface;

class ContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
        $this->shouldImplement(ContainerInterface::class);
    }

    function it_should_return_instance_retrievable_by_fqcn()
    {
        $datetime = new \DateTime();

        $this->set(function () use ($datetime) {
            return $datetime;
        });

        $this->get(\DateTime::class)->shouldReturn($datetime);
    }

    function it_should_return_instance_retrievable_by_entry()
    {
        $this->set(function () {
            return 'scalar';
        }, 'this is not an object');

        $this->get('this is not an object')->shouldReturn('scalar');
    }

    function it_should_determine_if_entry_is_defined()
    {
        $this->set(function () {}, 'valid entry');
        $this->has('valid entry')->shouldReturn(true);
        $this->has('unknown entry')->shouldReturn(false);
    }

    function it_should_throw_exception_if_entry_not_found()
    {
        $this->shouldThrow(EntryNotFoundException::class)->duringGet('unknown entry');
    }

    function it_should_throw_exception_if_illegal_entry()
    {
        $this->shouldThrow(InvalidEntryIdentifierException::class)->duringHas('');
        $this->shouldThrow(InvalidEntryIdentifierException::class)->duringGet(null);
        $this->shouldThrow(InvalidEntryIdentifierException::class)->duringGet(false);
        $this->shouldThrow(InvalidEntryIdentifierException::class)->duringSet(function () {}, true);
    }
}
