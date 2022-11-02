<?php

namespace GildedRose\Items\Products;

use GildedRose\Item;
use GildedRose\Items\ItemStrategy;
use GildedRose\Items\Product;

class DefaultProduct extends Product implements ItemStrategy
{
    public function update(): Item
    {
        $this->changeQuality(-1);
        if ($this->isSellInDateDue()) {
            $this->changeQuality(-1);
        }
        parent::update();
        return $this->item;
    }
}
