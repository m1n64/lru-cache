<?php
declare(strict_types=1);

namespace Vasqo\LRU;


use SplDoublyLinkedList;
use Vasqo\LRU\Contracts\SimpleCacheInterface;
use Vasqo\LRU\Entities\CacheItem;

class LRUCache implements SimpleCacheInterface
{
    /**
     * @var SplDoublyLinkedList<int, CacheItem>
     */
    private SplDoublyLinkedList $cacheList;


    /**
     * Construct a new instance of the cache with the given capacity.
     *
     * @param int $capacity The maximum number of items the cache can hold.
     */
    public function __construct(
        private readonly int $capacity,
    )
    {
        $this->cacheList = new SplDoublyLinkedList();
    }


    /**
     * Get all items from cache.
     *
     * @return array<string|int, mixed>
     */
    public function all(): array
    {
        $items = [];
        foreach ($this->cacheList as $cacheItem) {
            $items[$cacheItem->getKey()] = $cacheItem->getValue();
        }

        return $items;
    }


    /**
     * Retrieve the value associated with a given key from the cache.
     *
     * Searches the cache for an item with the specified key. If found,
     * the item is returned and moved to the front of the cache to mark
     * it as most recently used. If not found, null is returned.
     *
     * @param string|int $key The key of the cache item to retrieve.
     * @return mixed The value associated with the key, or null if not found.
     */
    public function get(string|int $key): mixed
    {
        foreach ($this->cacheList as $k => $v) {
            if ($v->getKey() === $key) {
                $cacheItem = $v->getValue();

                $this->cacheList->offsetUnset($k);
                $this->cacheList->unshift($v);
                return $cacheItem;
            }
        }

        return null;
    }


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
    public function put(string|int $key, mixed $value): void
    {
        foreach ($this->cacheList as $k => $v) {
            if ($v->getKey() === $key) {
                $this->cacheList->offsetUnset($k);
                $this->cacheList->unshift(new CacheItem($key, $value));
                return;
            }
        }

        $this->cacheList->unshift(new CacheItem($key, $value));

        if ($this->cacheList->count() > $this->capacity) {
            $this->cacheList->pop();
        }
    }


    /**
     * Removes a specified item from the cache.
     *
     * Searches the cache for an item with the given key and removes it if found.
     *
     * @param string|int $key The key of the cache item to be removed.
     * @return void
     */
    public function remove(string|int $key): void
    {
        foreach ($this->cacheList as $k => $v) {
            if ($v->getKey() == $key) {
                $this->cacheList->offsetUnset($k);
                break;
            }
        }
    }

    /**
     * Get the number of items in the cache.
     *
     * @return int The number of items in the cache.
     */
    public function count(): int
    {
        return $this->cacheList->count();
    }

    /**
     * Get the capacity of the cache.
     *
     * @return int The maximum number of items the cache can hold.
     */
    public function capacity(): int
    {
        return $this->capacity;
    }
}