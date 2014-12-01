# Cache

A PHP package for caching data.

## Install

Normal install via Composer.

## Usage

```php
use Travis\Cache;

$data = array(
	'foor' => 'bar'
);

Cache::set('test', 3, $data); // saves for 3 minutes

$data = Cache::get('test'); // returns array

Cache::forget('test'); // deletes cache

Cache::clear(); // deletes all caches
```