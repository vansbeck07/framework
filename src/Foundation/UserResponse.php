<?php

/*
 * This file is part of the Splash package.
 *
 * (c) Evans Owusu Ofori <vansbeck07@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Splash\Foundation;

/**
 * Implements methods to easily access all the user's responses.
 *
 * @author Evans Owusu Ofori <vansbeck07@gmail.com>
 */
class UserResponse implements \ArrayAccess
{
    protected $responses = [];

    public function __construct($responses)
    {
        $this->responses = $responses;
    }

    public function get($menuName, $silent = false, $index = -1)
    {
        if (!isset($this->responses[$menuName])) {
            if ($silent) {
                return null;
            }

            throw new \Exception('No user response associated to the menu "'.$menuName.'"');
        }

        $len = count($this->responses[$menuName]);
        $index = $index === -1 ? $len - 1 : $index;

        if (!isset($this->responses[$menuName][$index])) {
            if ($silent) {
                return null;
            }

            throw new \Exception('No user response at the index '.$index);
        }

        return $this->responses[$menuName][$index];
    }

    public function getAll($menuName)
    {
        if (!isset($this->responses[$menuName])) {
            throw new \Exception('No user response for the menu '.$menuName);
        }

        return $this->responses[$menuName];
    }

    public function all($menuName)
    {
        return $this->getAll($menuName);
    }

    public function has($menuName, $index = -1)
    {
        if (
            !isset($this->responses[$menuName]) ||
            count($this->responses[$menuName]) <= 0
        ) {
            return false;
        }

        $len = count($this->responses[$menuName]);
        $index = $index === -1 ? $len - 1 : $index;

        return isset($this->responses[$menuName][$index]);
    }

    // ArrayAccess Interface
    public function offsetExists(mixed $menuName): bool
    {
        return isset($this->responses[$menuName]);
    }

    public function offsetGet(mixed $menuName): mixed
    {
        return $this->getAll($menuName);
    }

    public function offsetSet(mixed $menuName, mixed $value): void
    {
        if (!is_array($value)) {
            throw new \Exception('User response must be contain an array');
        }

        if (is_null($menuName)) {
            throw new \Exception('Cannot set a user response without the corresponding menu_name as index!');
        } else {
            $this->responses[$menuName] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->responses[$offset]);
    }
}
