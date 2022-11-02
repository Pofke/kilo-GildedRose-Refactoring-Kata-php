<?php

namespace GildedRose\Items\Products;

use GildedRose\Item;
use GildedRose\Items\ItemStrategy;
use GildedRose\Items\Product;

class Backstage extends Product implements ItemStrategy
{
    private function concertSoonQualityBoost(int $sellInDateMark): void
    {
        if ($this->getSellIn() <= $sellInDateMark) {
            $this->changeQuality(1);
        }
    }

    public function update(): Item
    {
        $this->changeQuality(1);
        $this->concertSoonQualityBoost(10);
        $this->concertSoonQualityBoost(5);
        if ($this->isSellInDateDue()) {
            $this->setQuality(0);
        }
        parent::update();
        return $this->item;
    }
}
