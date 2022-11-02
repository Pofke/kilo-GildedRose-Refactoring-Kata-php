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


    public function testAgedBrieTypeBeforeSellInDateUpdatesNormally(): void
    {
        $items = [new Item('Aged Brie', 10, 10), new Item('Aged Brie', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(11, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);


        $this->assertEquals(12, $items[1]->quality);
        $this->assertEquals(-1, $items[1]->sell_in);
    }

    public function testAgedBrieTypeOnSellInDateUpdatesNormally(): void
    {
        $items = [new Item('Aged Brie', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(12, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    public function testAgedBrieTypeAfterSellInDateUpdatesNormally(): void
    {
        $items = [new Item('Aged Brie', -5, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(12, $items[0]->quality);
        $this->assertEquals(-6, $items[0]->sell_in);
    }

    public function testAgedBrieTypeBeforeSellInDateWithMaximumQuality(): void
    {
        $items = [new Item('Aged Brie', 5, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(50, $items[0]->quality);
        $this->assertEquals(4, $items[0]->sell_in);
    }

    public function testAgedBrieTypeOnSellInDateNearMaximumQuality(): void
    {
        $items = [new Item('Aged Brie', 0, 49)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(50, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    public function testAgedBrieTypeOnSellInDateWithMaximumQuality(): void
    {
        $items = [new Item('Aged Brie', 0, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(50, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    public function testAgedBrieTypeAfterSellInDateWithMaximumQuality(): void
    {
        $items = [new Item('Aged Brie', -10, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(50, $items[0]->quality);
        $this->assertEquals(-11, $items[0]->sell_in);
    }

    public function testBackstagePassBeforeSellOnDateUpdatesNormally(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(12, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }

    public function testBackstagePassMoreThanTenDaysBeforeSellOnDateUpdatesNormally(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 11, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(11, $items[0]->quality);
        $this->assertEquals(10, $items[0]->sell_in);
    }

    public function testBackstagePassUpdatesByThreeWithFiveDaysLeftToSell(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(13, $items[0]->quality);
        $this->assertEquals(4, $items[0]->sell_in);
    }

    public function testBackstagePassDropsToZeroAfterSellInDate(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(0, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    public function testBackstagePassCloseToSellInDateWithMaxQuality(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(50, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }

    public function testBackstagePassVeryCloseToSellInDateWithMaxQuality(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 5, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(50, $items[0]->quality);
        $this->assertEquals(4, $items[0]->sell_in);
    }

    public function testBackstagePassQualityZeroAfterSellDate(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', -5, 50)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(0, $items[0]->quality);
        $this->assertEquals(-6, $items[0]->sell_in);
    }

    public function testSulfurasBeforeSellInDate(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(10, $items[0]->quality);
        $this->assertEquals(10, $items[0]->sell_in);
    }

    public function testSulfurasOnSellInDate(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(10, $items[0]->quality);
        $this->assertEquals(0, $items[0]->sell_in);
    }

    public function testSulfurasAfterSellInDate(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', -1, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(10, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    public function testElixirBeforeSellInDateUpdatesNormally(): void
    {
        $items = [new Item('Elixir of the Mongoose', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(9, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }

    public function testDexterityVestBeforeSellInDateUpdatesNormally(): void
    {
        $items = [new Item('+5 Dexterity Vest', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(9, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }
    public function testDexterityVestOnSellInDateQualityDegradesTwiceAsFast(): void
    {
        $items = [new Item('+5 Dexterity Vest', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(8, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }

    public function testDexterityVestAfterSellInDateQualityDegradesTwiceAsFast(): void
    {
        $items = [new Item('+5 Dexterity Vest', -1, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(8, $items[0]->quality);
        $this->assertEquals(-2, $items[0]->sell_in);
    }

    public function testConjuredBeforeSellInDateUpdatesNormally()
    {

        $items = [new Item('Conjured Mana Cake', 10, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(8, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }
    public function testConjuredDoesNotDegradePassedZero()
    {
        $items = [new Item('Conjured Mana Cake', 10, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(0, $items[0]->quality);
        $this->assertEquals(9, $items[0]->sell_in);
    }
    public function testConjuredAfterSellInDateDegradesTwiceAsFast()
    {
        $items = [new Item('Conjured Mana Cake', 0, 10)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        $this->assertEquals(6, $items[0]->quality);
        $this->assertEquals(-1, $items[0]->sell_in);
    }
}
