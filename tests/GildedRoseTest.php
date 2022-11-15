<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }


    /**
     * @dataProvider systemDataProvider
     */
    public function testItemsCanCalculateSellInAndQualityCorrect(
        string $name,
        int $sellIn,
        int $quality,
        int $expectSellIn,
        int $expectQuality
    ): void {
        $items = [new Item($name, $sellIn, $quality)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals($expectQuality, $items[0]->quality);
        $this->assertEquals($expectSellIn, $items[0]->sell_in);
    }

    public function systemDataProvider(): \Generator
    {
        yield 'AgedBrie item example 1' => [
            'name' => 'Aged Brie',
            'sellIn' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 11
        ];

        yield 'AgedBrie item example 2' => [
            'name' => 'Aged Brie',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 12
        ];

        yield 'AgedBrie item example 3' => [
            'name' => 'Aged Brie',
            'sell_in' => -5,
            'quality' => 10,
            'expectSellIn' => -6,
            'expectQuality' => 12
        ];

        yield 'AgedBrie item example 4' => [
            'name' => 'Aged Brie',
            'sell_in' => 5,
            'quality' => 50,
            'expectSellIn' => 4,
            'expectQuality' => 50
        ];

        yield 'AgedBrie item example 5' => [
            'name' => 'Aged Brie',
            'sell_in' => 0,
            'quality' => 49,
            'expectSellIn' => -1,
            'expectQuality' => 50
        ];

        yield 'AgedBrie item example 6' => [
            'name' => 'Aged Brie',
            'sell_in' => 0,
            'quality' => 50,
            'expectSellIn' => -1,
            'expectQuality' => 50
        ];

        yield 'AgedBrie item example 7' => [
            'name' => 'Aged Brie',
            'sell_in' => -10,
            'quality' => 50,
            'expectSellIn' => -11,
            'expectQuality' => 50
        ];

        yield 'Backstage passes item example 1' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 12
        ];

        yield 'Backstage passes item example 2' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 11,
            'quality' => 10,
            'expectSellIn' => 10,
            'expectQuality' => 11
        ];

        yield 'Backstage passes item example 3' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 5,
            'quality' => 10,
            'expectSellIn' => 4,
            'expectQuality' => 13
        ];

        yield 'Backstage passes item example 4' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 0
        ];

        yield 'Backstage passes item example 5' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 10,
            'quality' => 50,
            'expectSellIn' => 9,
            'expectQuality' => 50
        ];

        yield 'Backstage passes item example 6' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 5,
            'quality' => 50,
            'expectSellIn' => 4,
            'expectQuality' => 50
        ];

        yield 'Backstage passes item example 7' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => -5,
            'quality' => 50,
            'expectSellIn' => -6,
            'expectQuality' => 0
        ];

        yield 'Sulfuras item example 1' => [
            'name' => 'Sulfuras, Hand of Ragnaros',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 10,
            'expectQuality' => 10
        ];

        yield 'Sulfuras item example 2' => [
            'name' => 'Sulfuras, Hand of Ragnaros',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => 0,
            'expectQuality' => 10
        ];

        yield 'Sulfuras item example 3' => [
            'name' => 'Sulfuras, Hand of Ragnaros',
            'sell_in' => -1,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 10
        ];

        yield 'Elixir item example' => [
            'name' => 'Elixir of the Mongoose',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 9
        ];

        yield 'Dexterity item example 1' => [
            'name' => '+5 Dexterity Vest',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 9
        ];

        yield 'Dexterity item example 2' => [
            'name' => '+5 Dexterity Vest',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 8
        ];

        yield 'Dexterity item example 3' => [
            'name' => '+5 Dexterity Vest',
            'sell_in' => -1,
            'quality' => 10,
            'expectSellIn' => -2,
            'expectQuality' => 8
        ];

        yield 'Conjured Mana Cake item example 1' => [
            'name' => 'Conjured Mana Cake',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 8
        ];

        yield 'Conjured Mana Cake item example 2' => [
            'name' => 'Conjured Mana Cake',
            'sell_in' => 10,
            'quality' => 0,
            'expectSellIn' => 9,
            'expectQuality' => 0
        ];

        yield 'Conjured Mana Cake item example 3' => [
            'name' => 'Conjured Mana Cake',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 6
        ];
    }
}
