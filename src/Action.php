<?php

namespace Croct\WordPress;

final class Action
{
    /** @var string */
    private $name;

    /** @var callable */
    private $callback;

    /**
     * @param string   $name
     * @param callable $callback
     */
    public function __construct($name, callable $callback)
    {
        $this->name = $name;
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed ...$arguments
     *
     * @return mixed
     */
    public function __invoke(...$arguments)
    {
        return \call_user_func_array($this->callback, $arguments);
    }
}
