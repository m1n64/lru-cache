# LRU Cache realisation

## Description

`LRUCache` is an implementation of a cache based on the Least Recently Used (LRU) algorithm, which automatically removes the least recently used items when the specified capacity limit is reached. This class is useful for optimizing performance by retaining only the most relevant data.

## Installation

Make sure you have PHP version 8.1 or higher installed. You can install this package via Composer:

```bash
composer require m1n64/lru-cache
```

## Usage

### Example
```php
<?php

require 'vendor/autoload.php';

use Vasqo\LRU\LRUCache;

$cache = new LRUCache(3); // Create a cache with a capacity of 3 items

$cache->put('a', 1);
$cache->put('b', 2);
$cache->put('c', 3);

// Get an item
echo $cache->get('a'); // 1

$cache->put('d', 4); // 'b' will be removed as it is the least used

// Get all items
print_r($cache->all()); // ['a' => 1, 'c' => 3, 'd' => 4]

// Remove an item
$cache->remove('a');
print_r($cache->all()); // ['c' => 3, 'd' => 4]
```

## Tests

To run the tests, run the following command:

```bash
composer test
```

## Methods
* `__construct(int $capacity)`: Creates a new instance of the cache with the specified capacity.
* `all(): array`: Returns all items in the cache.
* `get(string|int $key): mixed`: Retrieves an item by key. If the item is found, it is moved to the front of the cache.
* `put(string|int $key, mixed $value): void`: Adds an item to the cache or updates an existing one. If the cache is full, the least recently used item will be removed.
* `remove(string|int $key): void`: Removes an item by key.
* `count(): int`: Returns the number of items in the cache.
* `capacity(): int`: Returns the maximum capacity of the cache.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.

## Author
* m1n64

Feel free to modify any part of it as needed!