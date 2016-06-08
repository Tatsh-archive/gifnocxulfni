<?php
namespace Flux;

/**
 * Interface for configuration parsing.
 */
interface ConfigParserInterface
{
    /**
     * Get all errors that have occurred during runtime.
     *
     * @return array|object Iterable with list of errors that have occurred.
     */
    public function getErrors();

    /**
     * Main parsing method.
     *
     * @param string $arg How to interpret argument is left to implementation
     *   (string or filename, etc).
     *
     * @return array|object Array of data converted or an object
     *   representation.
     */
    public function parse($arg);
}
