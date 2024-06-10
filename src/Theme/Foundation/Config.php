<?php

namespace Plott\PlottTheme\Foundation;

use ArrayAccess;
use Plott\PlottTheme\Contract\ConfigInterface;

class Config implements ConfigInterface, ArrayAccess
{

    /**
     * All of the config items
     * 
     * @var array
     */
    protected $items = [];

    /**
     * Create a new config repo
     * 
     * @param array $items
     * 
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Determine if the given config value exists.
     * 
     * @param string $key
     * 
     * @return bool
     */
    public function has($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * Get the specified config value
     * 
     * @param string $key
     * @param mixed $default
     * 
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (!isset($this->items[$key])) {
            return $default;
        }

        return apply_filters("plott/plotttheme/cofig/get/{$key}", $this->items[$key]);
    }

    /**
     * Set a given config value
     * 
     * @param array|string $key
     * @param mixed $value
     * 
     * @return void
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            $this->items[$key] = apply_filters("plott/plotttheme/config/set/{$key}", $value);
        }
    }

    /**
     * Get all of the config items for the app
     * 
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Determine if the given config option exists.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function offsetExists(mixed $key): bool
    {
        return $this->has($key);
    }

    /**
     * Get a config option
     * 
     * @param string $key
     * @param mixed $value
     * 
     * @return void
     */
    public function offsetGet($key)
    {
        $this->set($key);
    }

    /**
     * Set a config option
     * 
     * @param string $key
     * @param mixed $value
     * 
     * @return void
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Unset a config option
     * 
     * @param string $key
     * 
     * @return void
     */

    public function offsetUnset(mixed $key): void
    {
        $this->set($key, null);
    }
}
