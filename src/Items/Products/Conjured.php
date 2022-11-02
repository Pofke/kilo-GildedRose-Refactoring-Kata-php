<?php

namespace GildedRose\Items\Products;

use GildedRose\Item;
use GildedRose\Items\ItemStrategy;
use GildedRose\Items\Product;

class Conjured extends Product implements ItemStrategy
{
    public function update(): Item
    {
        $this->changeQuality(-2);
        if ($this->isSellInDateDue()) {
            $this->changeQuality(-2);
        }
        if ($this->getQuality() < 0) {
            $this->setQuality(0);
        }
        parent::update();
        return $this->item;
    }
}
