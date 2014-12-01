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

// save for 3 minutes
Cache::set('test', 3, $data);

// save forever
Cache::set('test', 0, $data);

// pass a closure
Cache::set('test', 3, function()
{
	return 'foobar';
});

// get your data
$data = Cache::get('test');

// forget your data
Cache::forget('test');

// clear all caches
Cache::clear();
```