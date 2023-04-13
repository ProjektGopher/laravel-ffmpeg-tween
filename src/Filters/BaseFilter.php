<?php

namespace ProjektGopher\FFMpegTools\Filters;

abstract class BaseFilter
{
    protected string $filter_name;

    protected array $properties = [];

    final public function __construct()
    {
    }

    public static function make(): static
    {
        return new static();
    }

    public function build(): string
    {
        $properties = [];

        foreach ($this->properties as $key => $value) {
            strpos($value, ' ') !== false
                ? $properties[] = "{$key}='{$value}'"
                : $properties[] = "{$key}={$value}";
        }

        $properties = implode(':', $properties);

        return "{$this->filter_name}={$properties}";
    }

    public function __toString(): string
    {
        return $this->build();
    }

    public function __call(string $name, array $arguments): self
    {
        $this->properties[$name] = (string) $arguments[0];

        return $this;
    }
}
