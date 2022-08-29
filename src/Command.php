<?php

namespace Console;

use Console\Parser\ArgumentParser;

abstract class Command
{
    public const SUCCESS = 0;
    public const FAILTURE = 1;

    private $description;

    protected function __construct(
        protected readonly string $name
    ) {
    }

    public abstract function execute(ArgumentParser $args): int;

    public function getHelp()
    {
        return "$this->name - $this->description\n";
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}
