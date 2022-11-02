<?php

namespace GildedRose\Items\Products;

use GildedRose\Item;
use GildedRose\Items\ItemStrategy;
use GildedRose\Items\Product;

class Sulfuras extends Product implements ItemStrategy
{
    public function update(): Item
    {
        return $this->item;
    }
}
