<?php
declare(strict_types=1);

namespace Vasqo\LRU\Entities;

final class CacheItem
{
    /**
     * Constructs a new CacheItem instance.
     *
     * @param string|int $key   The key of the cache item.
     * @param mixed      $value The value of the cache item.
     */
    public function __construct(
        private readonly string|int $key,
        private mixed $value
    ) {}

    /**
     * Retrieves the key of the cache item.
     *
     * @return string|int The key of the cache item.
     */
    public function getKey(): string|int
    {
        return $this->key;
    }

    /**
     * Retrieves the value of the cache item.
     *
     * @return mixed The value of the cache item.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Updates the value of the cache item.
     *
     * @param mixed $value The new value of the cache item.
     *
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}