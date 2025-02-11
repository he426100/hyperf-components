# Http logger

[![Latest Stable Version](https://img.shields.io/packagist/v/friendsofhyperf/http-logger)](https://packagist.org/packages/friendsofhyperf/http-logger)
[![Total Downloads](https://img.shields.io/packagist/dt/friendsofhyperf/http-logger)](https://packagist.org/packages/friendsofhyperf/http-logger)
[![License](https://img.shields.io/packagist/l/friendsofhyperf/http-logger)](https://github.com/friendsofhyperf/http-logger)

The http logger component for Hyperf.

## Installation

- Request

```bash
composer require "friendsofhyperf/http-logger:^3.0"
```

- Publish

```bash
php bin/hyperf.php vendor:publish friendsofhyperf/http-logger
```

## Usage

```php
return [
    'http' => [
        \FriendsOfHyperf\Http\Logger\Middleware\HttpLogger::class,
    ],
];
```

## Sponsor

If you like this project, Buy me a cup of coffee. [ [Alipay](https://hdj.me/images/alipay.jpg) | [WePay](https://hdj.me/images/wechat-pay.jpg) ]
