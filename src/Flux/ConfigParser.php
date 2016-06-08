<?php
namespace Flux;

/**
 * Implements `ConfigParserInterface`.
 */
class ConfigParser implements ConfigParserInterface
{
    /**
     * Main regular expression for a valid configuration line.
     *
     * @var string
     */
    const RE = '/^([a-zA-Z](?:[^=]+)?)(?:\s+)?=(?:\s+)?(.*)/';

    /**
     * Regular expression for boolean true strings.
     *
     * @var strings
     */
    const BOOLEAN_TRUE_RE = '/^(on|yes|true)$/';

    /**
     * Regular expression for boolean false strings.
     *
     * @var strings
     */
    const BOOLEAN_FALSE_RE = '/^(off|no|false)$/';

    private $errors = [];

    /**
     * {@inheritDoc}
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Parse a given filename.
     *
     * @param string $filename File path.
     *
     * @return Config Returns new `Config` object with values read.
     *
     * @throws ConfigParserException If the file path is invalid.
     */
    public function parse($filename)
    {
        $config = new Config();
        $handle = @fopen($filename, 'r');

        if ($handle === false) {
            $err = error_get_last();
            throw new ConfigParserException($err['message'], $err['type']);
        }

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if (isset($line[0]) && $line[0] === '#') {
                continue;
            }

            $matches = [];
            preg_match(static::RE, $line, $matches);

            if (!$matches) {
                continue;
            }

            $config[trim($matches[1])] = $this->adjustType(trim($matches[2]));
        }

        // @codeCoverageIgnoreStart
        if (!@feof($handle)) {
            $this->errors[] = error_get_last();
        }
        if (!@fclose($handle)) {
            $this->errors[] = error_get_last();
        }
        // @codeCoverageIgnoreEnd

        return $config;
    }

    private function adjustType($value)
    {
        $svalue = strtolower($value);

        if (preg_match(static::BOOLEAN_TRUE_RE, $svalue)) {
            return true;
        }
        if (preg_match(static::BOOLEAN_FALSE_RE, $svalue)) {
            return false;
        }
        if (preg_match('/^[0-9]+$/', $value)) {
            return (int) $value;
        }
        if (preg_match('/^[0-9]+\.(?:[0-9]+)?$/', $value)) {
            return (float) $value;
        }

        return $value;
    }
}
