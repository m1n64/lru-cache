<?php
declare(strict_types=1);

namespace Vasqo\LRU\Contracts;

interface SimpleCacheInterface
{

    /**
     * Get all items from cache.
     *
     * @return array<string|int, mixed>
     */
    public function all(): array;


    /**
     * Retrieve the value associated with a given key from the cache.
     *
     * @param string|int $key The key of the cache item to retrieve.
     * @return mixed The value associated with the key, or null if not found.
     */
    public function get(string|int $key): mixed;


    /**
     * Stores a value in the cache.
     *
     * If the cache item with key equal to $key already exists, the value
     * will be overwritten. If the cache is full and no existing item with
     * key equal to $key is found, the least recently used item will be
     * removed and the new value will be stored in the cache.
     *
     * @param string|int $key
     * @param mixed $value
     * @return void
     */
    public function put(string|int $key, mixed $value): void;


    /**
     * Removes a specified item from the cache.
     *
     * Searches the cache for an item with the given key and removes it if found.
     *
     * @param string|int $key The key of the cache item to be removed.
     * @return void
     */
    public function remove(string|int $key): void;


    /**
     * Get the number of items in the cache.
     *
     * @return int The number of items in the cache.
     */
    public function count(): int;
}