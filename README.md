[![Build Status](https://travis-ci.org/Tatsh/gifnocxulfni.svg?branch=master)](https://travis-ci.org/Tatsh/gifnocxulfni)

# Usage

Use Composer or use a simple auto-loader like this one:

```php
spl_autoload_register(function ($class) {
    include sprintf('%s/../src/%s.php', dirname(__FILE__), str_replace('\\', '/', $class));
});
```

```php
use Flux\ConfigParser;

$parser = new ConfigParser();
$config = $parser->parse('myconfig');

// Set a value (array syntax)
$config['key'] = 1;

// Set a value
$config->set('key', 1);

// Get a value
$val = $config->get('key', 'default');

// Get a value, no helper for default
$val = $config['key'];
```

# Running tests

`composer update` and run `phpunit`.
