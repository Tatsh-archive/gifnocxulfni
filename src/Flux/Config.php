<?php
namespace Flux;

/**
 * Configuration container object.
 */
class Config implements \ArrayAccess, \Countable
{
    private $config = [];

    /**
     * Length of the array.
     *
     * @return integer Length of the array.
     */
    public function count()
    {
        return count($this->config);
    }

    /**
     * Checks if a key exists.
     *
     * @param string $offset Key.
     *
     * @return boolean If key exists.
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->config);
    }

    /**
     * Gets a value by key.
     *
     * @param string $offset Key.
     *
     * @return mixed Key value. If the key does not exist, a warning may be
     *   issued or exception thrown depending on your error handling.
     */
    public function offsetGet($offset)
    {
        return $this->config[$offset];
    }

    /**
     * Sets a key.
     *
     * @param string $offset Key.
     * @param mixed $value  Value.
     */
    public function offsetSet($offset, $value)
    {
        $this->config[$offset] = $value;
    }

    /**
     * Removes a value.
     *
     * @param string $offset Key name.
     */
    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

    /**
     * Get a value.
     *
     * @param string $key     Key.
     * @param mixed  $default Default value.
     *
     * @return mixed Stored value or default value.
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : $default;
    }

    /**
     * Removes a value.
     *
     * @param string $key Key name.
     *
     * @see #offsetUnset
     */
    public function remove($key)
    {
        unset($this->config[$key]);
    }

    /**
     * Set a value.
     *
     * @param string $key   Key name.
     * @param mixed  $value Default value.
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * `#__toString()` implementation.
     *
     * @return string JSON representation of the contained array.
     */
    public function __toString()
    {
        if (!$this->config) {
            return '{}';
        }

        return json_encode($this->config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
