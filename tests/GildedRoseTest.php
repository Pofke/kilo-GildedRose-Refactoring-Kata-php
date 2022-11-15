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
    public function testAllSystemIsCorrect(
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
        yield 'testAgedBrieTypeBeforeSellInDateUpdatesNormally' => [
            'name' => 'Aged Brie',
            'sellIn' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 11
        ];

        yield 'testAgedBrieTypeOnSellInDateUpdatesNormally' => [
            'name' => 'Aged Brie',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 12
        ];

        yield 'testAgedBrieTypeAfterSellInDateUpdatesNormally' => [
            'name' => 'Aged Brie',
            'sell_in' => -5,
            'quality' => 10,
            'expectSellIn' => -6,
            'expectQuality' => 12
        ];

        yield 'testAgedBrieTypeBeforeSellInDateWithMaximumQuality' => [
            'name' => 'Aged Brie',
            'sell_in' => 5,
            'quality' => 50,
            'expectSellIn' => 4,
            'expectQuality' => 50
        ];

        yield 'testAgedBrieTypeOnSellInDateNearMaximumQuality' => [
            'name' => 'Aged Brie',
            'sell_in' => 0,
            'quality' => 49,
            'expectSellIn' => -1,
            'expectQuality' => 50
        ];

        yield 'testAgedBrieTypeOnSellInDateWithMaximumQuality' => [
            'name' => 'Aged Brie',
            'sell_in' => 0,
            'quality' => 50,
            'expectSellIn' => -1,
            'expectQuality' => 50
        ];

        yield 'testAgedBrieTypeAfterSellInDateWithMaximumQuality' => [
            'name' => 'Aged Brie',
            'sell_in' => -10,
            'quality' => 50,
            'expectSellIn' => -11,
            'expectQuality' => 50
        ];

        yield 'testBackstagePassBeforeSellOnDateUpdatesNormally' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 12
        ];

        yield 'testBackstagePassMoreThanTenDaysBeforeSellOnDateUpdatesNormally' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 11,
            'quality' => 10,
            'expectSellIn' => 10,
            'expectQuality' => 11
        ];

        yield 'testBackstagePassUpdatesByThreeWithFiveDaysLeftToSell' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 5,
            'quality' => 10,
            'expectSellIn' => 4,
            'expectQuality' => 13
        ];

        yield 'testBackstagePassDropsToZeroAfterSellInDate' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 0
        ];

        yield 'testBackstagePassCloseToSellInDateWithMaxQuality' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 10,
            'quality' => 50,
            'expectSellIn' => 9,
            'expectQuality' => 50
        ];

        yield 'testBackstagePassVeryCloseToSellInDateWithMaxQuality' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => 5,
            'quality' => 50,
            'expectSellIn' => 4,
            'expectQuality' => 50
        ];

        yield 'testBackstagePassQualityZeroAfterSellDate' => [
            'name' => 'Backstage passes to a TAFKAL80ETC concert',
            'sell_in' => -5,
            'quality' => 50,
            'expectSellIn' => -6,
            'expectQuality' => 0
        ];

        yield 'testSulfurasBeforeSellInDate' => [
            'name' => 'Sulfuras, Hand of Ragnaros',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 10,
            'expectQuality' => 10
        ];

        yield 'testSulfurasOnSellInDate' => [
            'name' => 'Sulfuras, Hand of Ragnaros',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => 0,
            'expectQuality' => 10
        ];

        yield 'testSulfurasAfterSellInDate' => [
            'name' => 'Sulfuras, Hand of Ragnaros',
            'sell_in' => -1,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 10
        ];

        yield 'testElixirBeforeSellInDateUpdatesNormally' => [
            'name' => 'Elixir of the Mongoose',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 9
        ];

        yield 'testDexterityVestBeforeSellInDateUpdatesNormally' => [
            'name' => '+5 Dexterity Vest',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 9
        ];

        yield 'testDexterityVestOnSellInDateQualityDegradesTwiceAsFast' => [
            'name' => '+5 Dexterity Vest',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 8
        ];

        yield 'testDexterityVestAfterSellInDateQualityDegradesTwiceAsFast' => [
            'name' => '+5 Dexterity Vest',
            'sell_in' => -1,
            'quality' => 10,
            'expectSellIn' => -2,
            'expectQuality' => 8
        ];

        yield 'testConjuredBeforeSellInDateUpdatesNormally' => [
            'name' => 'Conjured Mana Cake',
            'sell_in' => 10,
            'quality' => 10,
            'expectSellIn' => 9,
            'expectQuality' => 8
        ];

        yield 'testConjuredDoesNotDegradePassedZero' => [
            'name' => 'Conjured Mana Cake',
            'sell_in' => 10,
            'quality' => 0,
            'expectSellIn' => 9,
            'expectQuality' => 0
        ];

        yield 'testConjuredAfterSellInDateDegradesTwiceAsFast' => [
            'name' => 'Conjured Mana Cake',
            'sell_in' => 0,
            'quality' => 10,
            'expectSellIn' => -1,
            'expectQuality' => 6
        ];
    }
}
