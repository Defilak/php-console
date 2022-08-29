<?php

namespace Console;

abstract class Command
{
    protected function __construct(
        protected readonly string $name
    ) {
    }

    protected function setArgument()
    {
    }

    protected function setOption()
    {
    }

    protected abstract function getDescription();

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }
}
