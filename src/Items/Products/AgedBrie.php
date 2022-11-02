<?php

namespace GildedRose\Items\Products;

use GildedRose\Item;
use GildedRose\Items\Product;
use GildedRose\Items\ItemStrategy;

class AgedBrie extends Product implements ItemStrategy
{
    public function update(): Item
    {
        $this->changeQuality(1);
        if ($this->isSellInDateDue()) {
            $this->changeQuality(1);
        }
        parent::update();
        return $this->item;
    }
}
