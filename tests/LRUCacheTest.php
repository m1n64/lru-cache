<?php

namespace Vasqo\LRU\LRUCache;

use Vasqo\LRU\LRUCache;
use PHPUnit\Framework\TestCase;

class LRUCacheTest extends TestCase
{
    /**
     * @return void
     */
    public function testMain(): void
    {
        $cache = new LRUCache(3);

        $cache->put('a', 1);
        $cache->put('b', 2);
        $cache->put('c', 3);

        $this->assertSame(['c' => 3, 'b' => 2, 'a' => 1], $cache->all());
        $aValue = $cache->get('a');

        $this->assertEquals(1, $aValue);
        $this->assertSame(['a' => 1, 'c' => 3, 'b' => 2], $cache->all());

        $cache->put('d', 4);
        $this->assertSame(['d' => 4, 'a' => 1, 'c' => 3], $cache->all());

        $cache->remove('c');
        $this->assertSame(['d' => 4, 'a' => 1], $cache->all());
    }

    /**
     * @return void
     */
    public function testRealValue(): void
    {
        $cache = new LRUCache(5);

        $cache->put('first', 100);
        $cache->put('second', 200);
        $cache->put('third', 300);
        $cache->put('four', 400);
        $cache->put('five', 500);

        $this->assertSame(['five' => 500, 'four' => 400, 'third' => 300, 'second' => 200, 'first' => 100], $cache->all());

        $threeValue = $cache->get('third');
        $this->assertEquals(300, $threeValue);

        $this->assertSame(['third' => 300, 'five' => 500, 'four' => 400, 'second' => 200, 'first' => 100], $cache->all());

        $cache->put('six', 600);

        $this->assertSame(['six' => 600, 'third' => 300, 'five' => 500, 'four' => 400, 'second' => 200], $cache->all());

        $cache->remove('second');
        $this->assertSame(['six' => 600, 'third' => 300, 'five' => 500, 'four' => 400], $cache->all());

        $cache->put('seven', 700);
        $cache->put('eight', 800);
        $cache->put('nine', 900);

        $this->assertSame(['nine' => 900, 'eight' => 800, 'seven' => 700, 'six' => 600, 'third' => 300], $cache->all());
    }

    /**
     * @return void
     */
    public function testStrings(): void
    {
        $cache = new LRUCache(3);

        $cache->put(1, 'ONE');
        $cache->put(2, 'TWO');
        $cache->put(3, 'THREE');

        $cache->put(2, 'TWO x2');

        $this->assertSame([3 => 'THREE', 2 => 'TWO x2', 1 => 'ONE'], $cache->all());

        $cache->put('four', 'FOUR');
        $this->assertSame(['four' => 'FOUR', 3 => 'THREE', 2 => 'TWO x2'], $cache->all());

        $nullElement = $cache->get(1);
        $this->assertNull($nullElement);

        $twoElement = $cache->get(2);
        $this->assertEquals('TWO x2', $twoElement);

        $this->assertSame([2 => 'TWO x2', 'four' => 'FOUR', 3 => 'THREE'], $cache->all());

        $cache->remove('four');
        $this->assertSame([2 => 'TWO x2', 3 => 'THREE'], $cache->all());
    }
}
