# le7-testing
L77 PHP MVC framework testing tools

## Requirements

- PHP 8.1 or higher.
- Composer 2.0 or higher.

## What it can?

it can create mock objects for testing le7 framework.

- ServerRequestInterface
- ResponseInterface
- LoggerInterface
- CacheInterface
- Session
- Cookies

## Installation

```shell
composer require rnr1721/le7-testing
```

## Testing

```shell
composer test
```

## How it works?

```php
use Core\Testing\MegaFactory;

    $megaFactory = new MegaFactory();

    // Get file logger
    $logger = $megaFactory->getLogger(false,'file.log');
    
    // Get ServerRequestInterface
    $request = $megaFactory->getServer()->getServerRequest('http://example.com', 'GET');

    // etc...
```
