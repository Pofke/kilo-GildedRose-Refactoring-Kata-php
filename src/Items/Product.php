<?php

namespace GildedRose\Items;

use GildedRose\Item;

class Product
{
    protected const QUALITY_MAX =  50;
    protected const DATE_DUE =  0;
    public function __construct(protected readonly Item $item)
    {
    }

    protected function update(): Item
    {
        $this->lowerSellInDate();
        $this->limitQualityMaximum();
        return $this->item;
    }
    protected function isSellInDateDue(): bool
    {
        return $this->getSellIn() <= self::DATE_DUE;
    }
    protected function limitQualityMaximum(): void
    {
        if ($this->isQualityMaximum()) {
            $this->setQuality(self::QUALITY_MAX);
        }
    }
    private function isQualityMaximum(): bool
    {
        return $this->getQuality() > self::QUALITY_MAX;
    }

    protected function lowerSellInDate(int $days = 1): void
    {
        $this->setSellIn($this->getSellIn() - $days);
    }

    protected function setSellIn(int $sellIn): void
    {
        $this->item->sell_in = $sellIn;
    }
    protected function getSellIn(): int
    {
        return $this->item->sell_in;
    }
    protected function getQuality(): int
    {
        return $this->item->quality;
    }
    protected function changeQuality(int $points): void
    {
        $this->item->quality += $points;
    }
    protected function setQuality(int $quality): void
    {
        $this->item->quality = $quality;
    }
}
